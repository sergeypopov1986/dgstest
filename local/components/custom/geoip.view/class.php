<?php
namespace custom;


class GeoipViewComponent extends \CBitrixComponent
{

    public function onPrepareComponentParams($arParams)
    {
        return parent::onPrepareComponentParams($arParams);
    }

    public function execute() {
        $geo = new \GeoIP;
        $ip = $_SERVER['HTTP_CLIENT_IP'];
        $this->arResult['GEODATA'] = $geo->GetGeoDataByIP();
        $this->includeComponentTemplate();
    }

    public function executeComponent() {
        $result = [];

        try {
            $result = $this->execute();
        } catch (\Exception $e) {
            $this->catchException($e);
        }

        return $result;
    }
}