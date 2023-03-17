<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

class SimpleComponent97 extends CBitrixComponent {

    protected int $currentUserId;
    //хранится номер группы (1 или 2) текущего авторизованного юзера
    protected int $currentGroup;
    protected array $userIdWithoutCurrentUserList = [];
    protected array $allUserPropertiesList = [];
    protected array $arNewsList;
    protected int $countUniqueNews;


    public function onPrepareComponentParams($arParams): array {
        if (!Loader::includeModule("iblock")) {
            ShowError(Loc::getMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
        }
        if (!isset($arParams["CACHE_TIME"])) {
            $arParams["CACHE_TIME"] = 36000000;
        }
        $arParams["AUTHOR_PROPERTY_UF_CODE"] = trim($arParams["AUTHOR_PROPERTY_UF_CODE"]);

        return $arParams;
    }

    public function executeComponent(): void {
        global $USER;
        if ($USER->isAuthorized() && $this->startResultCache(false, $USER->GetGroups())) {
            global $APPLICATION;
            $this->getCurrentUserid($USER);
            $this->getCurrentGroupByUser();
            $this->getAllUsersWithSamePropertyWithoutCurrentUser();
            $this->getNewsByCurrentGroupWithoutCurrentUser();
            $this->getResult();
            $this->setResultCacheKeys(["COUNT_UNIQ_NEWS"]); // массив c ключами кеширования из arResult
            $APPLICATION->SetTitle(Loc::getMessage("TITLE", array(
                "#COUNT#" => $this->arResult["COUNT_UNIQ_NEWS"])));
            $this->includeComponentTemplate();
        } else {
            $this->abortResultCache();
        }
    }


    //получаем айди текущего юзера
    function getCurrentUserid($user) {
        $this->currentUserId = $user->GetID();
    }

    //получаем группу текущего пользователя, N2
    function getCurrentGroupByUser(): void {
        //группа пользователе 1 или 2
        $this->currentGroup = CUser::GetList("id", "asc",
            array("ID" => $this->currentUserId),
            array("SELECT" => [$this->arParams["AUTHOR_PROPERTY_UF_CODE"]])
        )->Fetch()[$this->arParams["AUTHOR_PROPERTY_UF_CODE"]];
    }

    //тут надо получить всех юзеров, у которых такая же группа, как у текущего кроме текущего
    function getAllUsersWithSamePropertyWithoutCurrentUser() {
        $allUsersWithoutCurrent = CUser::GetList(
            "id",
            "asc",
            array(
                $this->arParams["AUTHOR_PROPERTY_UF_CODE"] => $this->currentGroup,
                "!ID" => $this->currentUserId,
            ),
            array(
                "SELECT" => ["LOGIN", "ID"]
            )
        );

        while ($res = $allUsersWithoutCurrent->Fetch()) {
            $this->userIdWithoutCurrentUserList[] = $res["ID"];
            $this->allUserPropertiesList[$res["ID"]] = $res["LOGIN"];
        }
    }

    //теперь надо получит все новости принадлежащие группе текущего автора(юзера) но без него
    function getNewsByCurrentGroupWithoutCurrentUser() {
        //Уникальные новости
        $temp = [];

        //массив всех айди новостей текущего юзера
        $currentUserNewsValueId = [];

        //получаем массив всех айди новостей текущего юзера, дабы не отображать их у остальных юзеров
        $currentUserNewsIdList = CIBlockElement::GetList(
            false,
            array(
                "IBLOCK_ID" => $this->arParams["NEWS_IBLOCK_ID"],
                "PROPERTY_" . $this->arParams["AUTHOR_IBLOCK_CODE"] =>
                    $this->currentUserId,

            ),
            false,
            false,
            array(
                "ID",
                "NAME",
                "PROPERTY_" . $this->arParams["AUTHOR_IBLOCK_CODE"]
            )
        );
        while ($res = $currentUserNewsIdList->Fetch()) {
//            получаем массив всех айди новостей текущего юзера
            $currentUserNewsValueId[] = $res["ID"];
        }

        ////////////////////////////////
        $news = CIBlockElement::GetList(
            false,
            array(
                //ограничиваем вовод новостей текущего юзера у остальных юзеров
                "!ID" => $currentUserNewsValueId,
                "IBLOCK_ID" => $this->arParams["NEWS_IBLOCK_ID"],
                //ограничение по группе
                "PROPERTY_" . $this->arParams["AUTHOR_IBLOCK_CODE"] =>
                    $this->userIdWithoutCurrentUserList,

            ),
            false,
            false,
            array(
                "ID",
                "NAME",
                "PROPERTY_" . $this->arParams["AUTHOR_IBLOCK_CODE"]
            )
        );


        while ($res = $news->Fetch()) {
            $authorId = $res["PROPERTY_" . $this->arParams["AUTHOR_IBLOCK_CODE"] . "_VALUE"];
//            $res["USERNAME"] = $this->allUserPropertiesList[$res["PROPERTY_AUTHOR_VALUE"]];
//            $res["USER_ID"] = $authorId;
//            $res["USER_NAME"]=
//           echo(array_shift($this->userIdAndNameWithoutCurrent));
//            $this->arNewsList["NEWS"][$this->allUserPropertiesList[$res["PROPERTY_AUTHOR_VALUE"]]][] = $res;
            $this->arNewsList["NEWS"] [] = $res;


            //получаем массив уникальных новостей
            $temp[$res["ID"]] = $res["ID"];
//            debug($this->userIdAndNameWithoutCurrent);

        }
        $this->countUniqueNews = count($temp);
    }

    function getResult() {
        $this->arResult = $this->arNewsList;
        $this->arResult["AUTHORS_ID_LOGIN"] = $this->allUserPropertiesList;
        $this->arResult["COUNT_UNIQ_NEWS"] = $this->countUniqueNews;
    }
}














