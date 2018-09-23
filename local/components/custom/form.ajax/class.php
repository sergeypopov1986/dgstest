<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)
    die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;

Loc::loadMessages(__FILE__);

class FormAjaxComponent extends \CBitrixComponent
{
    protected $needModules = ['iblock'];

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

    public function execute(){
        $this->includeComponentTemplate();
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