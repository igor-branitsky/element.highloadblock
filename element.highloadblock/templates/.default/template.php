<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<?if (!empty($arResult['ITEMS'])):?>

	<?foreach ($arResult['ITEMS'] as $arItem):?>
		<div>
			<?=$arItem['ID'];?> - <?=$arItem['UF_NAME'];?>
		</div>
	<?endforeach;?>

<?endif;?>