<?php

class GeoIP
{
    private $soapUrl = 'http://ws.cdyne.com/ip2geo/ip2geo.asmx?WSDL';
    private $soapClient;
    public function __construct(){
        $this->soapClient = new SoapClient($this->soapUrl , array('soap_version'   => SOAP_1_2));
    }

    public function GetClientIP()
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = @$_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
        elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
        else $ip = $remote;

        return $ip;
    }

    public function GetGeoDataByIP($ip){
        try{
            $responce = $this->soapClient->ResolveIP(
                [
                    "ipAddress" => ($ip)?$ip:$this->GetClientIP(),
                    "licenseKey" => "0"
                ]
            );
            $result['COUNTRY'] = $responce->ResolveIPResult->Country;
            $result['CITY'] = $responce->ResolveIPResult->City;
            $result['COORDS'] = [
                'LAT' => $responce->ResolveIPResult->Latitude,
                'LNG' => $responce->ResolveIPResult->Longitude
            ];
        }catch(SoapFault $e){
            echo $e->getMessage();
        }
        return $result;
    }
}
