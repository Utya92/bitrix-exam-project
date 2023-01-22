<?php

//ex2-50
addEventHandler("iblock",
    "OnBeforeIBlockElementUpdate",
    array("MyHandlers\ActiveEvent", "OnBeforeIBlockElementUpdateHandler"));
