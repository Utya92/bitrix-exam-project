<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<p><?= GetMessage("COUNT_ELEMENTS", array(
        "#COUNT#" => $arResult["PRODUCTS_COUNT"]
    )) ?></p>
<br>

---
<p><b><?= GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE") ?></b></p>

<ul>
    <?php foreach ($arResult["NEWS"] as $i): ?>

        <li><b> <?= $i["NAME"]; ?></b> - <?= $i["ACTIVE_FROM"] ?>
            (<?= implode(", ", $i["BIND_SECTIONS_PRODUCTS"]) ?>)
        </li>
        <?php foreach ($i["MY_GOODS"] as $item): ?>
            <li><?= $item["NAME"] ?> - <?= $item["PROPERTY_PRICE_VALUE"] ?> - <?= $item["PROPERTY_MATERIAL_VALUE"] ?>
                - <?= $item["PROPERTY_ARTNUMBER_VALUE"] ?> </li>
        <?php endforeach; ?>

    <?php endforeach; ?>
</ul>

