<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arComponentParameters = array(
    "PARAMETERS" => array(
        "NEWS_IBLOCK_ID" => array(
            "NAME" => GetMessage("NEWS_IBLOCK_ID"),
            "TYPE" => "STRING",
            "PARENT" => "BASE"
        ),
        "AUTHOR_IBLOCK_CODE" => array(
            "NAME" => GetMessage("AUTHOR_IBLOCK_CODE"),
            "TYPE" => "STRING",
            "PARENT" => "BASE"
        ),
        "AUTHOR_PROPERTY_UF_CODE" => array(
            "NAME" => GetMessage("AUTHOR_PROPERTY_UF_CODE"),
            "TYPE" => "STRING",
            "PARENT" => "BASE"
        ),

        "CACHE_TIME" => array("DEFAULT" => 36000000),
        "CACHE_GROUPS" => array(
            "PARENT" => "CACHE_SETTINGS",
            "NAME" => GetMessage("CP_BNL_CACHE_GROUPS"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ),
    ),
);