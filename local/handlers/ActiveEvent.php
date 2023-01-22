<?php
namespace MyHandlers;

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;
use CIBlockElement;

Loc::loadMessages(__FILE__);

class ActiveEvent {
    const CURRENT_ID_IBLOCK_PRODUCTS = 2;
    const MAX_SET_VIEWS = 2;

    function OnBeforeIBlockElementUpdateHandler(&$arFields): bool {
        if ($arFields["IBLOCK_ID"] == self::CURRENT_ID_IBLOCK_PRODUCTS
            && $arFields["ACTIVE"] == "N") {

            $arSelect = array(
                "ID",
                "IBLOCK_ID",
                "NAME",
                "SHOW_COUNTER"
            );

            $arFilter = array(
                "IBLOCK_ID" => self::CURRENT_ID_IBLOCK_PRODUCTS,
                //id текущего товара
                "ID" => $arFields["ID"]
            );

            $res = CIBlockElement::GetList(
                array(),
                $arFilter,
                false,
                false,
                $arSelect);

            $ob = $res->Fetch();

            if (self::MAX_SET_VIEWS < $ob["SHOW_COUNTER"]) {
                $text = Loc::getMessage("ACTIVE_EVENT", array("#COUNT#" => $ob["SHOW_COUNTER"]));
                global $APPLICATION;
                $APPLICATION->throwException($text);
                return false;
            }
        }
        return true;
    }
}