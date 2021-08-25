<?php

    class ReadyIndData{
        public $Date;
        public $Ind_value;

        public function __construct($Date,$Ind_value){
            $this->Date = $Date;
            $this->Ind_value = $Ind_value;
        }
    }
?>