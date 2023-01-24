<?php
namespace MyHandlers;

use CEventLog;

class MailEvent {
    function OnBeforeEventAddHandler(&$event, &$lid, &$arFields) {
        global $USER;
        if ($event == "FEEDBACK_FORM" && $USER->isAuthorized()) {
            $arFields["AUTHOR"] = GetMessage("AUTH_USER", array(
                "#ID#" => $USER->GetID(),
                "#LOGIN#" => $USER->GetLogin(),
                //name авторизованного юзера
                "#NAME#" => $USER->GetFullName(),
                //name юзера из формы отправки сообщения
                "#FORM_NAME#" => $arFields["AUTHOR"]
            ));
        } else {
            $arFields["AUTHOR"] = GetMessage("NO_AUTH_USER", array(
                "#FORM_NAME#" => $arFields["AUTHOR"]
            ));
        }

        CEventLog::Add(array(
            //степень важности записи
            "SEVERITY" => "SECURITY",
            // собственный ID типа события
            "AUDIT_TYPE_ID" => "MailEvent",
            "MODULE_ID" => "main",
            "ITEM_ID" => $event,
            "DESCRIPTION" => GetMessage("REPLACE_DATA", array(
                "#AUTHOR#" => $arFields["AUTHOR"]
            ))
        ));
    }
}