<?php

    class ReadyInvData{
        public $Date;
        public $NAV;
        public $AUM;

        public function __construct($Date, $NAV, $AUM){
            $this->Date = $Date;
            $this->NAV = $NAV;
            $this->AUM = $AUM;
        }
    }
?>