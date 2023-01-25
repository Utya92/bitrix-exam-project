<?php
namespace MyHandlers;

use Bitrix\Main\Loader;
use CIBlockElement;

class SeoTools {
    function OnBeforePrologHandler() {
        global $APPLICATION;
        $currentPageDirectory = $APPLICATION->GetCurDir();
        if (Loader::includeModule("iblock")) {
            $arFilter = array(
                "IBLOCK_ID" => 5,
                "NAME" => $currentPageDirectory
            );
            $arSelect = array(
                "IBLOCK_ID",
                "ID",
                "PROPERTY_TITLE",
                "PROPERTY_DESCRIPTION",
            );

            $ob = CIBlockElement::GetList(
                array(),
                $arFilter,
                false,
                false,
                $arSelect
            );
            if ($res = $ob->Fetch()) {
                debug($res);
                $APPLICATION->SetPageProperty("title", $res["PROPERTY_TITLE_VALUE"]);
                $APPLICATION->SetPageProperty("description", $res["PROPERTY_DESCRIPTION_VALUE"]);
            }
        }
    }
}