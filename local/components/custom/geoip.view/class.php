<?php
namespace custom;

use Bitrix\Iblock\Component\Tools;

class GeoipViewComponent extends \CBitrixComponent
{
    public $IPS = [
        '177.160.245.160',
        '103.74.41.15',
        '2.0.172.71',
        '31.185.53.70',
        '228.172.31.64',
        '66.139.109.210',
        '182.71.41.52',
        '55.82.159.127',
        '170.146.181.151',
        '91.20.158.79',
        '87.130.54.146',
        '237.27.59.133',
        '184.40.188.223',
        '134.250.159.160',
        '227.0.14.249',
        '243.108.31.59',
        '54.4.90.64',
        '201.225.168.66',
        '30.72.144.43',
        '54.71.251.197',
        '227.169.132.17',
        '54.53.15.170',
        '22.217.213.130',
        '14.235.243.180',
        '84.1.133.12',
        '123.22.64.82',
        '41.181.67.148',
        '4.191.48.91',
        '42.244.154.5',
        '90.80.232.236',
        '85.173.130.144'
    ];

    public function onPrepareComponentParams($arParams)
    {
        return parent::onPrepareComponentParams($arParams);
    }

    public function execute() {
        $geo = new \GeoIP;
        $usrData = new \UserData;
        $sessionId = bitrix_sessid_val();
        $arRes = $usrData->getList([
            'filter' => [
                'UF_USER_SESS_ID' => $sessionId
            ]
        ]);
        $rndIp = $this->IPS[rand(0 , count($this->IPS))];
        //$this->arResult['GEODATA'] = $geo->GetGeoDataByIP($rndIp);
        $this->arResult['GEODATA'] = $geo->GetGeoDataByIP('85.173.130.144');
        if($arRes->fetch() === false && $this->arResult['GEODATA']['CITY']){
            $usrData->insert(
                [
                    'UF_USER_SESS_ID' => $sessionId,
                    'UF_USER_IP' => $geo->GetClientIP(),
                    'UF_CITY' => $this->arResult['GEODATA']['CITY'],
                    'UF_GEODATA' => serialize($this->arResult['GEODATA'])
                ]
            );
        }
        if($this->arResult['GEODATA']['CITY']){
            $arRes = $usrData->getList([
                'filter' => [
                    'UF_CITY' => $this->arResult['GEODATA']['CITY'],
                    '!UF_USER_SESS_ID' => $sessionId,
                ]
            ]);
            $this->arResult['USERS'] = $arRes->fetchAll();
        }
        $this->includeComponentTemplate();
    }

    public function executeComponent() {
        $result = [];

        try {
            $result = $this->execute();
        } catch (\Exception $e) {
            Tools::process404(
                trim($e->getMessage())
                ,true
                ,"Y"
                ,"Y"
            );
        }

        return $result;
    }
}