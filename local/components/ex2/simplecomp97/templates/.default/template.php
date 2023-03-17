<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<p><b><?= GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE") ?></b></p>
<?php //debug($arResult); ?>


<?php if (!empty($arResult["AUTHORS_ID_LOGIN"])): ?>
    <? foreach ($arResult["AUTHORS_ID_LOGIN"] as $id => $val): ?>
        <li>
            [<?= $id ?>] - <?= $val ?>
        </li>
        <?php foreach ($arResult["NEWS"] as $item): ?>
            <?php if ($item["PROPERTY_AUTHOR_VALUE"] == $id): ?>
                <ul>
                    <li>
                        - <?= $item["NAME"] ?>
                    </li>
                </ul>
            <?php endif; ?>
        <? endforeach; ?>
    <? endforeach; ?>

<?php endif; ?>
