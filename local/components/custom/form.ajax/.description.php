<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
    "NAME" => GetMessage("FA_NAME"),
    "DESCRIPTION" => GetMessage("FA_DESCR"),
    "ICON" => "",
    "PATH" => array(
        "ID" => "base",
        "CHILD" => array(
            "ID" => "form",
            "NAME" => GetMessage("FA_GROUP_NAME")
        )
    ),
);
?>