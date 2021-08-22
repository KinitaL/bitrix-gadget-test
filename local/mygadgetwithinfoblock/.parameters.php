<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!CModule::IncludeModule("iblock")) //Подключение информационных блоков
{
    ShowMessage(GetMessage("IBLOCK_ERROR"));
    return false;
}

$dbIBlocks = CIBlock::GetList(  //Возвращает список информационных блоков по фильтру arFilter отсортированный в порядке arOrder.
    ["name"  =>  "asc"], //arOrder
    ["ACTIVE"    =>  "Y"], //afFilter
    true //Возвращать ли количество элементов в информационном блоке в поле ELEMENT_CNT.
);

while ($arIBlocks = $dbIBlocks->GetNext())
{
    $iblocks[$arIBlocks["ID"]] = "[" . $arIBlocks["ID"] . "] " . $arIBlocks["NAME"] . " (" . $arIBlocks["ELEMENT_CNT"] . ")";
    $last = $arIBlocks["ID"];
}

//  Получение списка свойств
$dbProperties = CIBlockProperty::GetList(   //Возвращает список свойств по фильтру arFilter отсортированные в порядке arOrder
    ["NAME"  =>  "ASC"], //arOrder
    [                       //arFilter
        "ACTIVE"    =>  "Y",
        "IBLOCK_ID" =>  $arAllCurrentValues["IBLOCK_ID"]["VALUE"] //$arAllCurrentValues - доступ ко всем текущим параметрам
    ]
);
while ($arProperties = $dbProperties->GetNext())
{
    $properties[$arProperties["CODE"]] = $arProperties["NAME"];
}

$arParameters = Array(
    "PARAMETERS"=> Array(

    ),
    "USER_PARAMETERS" => Array(
        "IBLOCK_ID" => [
            "NAME"  => GetMessage("IBLOCK_ID"),
            "TYPE"  => "LIST",
            "VALUES"    =>  $iblocks,
            "REFRESH"   =>  "Y"
        ],
        "PROPERTIES"    =>  [
            "NAME"  =>  GetMessage("PROPERTIES"),
            "TYPE"  =>  "LIST",
            "MULTIPLE"  =>  "N",
            "VALUES"    =>    $properties
        ],
    ),
);

?>