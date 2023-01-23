<?php
namespace MyHandlers;

use CEventLog;

class NotFoundEvent {
   static function WhenPageNotFound() {
        if (defined("ERROR_404") && ERROR_404 == "Y") {
            global $APPLICATION;
            $APPLICATION->RestartBuffer();
            include $_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/header.php";
            include $_SERVER["DOCUMENT_ROOT"] . "/404.php";
            include $_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/footer.php";

            CEventLog::Add(array(
                //степень важности записи
                "SEVERITY" => "INFO",
                // собственный ID типа события
                "AUDIT_TYPE_ID" => "ERROR_404",
                "MODULE_ID" => "main",
                //Возвращает путь к текущей странице относительно корня.
                "DESCRIPTION" => $APPLICATION->GetCurPage(),
            ));
        }
    }
}