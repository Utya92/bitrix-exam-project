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
    array("MyHandlers\MailEvent","OnBeforeEventAddHandler"));