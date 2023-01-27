<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<p><b><?= GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE") ?>:</b></p>
<?php //debug($arResult);?>

<ul>
    <?php foreach ($arResult["CLASSIF"] as $item): ?>
        <li>
            <?= $item["NAME"] ?>
        </li>

        <ul>
            <?php foreach ($item["LINK_ELEMENTS"] as $prop): ?>
                <li>
                    <?= $prop["NAME"] ?> -
                    <?= $prop["PROPERTY"]["ARTNUMBER"]["VALUE"] ?> -
                    <?= $prop["PROPERTY"]["MATERIAL"]["VALUE"] ?>
                   <b><a href="<?=$prop["DETAIL_PAGE_URL"];?>">(Детальная ссылка)</a></b>
                </li>
            <?php endforeach ?>
        </ul>
    <?php endforeach ?>
</ul>
