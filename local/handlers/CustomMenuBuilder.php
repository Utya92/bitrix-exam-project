<?php

namespace MyHandlers;

use CGroup;
use CUser;

class CustomMenuBuilder {
    function MyOnBuildGlobalMenu(&$aGlobalMenu, &$aModuleMenu) {
        $isAdmin = false;
        $isManager = false;
        global $USER;
        $userGroup = CUser::GetUserGroupList($USER->GetId());
        $contentRedactorsGroupID = CGroup::GetList("c_sort", "asc",
            array("STRING_ID" => "content_editor"))->Fetch()["ID"];

        while ($group = $userGroup->Fetch()) {
            if ($group["GROUP_ID"] == 1) {
                $isAdmin = true;
            }
            if ($group["GROUP_ID"] == $contentRedactorsGroupID) {
                $isManager = true;
            }
        }

        if (!$isAdmin && $isManager) {
            foreach ($aModuleMenu as $key => $val) {
                if ($val["items_id"] == "menu_iblock_/news") {
                    $aModuleMenu = [$val];
                    break;
                }
            }
            $aGlobalMenu=["global_menu_content"=>$aGlobalMenu["global_menu_content"]];
        }
    }
}