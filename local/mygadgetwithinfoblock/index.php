<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//  Подключение модуля
if (!CModule::IncludeModule("iblock"))
{
    ShowMessage("Модуль iblock не установлен");
    return false;
}

//  Проверка настроек
if (!isset($arGadgetParams["IBLOCK_ID"]))
{
    ShowMessage("Укажите инфоблок");
    return false;
}

$dbElement = CIBlockElement::GetList(
    ["ID"  =>  "DESC"], //arOrder - desk - по убыванию 
    [                   //arFilter по коду инфоблока и активности
        "IBLOCK_ID" =>  $arGadgetParams["IBLOCK_ID"],
        "ACTIVE"    =>  "Y",
    ],
    false,
    [ //Ограничитель количества и тд
        "nTopCount" =>  "10"
    ],
    [
        "ID",
        "IBLOCK_ID",
        "IBLOCK_CODE",
        "NAME",
        "PROPERTY_".$arGadgetParams["PROPERTIES"],
    ]
);
?>

<table>
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Тестовый текст</th>
    </tr>
    <?while ($arElement = $dbElement->GetNext()):?>
        <tr>
            <td>
                <?=$arElement["ID"]?>
            </td>
            <td>
                <?=$arElement["NAME"]?>
            </td>
            <td>
                <?=$arElement["PROPERTY_".$arGadgetParams["PROPERTIES"]."_VALUE"]?>
            </td>
        </tr>
        <?endwhile?>
</table>