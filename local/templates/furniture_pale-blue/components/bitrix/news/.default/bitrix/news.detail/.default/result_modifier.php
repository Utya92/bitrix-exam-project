<?php
//debug($arParams);
//echo 1111111111111111;
//debug($arResult); die();
if (isset($arParams["ID_CANONICAL"])) {
    $arSelect = array(
        "ID",
        "IBLOCK_ID",
        "NAME",
        "PROPERTY_CANONICAL_NEWS");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше

    $arFilter = array(
        "IBLOCK_ID" => $arParams["ID_CANONICAL"],
        "PROPERTY_CANONICAL_NEWS" => $arResult["ID"],
        "ACTIVE" => "Y"

    );
    $res = CIBlockElement::GetList(
        array(),
        $arFilter,
        false,
        false,
        $arSelect);

    if ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        $arResult["CANONICAL_LINK"] = $arFields["NAME"];
        $this->__component->SetResultCacheKeys(
            array("CANONICAL_LINK")
        );
    }
}