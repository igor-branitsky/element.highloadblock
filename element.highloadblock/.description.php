<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = array(
	"NAME" => Loc::getMessage("FLXMD_ICON_HEADER_NAME"),
	"DESCRIPTION" =>  Loc::getMessage('FLXMD_ICON_HEADER_DESCRIPTION'),
	"ICON" => "images/hl_list.gif",
	"CACHE_PATH" => "Y",
	"SORT" => 10,
	"PATH" => array(
		"ID" => "FLXMD",
		"NAME" =>  Loc::getMessage('FLXMD_ICON_HEADER_PATH'),
	),
);
?>