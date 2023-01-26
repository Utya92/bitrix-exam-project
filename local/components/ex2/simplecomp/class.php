<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

class SimpleComponent70 extends CBitrixComponent {

    //храним айди новостей, всего 3
    protected array $arNewsId = [];

    //храним все новости, всего 3
    protected array $arNews = [];

    //айди всех активных разделов продукции
    protected array $activeSectionsProductsId = array();
    //все активные разделы инфоблока продукция
    protected array $activeProductsSections = array();

    public function onPrepareComponentParams($arParams) {
        //если модуль Информационные блоки (iblock) не устновлен,
        // выдавать сообщение через D7 версию гет месседж
        if (!Loader::includeModule("iblock")) {
            ShowError(Loc::getMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
        }

        if (!isset($arParams["CACHE_TIME"])) {
            $arParams["CACHE_TIME"] = 36000000;
        }
        if (!isset($arParams["PRODUCTS_IBLOCK_ID"])) {
            $arParams["PRODUCTS_IBLOCK_ID"] = 0;
        }
        if (!isset($arParams["NEWS_IBLOCK_ID"])) {
            $arParams["NEWS_IBLOCK_ID"] = 0;
        }
        return
            $arParams;
    }

    public function executeComponent() {
        //если кэш есть, то вернется html вёрстка
        if ($this->startResultCache()) {
            $this->getActiveNewsFromIblockNews();
            $this->getActiveSectionsFromProductIblock();
            $this->getActiveGoodsFromIblockProducts();
            $this->getResult();
            $this->includeComponentTemplate();
            global $APPLICATION;
            $APPLICATION->SetTitle(Loc::getMessage("TITLE",
                array(
                    "#GOODS_COUNT#" => $this->arResult["PRODUCTS_COUNT"])));
            $this->setResultCacheKeys(["PRODUCTS_COUNT"]);
        } else {
            $this->abortResultCache();
        }
    }

    //Выборка вктивных элементов из ИБ новости
    function getActiveNewsFromIblockNews(): void {
        $returnResults = array();

        $arFilter = array(
            "IBLOCK_ID" => $this->arParams["NEWS_IBLOCK_ID"],
            "ACTIVE" => "Y"
        );
        $arSelect = array(
            "NAME",
            "ID",
            "ACTIVE_FROM"
        );

        $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);

        while ($temp = $res->Fetch()) {
            $this->arNewsId[] = $temp["ID"];
            $this->arNews[$temp["ID"]] = $temp;
        }

    }

    //получение активных разделов из инфоблока продукции
    function getActiveSectionsFromProductIblock(): void {
        $arFilter = array(
            "IBLOCK_ID" => $this->arParams["PRODUCTS_IBLOCK_ID"],
            "ACTIVE" => "Y",
            //Фильтрация только разделов с новостями
            $this->arParams["USER_PROPERTY"] => $this->arNewsId
        );

        $arSelect = array(
            "NAME",
            "ID",
            "IBLOCK_ID",
            $this->arParams["USER_PROPERTY"]
        );

        $res = CIBlockSection::GetList(array(), $arFilter, false, $arSelect, false);

        while ($temp = $res->Fetch()) {
            $this->activeSectionsProductsId[] = $temp["ID"];
            $this->activeProductsSections[$temp["ID"]] = $temp;
        }
    }

    function getActiveGoodsFromIblockProducts(): void {

        $arFilter = array(
            "IBLOCK_ID",
            "ACTIVE" => "Y",
            "SECTION_ID" => $this->activeSectionsProductsId
        );

        $arSelect = array(
            "ID",
            "IBLCOK_ID",
            "IBLOCK_SECTION_ID",
            "NAME",
            "PROPERTY_ARTNUMBER",
            "PROPERTY_MATERIAL",
            "PROPERTY_PRICE",
        );

        $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);

        while ($temp = $res->Fetch()) {
            $this->arResult["PRODUCTS_COUNT"]++;
            foreach ($this->activeProductsSections[$temp["IBLOCK_SECTION_ID"]]
                     [$this->arParams["USER_PROPERTY"]] as $i) {
                $this->arNews[$i]["MY_GOODS"][] = $temp;
            }
        }
    }

    function getResult(): void {
        foreach ($this->activeProductsSections as $i) {
            foreach ($i[$this->arParams["USER_PROPERTY"]] as $val) {
                //добавляем в массив новостей секции
                $this->arNews[$val]["BIND_SECTIONS_PRODUCTS"][] = $i["NAME"];
            }
        }
        $this->arResult["NEWS"] = $this->arNews;
    }
}