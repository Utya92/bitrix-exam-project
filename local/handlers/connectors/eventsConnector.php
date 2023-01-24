<?php

//ex2-50
addEventHandler("iblock",
    "OnBeforeIBlockElementUpdate",
    array("MyHandlers\ActiveEvent", "OnBeforeIBlockElementUpdateHandler"));

//ex2-93
addEventHandler("main",
    "OnEpilog", array("MyHandlers\NotFoundEvent", "WhenPageNotFound"));

//ex2-51
addEventHandler("main", "OnBeforeEventAdd",
    array("MyHandlers\MailEvent", "OnBeforeEventAddHandler"));

//ex2-95
addEventHandler("main", "OnBuildGlobalMenu",
    array("MyHandlers\CustomMenuBuilder", "MyOnBuildGlobalMenu"));