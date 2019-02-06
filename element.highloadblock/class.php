<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader,
Bitrix\Highloadblock as HL,
Bitrix\Main\Entity,
Bitrix\Main\Data\Cache;

class FLX_MD_ElementHighLoadBlock extends CBitrixComponent
{

	public function executeComponent()
	{
		if (Loader::includeModule("highloadblock")){

			if (!is_array($this->arParams['ID_ARRAY'])) {
				$this->arParams['ID_ARRAY'] = explode(',', $this->arParams['ID_ARRAY']);
			} else {
				$this->arParams['ID_ARRAY'] = array_unique(array_diff(explode(',', implode(',', $this->arParams['ID_ARRAY'])),  ['', ' ']));
			}

			if (empty($this->arParams['BLOCK_ID']) || empty($this->arParams['ID_ARRAY'])) {
				ShowError(GetMessage("FLXMD_ICON_NOT_PARAMS"));
				return;
			}

			$cache = Cache::createInstance();

			$sCacheID = "header_icon_".serialize($this->arParams['BLOCK_ID']).serialize($this->arParams['ID_ARRAY']);

			if ($cache->initCache(86400, $sCacheID)) {

				$this->arResult = $cache->getVars();

			} elseif($cache->startDataCache()) {

				$HighloadBlockTable = HL\HighloadBlockTable::getById($this->arParams['BLOCK_ID'])->fetch();

				$entity = HL\HighloadBlockTable::compileEntity($HighloadBlockTable);

				$entity_data_class = $entity->getDataClass();

				$dbResult = $entity_data_class::getList([
					"select" => ["*"],
					"order"  => ["ID" => "ASC"],
					"filter" => ["ID" => $this->arParams['ID_ARRAY']]
				]);

				while ($arResult = $dbResult->Fetch()) {

					if (!empty($arResult["UF_COLOR"])) {

						$dbUFColor = CUserFieldEnum::GetList([], [
							"ID" => $arResult["UF_COLOR"],
						]);

						if ($arUFColor = $dbUFColor->Fetch()) {
							$arResult["UF_COLOR"] = $arUFColor['XML_ID'];
						}

					}

					$this->arResult['ITEMS'][] = $arResult;
				}

				$cache->endDataCache($this->arResult);
			}

			$this->IncludeComponentTemplate();

		} else {
			ShowError(GetMessage("FLXMD_ICON_IN_MODULE_NOT_FOUND"));
			return;
		}

	}

}