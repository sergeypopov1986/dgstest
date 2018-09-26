<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)
    die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;

Loc::loadMessages(__FILE__);

class FormAjaxComponent extends \CBitrixComponent
{
    const PHONE_PREG = "/^(\+?[0-9]{1,3})?(\s?\(?[0-9]{2,4}\)?\s?)?([0-9]{2,4}-?\s?){1,3}$/";

    protected $needModules = ['iblock'];
    protected $fieldValidateCallbacks = [
        'FA_NAME' => FILTER_SANITIZE_ENCODED,
        'FA_PHONE' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => ['regexp' => self::PHONE_PREG]
        ]
    ];

    protected $fieldsValid = [];

    protected function isAjax(){
        return \Bitrix\Main\Context::getCurrent()->getRequest()->isPost()
            && \Bitrix\Main\Context::getCurrent()->getRequest()->isAjaxRequest();
    }

    protected function validateFormFields(){
        $this->fieldsValid = filter_input_array(INPUT_POST , $this->fieldValidateCallbacks , false);
    }

    protected function prepareValidatedFields(){
        foreach ($this->fieldsValid as $name => $field) {
            if($field === false){
                $this->arResult['ERRORS'][$name] = Loc::getMessage($name.'_VALIDATE_ERROR');
            }
        }
    }

    protected function checkModules() {
        if (empty($this->needModules)) {
            return false;
        }

        foreach ($this->needModules as $module) {
            if (!Loader::includeModule($module)) {
                throw new LoaderException('Failed include module "'.$module.'"');
            }
        }
    }

    protected function saveData(){
        $cib = new CIBlockElement;
        if($this->fieldsValid['FA_PHONE']){
            $ib = new CIBlockElement;
            $res = $ib->Add([
                "NAME" => "Заявка". (($this->fieldsValid["FA_NAME"])?" от ".$this->fieldsValid["FA_NAME"]:''),
                "ACTIVE" => "Y",
                "IBLOCK_ID" => IBLOCK_PROPOSAL_ID,
                "PROPERTY_VALUES" => $this->fieldsValid
            ]);
        }
    }

    protected function sendEmail(){
        $this->fieldsValid['TITLE'] = "Заявка". (($this->fieldsValid["FA_NAME"])?" от ".$this->fieldsValid["FA_NAME"]:'');
        CEvent::Send(PROPOSAL_EMAIL_EVENT, SITE_ID, $this->fieldsValid);
    }

    protected function actions(){
        if(!$this->arResult['ERRORS']){
            $this->saveData();
            $this->sendEmail();
            $this->arResult['SUCCESS'] = Loc::getMessage('FA_SUCCESS_MESSAGE');
        }
    }

    public function execute(){
        global $APPLICATION;
        if ($this->isAjax()) {
            $APPLICATION->RestartBuffer();
        }
        $this->validateFormFields();
        $this->prepareValidatedFields();
        $this->actions();
        if ($this->isAjax()) {
            die(json_encode($this->arResult));
        }else{
            $this->includeComponentTemplate();
        }
    }

    public function executeComponent()
    {
        try {
            $this->execute();
        } catch (\Exception $e) {
            $this->catchException($e);
        }
    }
}