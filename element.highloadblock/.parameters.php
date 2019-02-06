<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Highloadblock\HighloadBlockTable as HL,
	Bitrix\Main\Entity,
	Bitrix\Main\Data\Cache,
	Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arListHighLoad = array();

Loader::includeModule("highloadblock");

$dbHLBlock = HL::getList([
	'select' => ['*', 'NAME_LANG' => 'LANG.NAME'],
	'order' => ['NAME_LANG' => 'ASC', 'NAME' => 'ASC']
]);

while ($arHLBlock = $dbHLBlock->Fetch()) {
	$arListHighLoad[$arHLBlock['ID']] =  "[{$arHLBlock["ID"]}] {$arHLBlock["NAME_LANG"]}";
}

if (!empty($arListHighLoad) && !empty($arCurrentValues["BLOCK_ID"])) {

	$HighloadBlockTable = HL::getById($arCurrentValues["BLOCK_ID"])->Fetch();

	$entity = HL::compileEntity($HighloadBlockTable);

	$entity_data_class = $entity->getDataClass();

	$dbResultElement = $entity_data_class::getList([
		"select" => ["ID", "UF_NAME"],
		"order"  => ["ID" => "ASC"],
	]);

	while ($arResultElement = $dbResultElement->Fetch()) {

		$arListHighLoadElement[$arResultElement["ID"]] = "[{$arResultElement["ID"]}] {$arResultElement["UF_NAME"]}";

	}
}

$arComponentParameters = array(
	'GROUPS' => array(
	),
	'PARAMETERS' => array(
		'BLOCK_ID' => array(
			'PARENT' => 'BASE',
			'NAME' => Loc::getMessage('FLXMD_ICON_BLOCK_ID_NAME'),
			'TYPE' => 'LIST',
		    'REFRESH' => 'Y',
		    'VALUES' => $arListHighLoad,
		),
		'ID_ARRAY' => array(
			'PARENT' => 'BASE',
			'NAME' => Loc::getMessage('FLXMD_ICON_ID_ARRAY_NAME'),
			'TYPE' => 'LIST',
		    'VALUES' => $arListHighLoadElement,
		    'MULTIPLE' => 'Y',
		    'ADDITIONAL_VALUES' => 'Y',
		),
	),
);