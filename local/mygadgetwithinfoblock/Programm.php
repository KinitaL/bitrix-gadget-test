<?php
    require_once 'MyReadFilter.php';
    require_once 'ReadyIndData.php';
    require_once 'ReadyInvData.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    class Programm {
        public static function excelToArray($link){
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadFilter(new MyReadFilter());
            $spreadsheet = $reader->load($link);
            $data = $spreadsheet->getActiveSheet()->toArray();
            
            $IndArr = [];
            $InvArr = [];

            foreach ($data as $row) {

                if (!(($row[0]==NULL)&&($row[1]==NULL))) {
                    $Ind = new ReadyIndData($row[0],$row[1]);
                    $IndArr[] = $Ind;
                }

                if (!(($row[3]==NULL)&&($row[4]==NULL)&&($row[5]==NULL))) {
                    $Inv = new ReadyInvData($row[3],$row[4],$row[5]);
                    $InvArr[] = $Inv;
                }
            
            }

            return array($IndArr,$InvArr);

            //$writer = new Xlsx($spreadsheet);
            //$writer->save($link);
            
        }
        /*public static function toDB($data){
            $conn = mysqli_connect('localhost:6033', 'root', 'pass', 'fond');
            
            
            foreach ($data as $row) {
                $IndArr = array(
                    'Data' => $row[0],
                    'Ind_value' => $row[1],
                );

                $InvArr = array(
                    'Data' => $row[3],
                    'Price' => $row[4],
                    'Tax' => $row[5]
                )

                $test = $insert_data['Test'];
                $Ind = $insert_data['Ind_value'];
                $Date2 = $insert_data['Date2'];
                $Price = $insert_data['Price'];
                $Tax = $insert_data['Tax'];

                $query;
                if ($test&&$Ind&&$Date2&&$Price&&$Tax) {
                    $query = "INSERT INTO fond (Test, Ind_value, Date2, Price, Tax) VALUES
                    ('$test', '$Ind', '$Date2', '$Price', '$Tax')";
                }
                elseif ($test&&$Ind&&!($Date2&&$Price&&$Tax)) {
                    $query = "INSERT INTO fond (Test, Ind_value) VALUES
                    ('$test', '$Ind')";
                }
                elseif (!($test&&$Ind)&&$Date2&&$Price&&$Tax) {
                    $query = "INSERT INTO fond (Date2, Price, Tax) VALUES
                    ('$Date2', '$Price', '$Tax')";
                }
                else{
                    echo 'Incorrect data!';
                }

                mysqli_query($conn,$query);

            }
        }*/
    }

?>