<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Ex2-97");
?><?$APPLICATION->IncludeComponent(
	"ex2:simplecomp97", 
	".default", 
	array(
		"AUTHOR_IBLOCK_CODE" => "AUTHOR",
		"AUTHOR_PROPERTY_UF_CODE" => "UF_AUTHOR_TYPE",
		"AUTHOR_TYPE_IBLOCK_CODE" => "",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"NEWS_IBLOCK_ID" => "1",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>