<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?>
<?$APPLICATION->IncludeComponent(
    "custom:geoip.view" ,
    '.default' ,
    []
)?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>