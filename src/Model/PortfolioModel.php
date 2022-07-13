<?php

namespace App\Model;

use App\Lib;

class PortfolioModel
{

        private $myTabInfo      = [];

        public function         __construct($attributes)
        {                
                $this->myTabInfo        = [
                                                'titleAscii'            => Lib\MyLib::loopTxt2ASCII($attributes['_route']),
                                                'myReadMePortfolio'     => $this->myReadMePortfolio()
                                        ];
        }

        private function        myReadMePortfolio(string $url = "flourdau/flourdau/main/README.md"): string
        {
                return  file_get_contents("https://raw.githubusercontent.com/" . $url, "r");                
        }

        public function         getInfo() 
        {
                return  $this->myTabInfo;
        }

}