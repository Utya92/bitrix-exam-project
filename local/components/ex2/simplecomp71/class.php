<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

class SimpleComponent71 extends CBitrixComponent {

    //массив активных элементов (брендов) из иб фирма-производитель
    protected array $arClassif = array();

    //массив айдишек активных элементов (брендов) из иб фирма-производитель
    protected array $arClassifId = array();

    public function onPrepareComponentParams($arParams): array {
        if (!Loader::includeModule("iblock")) {
            ShowError(Loc::getMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
        }

        if (!isset($arParams["CACHE_TIME"])) {
            $arParams["CACHE_TIME"] = 36000000;
        }
        if (!isset($arParams["PRODUCTS_IBLOCK_ID"])) {
            $arParams["PRODUCTS_IBLOCK_ID"] = 0;
        }
        if (!isset($arParams["CLASSIF_IBLOCK_ID"])) {
            $arParams["CLASSIF_IBLOCK_ID"] = 0;
        }
        $arParams["PROPERTY_CODE"] = trim($arParams["PROPERTY_CODE"]);

        return
            $arParams;
    }

    public function executeComponent(): void {
        global $USER;
        //устанавливаем кэшу зависимость от группы юзерв
        if ($this->startResultCache(false, $USER->GetGroups())) {
            $this->getActiveElementsFromFirmaProizvoditel();
            $this->getActiveElementsFromIblockProductsWithLinkToFirmaProizvoditel();
            $this->includeComponentTemplate();
            $this->SetResultCacheKeys(array("COUNT_SECTIONS"));
            global $APPLICATION;
            $APPLICATION->SetTitle(Loc::getMessage("TITLE", array(
                "#COUNT#" => $this->arResult["COUNT_SECTIONS"])));
        } else {
            $this->abortResultCache();
        }
    }

    //получение списка активных элементов из инфоблока фирама-произодитель
    function getActiveElementsFromFirmaProizvoditel(): void {

        $arFilter = array(
            "IBLOCK_ID" => $this->arParams["CLASSIF_IBLOCK_ID"],
            "ACTIVE" => "Y",
            "CHECK_PERMISSIONS" => $this->arParams["CACHE_GROUPS"]
        );

        $arSelect = array(
            "ID",
            "IBLOCK_ID",
            "NAME"
        );

        $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);

        while ($temp = $res->Fetch()) {
            $this->arClassif[$temp["ID"]] = $temp;
            $this->arClassifId[] = $temp["ID"];
        }
    }

    //получение элементов из иб продукция у которых есть привязка к иб фирма-производитель
    function getActiveElementsFromIblockProductsWithLinkToFirmaProizvoditel(): void {
        $arFilter = array(
            "IBLOCK_ID" => $this->arParams["PRODUCTS_IBLOCK_ID"],
            "ACTIVE" => "Y",
            "CHECK_PERMISSIONS" => $this->arParams["CACHE_GROUPS"],
            "PROPERTY_" . $this->arParams["PROPERTY_CODE"] => $this->arClassifId
        );

        $arSelect = array(
            "ID",
            "IBLOCK_ID",
            "IBLOCK_SECTION_ID",
            "NAME",
            "DETAIL_PAGE_URL",
        );

        $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);

        while ($temp = $res->GetNextElement()) {
            //получение полей и свойств товаров иб продукция имеющих привязку к иб фирма-производитель
            $productFields = $temp->GetFields();
            $productFields["PROPERTY"] = $temp->GetProperties();
            //у каждого товара есть значения-привязки к фирмам
            foreach ($productFields["PROPERTY"]["FIRM"]["VALUE"] as $i) {
                $this->arClassif[$i]["LINK_ELEMENTS"][$productFields["ID"]] = $productFields;
            }
        }
        $this->arResult["CLASSIF"] = $this->arClassif;
        $this->arResult["COUNT_SECTIONS"] = count($this->arClassifId);
    }
}