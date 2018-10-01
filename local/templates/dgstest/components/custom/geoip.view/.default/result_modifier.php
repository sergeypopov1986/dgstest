<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?
if($arResult['USERS']){
    foreach ($arResult['USERS'] as &$user) {
        $unserialized = unserialize($user['UF_GEODATA']);
        $user = array_merge($user , $unserialized);
    }
}
