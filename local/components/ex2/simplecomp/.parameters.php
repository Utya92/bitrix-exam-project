<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arComponentParameters = array(
    "PARAMETERS" => array(
        //айди инфоблока продукции
        "PRODUCTS_IBLOCK_ID" => array(
            "NAME" => GetMessage("PRODUCTS_IBLOCK_ID_70"),
            "TYPE" => "STRING",
            //задаем параметры как базовые
            "PARENT" => "BASE",
        ),
        //айди нфоблока новостей
        "NEWS_IBLOCK_ID" => array(
            "NAME" => GetMessage("NEWS_IBLOCK_ID_70"),
            "TYPE" => "STRING",
            "PARENT" => "BASE",
        ),
        //код привзяки, он же по ТЗ UF_NEWS_LINK
        "USER_PROPERTY" => array(
            "NAME" => GetMessage("USER_PROPERTY_70"),
            "TYPE" => "STRING",
            "PARENT" => "BASE",
        ),
        "CACHE_TIME" => array("DEFAULT" => 36000000),
    ),
);