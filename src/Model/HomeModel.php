<?php

namespace App\Model;

use App\Lib;

class HomeModel
{

        private $nowDate        = NULL;
        private $validator      = NULL;
        private $myTabInfo      = [];

        public function         __construct(array $attributes, array $query, array $keys)
        {

                $keyMeteo               = $keys['APP_OPENWEATHERMAP'];
                unset($keys['app']['WEB_API']);

                $this->validator        = new Lib\Validator();
                $this->nowDate          = new \DateTime("now", new \DateTimeZone("Europe/Paris"));

                if (!empty($attributes['name']) && $attributes['name'] !== "World") {
                        $attributes['name']    = $this->validator->checkStrUsername($attributes['name']);
                }
                else if (empty($app['name']) || $attributes['name'] !== "World") {
                        $attributes['name']    = $attributes['app']['SITE']['APP_TITLE']   ;
                }

                $attributes             = $this->myAscii($attributes);


                $this->myTabInfo        = [
                                                'titleAscii'            => Lib\MyLib::loopTxt2ASCII($attributes['app']['SITE']['APP_TITLE']),
                                                'myBg'                  => $this->myBackground(),
                                                'myDate'                => $this->myDate(),
                                                'myHour'                => $this->myHour(),
                                                'myReadMe'              => $this->myReadMe(),
                                                'myReadMePortfolio'     => $this->myReadMePortfolio(),
                                                'myDicos'               => $this->myDicos(),
                                                'name'                  => $attributes['name'],
                                                'ascii'                 => $attributes['ascii']
                                        ];
                $this->myTabInfo        = array_merge($this->myTabInfo, $this->myDateTimeParty($query, $keyMeteo));
                unset($keyMeteo);
        }

        private function        myAscii($attributes)
        {
                if ($attributes['_route'] !== 'home' && $attributes['_route'] !== 'portfolio' ) {
                        $attributes['ascii']  = Lib\MyLib::loopTxt2ASCII($attributes['_route'] . " " . $attributes['name'] . "!");
                }
                else {
                        $attributes['ascii']  = Lib\MyLib::loopTxt2ASCII($attributes['app']['SITE']['APP_TITLE']);
                }
                return $attributes;
        }

        private function        myDateTimeParty(array $myQuery, string $keyMeteo): ?array 
        {
                extract($myQuery, EXTR_SKIP);
                if (empty($formCalendar)) {
                        $formCalendar = 0;
                }

                $usrCity        = "Paris";
                $usrDate        = $this->nowDate->format('d-m-Y');
                $usrTime        = $this->nowDate->format('H:i');
                
                try {
                        $usrCity   = $this->validator->checkCity($strCity); 
                }
                catch (\Exception $e) {
                        error_log($e->getMessage());
                        $sms    = $e->getMessage();
                }

                try {
                        $strTime        = $this->validator->checkStrTime($strTime);
                        $strDate        = $this->validator->checkStrDate($strDate); 
                }
                catch (\Exception $e) {
                        error_log($e->getMessage());
                        $sms            = $e->getMessage();
                        $strDate        = $usrDate;
                        $strTime        = $usrTime;
                }
                finally {
                        $usrDate        = \DateTime::createFromFormat('d-m-Y H:i', "$strDate $strTime", new \DateTimeZone("Europe/Paris"));

                        $meteo          = (new Lib\Meteo($usrCity, $keyMeteo))->getMeteo();
                        $sun            = $this->mySun($usrDate, $meteo['Meteo']['coord']['lat'], $meteo['Meteo']['coord']['lon']);

                        return  [
                                        'Meteo'         => $meteo['Meteo'],
                                        'Air'           => $meteo['Air'],
                                        'Calendar'      => (new Lib\Calendar($usrDate))->getCalendar(),
                                        'Moon'          => $this->myMoon($usrDate),
                                        'Sun'           => $sun,
                                        'Astro'         => $this->myAstro($usrDate),
                                        'astroChinois'  => $this->myAstroChinois($usrDate),
                                        'usrDate'       => (array) $usrDate,
                                        'formCalendar'  => $formCalendar
                                ];
                        
                }

        }

        private function        myMoon(\DateTime $usrDate): ?array
        {
                $moon   = new Lib\Moon($usrDate);

                return  [
                                "Age"           => round($moon->get('age'), 1),
                                "Stage"         => ($moon->phase() < 0.5 ? 'waxing' : 'waning'),
                                "Distance"      => round($moon->get('distance'), 2),
                                "Diametre"      => $moon->get('diameter'),
                                "sunDistance"   => round($moon->get('sundistance'), 2),
                                "sunDiametre"   => $moon->get('sundiameter'),
                                "newNext"       => gmdate('G:i:s, j M Y', $moon->get_phase('next_new_moon')),
                                "fullNext"      => gmdate('G:i:s, j M Y', $moon->get_phase('next_full_moon')),
                                "Lumi"          => $moon->get('illumination'),
                                "Name"          => $moon->phase_name()
                        ];
        }

        private function        mySun(\DateTime $usrDate, string $lat, string $lon): ?array
        {
                return  [        
                                date_sun_info($usrDate->getTimestamp(), $lat, $lon),
                                Lib\Solar::solar($usrDate, $lat, $lon)
                        ];
        }

        private function        myAstro(\DateTime $usrDate): ?array
        {
                $astroOccident  = json_decode(file_get_contents("../depotsGIT/dicosJSON/astro.json"), false);
                foreach ($astroOccident->Occidental as $signeName => $tab) {
                        $tmp1   = \DateTime::createFromFormat('m-d', $tab[1], new \DateTimeZone("Europe/Paris"));
                        $tmp2   = \DateTime::createFromFormat('m-d', $tab[2], new \DateTimeZone("Europe/Paris"));
                        if ($usrDate->format("m-d") >= $tmp1->format("m-d") && $usrDate->format('m-d') <= $tmp2->format("m-d")) {
                                if ($signeName === "Capricorne2") {
                                        $signeName      = "Capricorne";
                                }
                                if ($signeName === "Capricorne") {
                                        $astroOccident->Occidental->$signeName[1]       = "12-22";
                                        $astroOccident->Occidental->$signeName[2]       = "01-20";
                                }
                                return  [$signeName => $astroOccident->Occidental->$signeName];
                        }
                }
        }

        private function        myAstroChinois(\DateTime $usrDate): string
        {
                if ($usrDate->format("Y")  % 2 === 0) {
                       return "Yang\n";
                }
                return $tabAstroChinois = "Yin\n";
        }

        private function        myBackground() {
                $path   = __DIR__ . '/../../public/design/img/bg/webP/';
                if (is_dir($path) && $dir = array_slice(array_diff(scandir($path), array( '..', '.', '.DS_Store' )), 0)) {
                        return $dir[rand(0, count($dir) -1)];
                }
        }

        public static function myBackgroundPost($myGET) {
                // ON VERIF LE GET
                if (!$myGET || count($myGET) !== 2 || !$myGET['namePicture'] || !$myGET['direction']) {
                    die("error");
                }
                if ($myGET['direction'] !== 'last' && $myGET['direction'] !=='next') {
                    die("error");
                }
                $len = 0;
                $len = strlen($myGET['namePicture']);
                if ($len < 1 && $len > 10) {
                    die("error");
                }
        
                // RECCURATION DU DOSSIER DE BG
                $path = __DIR__ . '/../../public/design/img/bg/webP/';
        
                if (is_dir($path) && $dir = array_slice(array_diff(scandir($path), array( '..', '.', '.DS_Store' )), 0)) {
                    $key = array_search($myGET['namePicture'], $dir);
        
                    if ($myGET['direction'] === 'next' && $key + 1 >= count($dir)) {
                        $key = 0;
                    }
                    elseif ($myGET['direction'] === 'last') {
                        if ($key <= 0) {
                            $key = count($dir) - 1;
                        }
                        else {
                            $key--;
                        }
                    }
                    elseif ($myGET['direction'] === 'next') {
                        $key++;
                    }
                    return ($dir[$key]);
                }
        }
        
        private function        myDicos() {
                $myDicos                = [];
                $myDicos['welcome']     = json_decode(file_get_contents(__DIR__ . "/../../depotsGIT/dicosJSON/bienvenue.json", "r"), true);
                $myDicos['bonjour']     = json_decode(file_get_contents(__DIR__ . "/../../depotsGIT/dicosJSON/bonjour.json", "r"), true);
                $key                    = array_rand($myDicos['welcome']);
                $myDicos['welcome']     = $myDicos['welcome'][$key];
                $key                    = array_rand($myDicos['bonjour']);
                $myDicos['bonjour']     = $myDicos['bonjour'][$key];
                return  $myDicos;
        }

        private function        myDate() {
                return  ucwords(strftime("%A %e %B %Y"));
        }

        private function        myHour() {
                return  $this->nowDate->format("H:i:s");
        }

        private function        myReadMe() {
                return  file_get_contents(__DIR__ . "/../../README.md", "r");
        }

        private function        myReadMePortfolio(string $url = "flourdau/flourdau/main/README.md"): string
        {
                return  file_get_contents("https://raw.githubusercontent.com/" . $url, "r");                
        }

        public function         getInfo() {
                return  $this->myTabInfo;
        }

        public function         getDate() {
                return  $this->nowDate;
        }

}