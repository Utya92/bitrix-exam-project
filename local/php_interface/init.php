<?php

use Bitrix\Main\Loader;

function debug($arr): void {
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}

Loader::registerNameSpace("MyHandlers", Loader::getLocal(
    "handlers"
));

if (file_exists(Loader::getLocal("handlers/connectors/eventsConnector.php"))) {
    require_once(Loader::getLocal("handlers/connectors/eventsConnector.php"));
}