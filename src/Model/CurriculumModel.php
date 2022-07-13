<?php

namespace App\Model;

use App\Lib;

class CurriculumModel
{

        private $myTabInfo      = [];

        public function __construct($attributes)
        {
                $this->myTabInfo        = ['titleAscii' => Lib\MyLib::loopTxt2ASCII($attributes['_route'])];
        }

        public function getInfo()
        {
                return  $this->myTabInfo;
        }

}