<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_IBLOCK_ID_71"),
			"TYPE" => "STRING",
            "PARENT" => "BASE"
		),
        "CLASSIF_IBLOCK_ID" => array(
            "NAME" => GetMessage("SIMPLECOMP_IBLOCK_CLASSIF_71"),
            "TYPE" => "STRING",
            "PARENT" => "BASE"
        ),
        "TEMPLATE" => array(
            "NAME" => GetMessage("SIMPLECOMP_IBLOCK_TEMPLATE_71"),
            "TYPE" => "STRING",
            "PARENT" => "BASE"
        ),
        "PROPERTY_CODE" => array(
            "NAME" => GetMessage("SIMPLECOMP_IBLOCK_PROPERTY_71"),
            "TYPE" => "STRING",
            "PARENT" => "BASE"
        ),
        "CACHE_TIME" => array("DEFAULT" => 36000000),
        "CACHE_GROUPS" => array(
            "PARENT" => "CACHE_SETTINGS",
            "NAME" => GetMessage("ON_ACCESS_RIGHT"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ),
	),
);