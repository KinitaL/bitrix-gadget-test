<?
    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    require ($_SERVER['DOCUMENT_ROOT'].'/bitrix/vendor/autoload.php');
    require_once 'Programm.php';
?>
<html>
   <head>
     <title>test</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
   </head>
   <body>
        <?php
            
            if((isset($_FILES["userfile"]))&&($_POST['fondselect'] !== '')) {
                try {
                    if($_FILES["userfile"]["name"] !== '')
                    {
                        $file_name = '../data.xlsx';
                        move_uploaded_file($_FILES['userfile']['tmp_name'], $file_name);
                    }
                    else {
                        throw new Exception("Файл не загружен");
                    }
                    $result = Programm::excelToArray('../data.xlsx');

                    $Ind_values = $result[0];
                    $Inv_values = $result[1];

                    $Fond_id = $_POST['fondselect'];
                    if(!$Fond_id){
                        throw new Exception("Фонд не выбран");
                    }

                    foreach ($Ind_values as $Ind) {

                        //Преобразование даты к формату для сайта
                        $format = "MM/DD/YYYY";
                        $new_format = CSite::GetDateFormat("SHORT");
                        $new_date = CDatabase::FormatDate($Ind->Date, $format, $new_format);

                        $el = new CIBlockElement;

                        $PROP = array();
                        $PROP['date'] = $new_date;  // свойству с кодом date присваиваем значение
                        $PROP['ind_value'] = $Ind->Ind_value;        // свойству с кодом ind_value присваиваем значение
                        $PROP['fond_id'] = $Fond_id;

                        $arLoadProductArray = [ 
                            "IBLOCK_ID"      => 10,     //Указывается ID инфоблока, которому принадлежат элементы
                            "PROPERTY_VALUES"=> $PROP,
                            "NAME"           => "Элемент",
                            "ACTIVE"         => "Y",            // активен
                            "PREVIEW_TEXT"   => "текст для списка элементов",
                            "DETAIL_TEXT"    => "текст для детального просмотра"
                        ];

                        if($PRODUCT_ID = $el->Add($arLoadProductArray))
                        echo "New Ind-ID: ".$PRODUCT_ID."\n";
                        else
                        echo "Error: ".$el->LAST_ERROR;
                    }
    
                    foreach ($Inv_values as $Inv) {
                        $format = "MM/DD/YYYY";
                        $new_format = CSite::GetDateFormat("SHORT");
                        $new_date = CDatabase::FormatDate($Inv->Date, $format, $new_format);

                        $el = new CIBlockElement;

                        $PROP = array();
                        $PROP['date'] = $new_date;  // свойству с кодом date присваиваем значение
                        $PROP['nav'] = $Inv->NAV;        // свойству с кодом ind_value присваиваем значение
                        $PROP['aum'] = $Inv->AUM;
                        $PROP['fond_id'] = $Fond_id;

                        $arLoadProductArray = [ 
                            "IBLOCK_ID"      => 11,     //Указывается ID инфоблока, которому принадлежат элементы
                            "PROPERTY_VALUES"=> $PROP,
                            "NAME"           => "Элемент",
                            "ACTIVE"         => "Y",            // активен
                            "PREVIEW_TEXT"   => "текст для списка элементов",
                            "DETAIL_TEXT"    => "текст для детального просмотра"
                        ];

                        if($PRODUCT_ID = $el->Add($arLoadProductArray))
                        echo "New Inv-ID: ".$PRODUCT_ID."\n";
                        else
                        echo "Error: ".$el->LAST_ERROR;
                    }

                    unlink('../data.xlsx');
                } 
                catch (\Throwable $th) {
                    //throw $th;
                    echo $th->getMessage();
                }
            } 
            else {
                echo 'Загрузите файл и выберите фонд';
            }
        ?>

        <div>
            <form enctype="multipart/form-data" action="" method="POST">
                <?php
                        if (!CModule::IncludeModule("iblock")) //Подключение информационных блоков
                        {
                            ShowMessage(GetMessage("IBLOCK_ERROR"));
                            return false;
                        }
                        
                        $dbElement = CIBlockElement::GetList(       //Выдает список всех фондов, выбирая по ID ИНФОБЛОКА С ФОНДАМИ
                            ["ID"  =>  "DESC"], //arOrder - desk - по убыванию 
                            [                   //arFilter по коду инфоблока и активности
                                "IBLOCK_ID" =>  9,
                                "ACTIVE"    =>  "Y",
                            ],
                            false,
                            [ //Ограничитель количества и тд
                            ],
                            [
                                //"ID",
                                //"IBLOCK_ID",
                                //"IBLOCK_CODE",
                                "NAME",
                                //"PROPERTY_".$arGadgetParams["PROPERTIES"],
                            ]
                        );
                ?>
                <select name="fondselect" id="fondselect">
                    <option selected disabled>Выберите фонд</option>
                    <?while ($arElement = $dbElement->GetNext()):?>
                        <option value=<?=$arElement["ID"]?>>
                            <?=$arElement["NAME"]?>
                        </option>
                    <?endwhile?>
                </select>
                <input name="userfile" type="file" />
                <input type="submit" value="Отправить файл" />
            </form>    
        </div>   
    </body>
</html>
    