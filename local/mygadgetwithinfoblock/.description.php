<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arDescription = Array(
    "NAME"  =>  "ИнфоблокШоу", // Имя
    "DESCRIPTION"   =>  "Гаджет, выводящий что-то из инфоблока",  //  Описание
    "GROUP" =>  Array(
        "ID"    =>  "admin_settings"    //  Группа в списке
    ),
    "ICON" => "",   //  Путь до файла иконки, не обязательный
    "TITLE_ICON_CLASS" => "",   //  Дополнительный css класс, не обязательный
    "AI_ONLY" => true,  //  Только в админке, не обязательный
    "COLOURFUL" => false    //  Баннер или нет, не обязательный
);