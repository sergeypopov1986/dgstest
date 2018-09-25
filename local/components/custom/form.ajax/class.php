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
        'FA_NAME' => ['htmlspecial'],
        'FA_PHONE' => ['validPhone'],
        'SESSID' => ['validSession'],
    ];

    protected $fieldsValid = [];

    protected function isAjax(){
        return \Bitrix\Main\Context::getCurrent()->getRequest()->isPost()
            && \Bitrix\Main\Context::getCurrent()->getRequest()->isAjaxRequest();
    }

    private function validPhone($val){
        if(!preg_match(self::PHONE_PREG , $val)){
            $this->arResult['ERRORS']['FA_PHONE'] = Loc::getMessage('FA_ERROR_PHONE_FORMAT');
        }else{
            $this->fieldsValid['PHONE'] = $val;
        }
    }

    private function validSession($val){
        if(!check_bitrix_sessid('SESSID')){
            $this->arResult['ERRORS']['SESSID'] = Loc::getMessage('FA_ERROR_SESSION_EXPIRED');
        }
    }

    private function htmlspecial($val){
        if($val)
            $this->fieldsValid['NAME'] = htmlspecialcharsEx($val);
    }

    protected function validateFormFields(){
        foreach ($this->fieldValidateCallbacks as $nameField => $callbacks) {
            if($callbacks){
                foreach ($callbacks as $callback) {
                    filter_input(INPUT_POST, $nameField, FILTER_CALLBACK, array('options' => [$this , $callback]));
                }
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
        if($this->fieldsValid['PHONE']){
            $ib = new CIBlockElement;
            $res = $ib->Add([
                "NAME" => "Заявка". (($this->fieldsValid["NAME"])?" от ".$this->fieldsValid["NAME"]:''),
                "ACTIVE" => "Y",
                "IBLOCK_ID" => IBLOCK_PROPOSAL_ID,
                "PROPERTY_VALUES" => $this->fieldsValid
            ]);
        }
    }

    protected function sendEmail(){
        $this->fieldsValid['TITLE'] = "Заявка". (($this->fieldsValid["NAME"])?" от ".$this->fieldsValid["NAME"]:'');
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