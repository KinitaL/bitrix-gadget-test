<?php
    use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
    class MyReadFilter implements IReadFilter {

        public function readCell($column, $row, $worksheetName = '') {
            if ($row>=2) {
                if ($column == 'A' || $column == 'B' || $column == 'D' || $column == 'E' || $column == 'F') {
                    return true;
                }
                return false;
            }
        }
    }
?>