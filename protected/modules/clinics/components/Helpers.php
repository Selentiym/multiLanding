<?php

function echob($str){
    echo "<br/>".$str."<br/>";
}

function resetId($model = NULL) {
    if ($model) { 
        $id = $model->primaryKey;
        $tablename = $model->tableSchema->name;
        $sql = "ALTER TABLE $tablename AUTO_INCREMENT = $id";
        $command = Yii::app()->db->createCommand($sql);
        $result = $command->query(); 
        
        if (!$result)
            throw new CHttpException(404, СHtml::encode('Не удалось обновить ID в таблице $tablename.')); 
    }        
    return;
}
function rus2translit($string) {
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
        
        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    return strtr($string, $converter);
}
function str2url($str) {
    // переводим в транслит
    $str = rus2translit($str);
    // в нижний регистр
    $str = strtolower($str);
    // заменям все ненужное нам на "-"
    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
    // удаляем начальные и конечные '-'
    $str = trim($str, "-");
    return $str;
}

function prepareTextToJS($str) {
    $search = array ("'<script[^>]*?>.*?</script>'si",  // Вырезает javaScript
        "'<[\/\!]*?[^<>]*?>'si",           // Вырезает HTML-теги
        "'([\r\n])[\s]+'",                 // Вырезает пробельные символы
        "'&(quot|#34);'i",                 // Заменяет HTML-сущности
        "'&(amp|#38);'i",
        "'&(lt|#60);'i",
        "'&(gt|#62);'i",
        "'&(nbsp|#160);'i",
        "'&(iexcl|#161);'i",
        "'&(cent|#162);'i",
        "'&(pound|#163);'i",
        "'&(copy|#169);'i",
        "'&#(\d+);'e");                    // интерпретировать как php-код

    $replace = array ("",
        "",
        "\\1",
        "\"",
        "&",
        "<",
        ">",
        " ",
        chr(161),
        chr(162),
        chr(163),
        chr(169),
        "chr(\\1)");

    $text = preg_replace($search, $replace, $str);
    return $text;
}
function giveDistrictByCoords($lat,$long){
    $url = "https://geocode-maps.yandex.ru/1.x/?kind=district&geocode=N{$lat}%20E{$long}&format=json";
    $json = @file_get_contents($url);
    if (!$json) {
        return false;
    }
    $rez = json_decode($json);
    $name = '';
    try {
        //$name = end($rez->response->GeoObjectCollection->featureMember)->GeoObject->name;
        foreach ($rez->response->GeoObjectCollection->featureMember as $item) {
            $temp = $item -> GeoObject -> name;
            if (preg_match('/\W*район\W*/ui',$temp)) {
                $name = trim(preg_replace('/\W*район\W*/ui','',$temp));
            }
        }
    } catch (Exception $e) {
        new CustomFlash('error','BaseModel','NoDistrict','Could not geodecode district',true);
    }
    return $name;
    //$rez -> Ge
}
function giveMetroNamesArrayByCoords($lat,$long, $deltax='0.1', $deltay='0.1'){
    $str = urlencode($deltax.' '.$deltay);
    $url = "https://geocode-maps.yandex.ru/1.x/?kind=metro&geocode=N{$lat}%20E{$long}";//.'&'."rspn=0&spn={$str}";
    $xml = file_get_contents($url);
    $obj = new SimpleXMLElement($xml);
    return giveMetrosNamesArrayByXML($obj);
}
function giveMetroNamesArrayByAddress($addr, $deltax='0.1', $deltay='0.1'){
    $addr = urlencode($addr);
    $url = "https://geocode-maps.yandex.ru/1.x/?kind=metro&geocode={$addr}";
    $xml = file_get_contents($url);
    $obj = new SimpleXMLElement($xml);
    return giveMetrosNamesArrayByXML($obj);
}
function giveMetrosNamesArrayByXML($obj){
    //var_dump($obj);
    $obj = $obj -> GeoObjectCollection -> featureMember ;
    $rez = array();
    $count = 0;
    foreach ($obj as $metroObj) {
        $temp = trim( preg_replace('/метро/','',($metroObj -> GeoObject -> name)));
        if (($temp != $metroObj -> GeoObject -> name)&&(!in_array($temp,$rez))) {
            $rez[] = $temp;
            $count ++;
        }
        if ($count == 3) {
            break;
        }
    }
    //var_dump($rez);
    return array_filter($rez);
    //var_dump(get_object_vars($obj));
}
function toRad($grad){
    return Pi() * $grad / 180;
}

/**
 * All angles in degrees! $fi - долгота, $teta - широта
 * @param float $fi1
 * @param float $teta1
 * @param float $fi2
 * @param float $teta2
 * @param float $R
 * @return float distance between two pints in meters
 */
function DistanceSpherical_bad($fi1,$teta1,$fi2,$teta2, $R = 6371302.0) {
//    $fi1 = toRad($fi1);
//    $fi2 = toRad($fi2);
    $teta1 = toRad($teta1);
    $teta2 = toRad($teta2);
    return $R * acos( cos($teta1)*cos($teta2) * cos(toRad($fi1 - $fi2))+ sin($teta1)*sin($teta2)  );
}
//Невский, 1 59.936846, 30.312176
//Адмиралтейская 59.935831, 30.315203
//59.937986, 30.322821
//метро невский проспект 59.935579, 30.327025
//метро академическая 60.012719, 30.396133
//метро чернышевская 59.944436, 30.359975
//метро ладожская 59.932495, 30.439306
//метро ладожская из базы 59.93244, 30.439474
//метро площадь Александра невского 59.923563, 30.383421
//метро площадь Александра невского из базы 59.92365, 30.383471
//беларусская, 4 59.935786, 30.499708
//echo DistanceSpherical(30.322821, 59.937986, 30.312176, 59.936846);
//echo DistanceSpherical(30.327025, 59.935579, 30.383421, 59.923563);
//echo DistanceSpherical(30.322821, 59.937986, 30.322821, 59.937987);
/**
 * All angles in degrees! $fi - долгота, $teta - широта
 * Calculate using converting to cartesian coordinates
 * @param float $fi1
 * @param float $teta1
 * @param float $fi2
 * @param float $teta2
 * @param float $R
 * @return float distance between two pints in meters
 */
function DistanceSpherical($fi1,$teta1,$fi2,$teta2, $R = 6371302) {
    $fi1 = toRad($fi1);
    $fi2 = toRad($fi2);
    $teta1 = toRad($teta1);
    $teta2 = toRad($teta2);

    $x1 = $R * cos($teta1) * cos($fi1);
    $y1 = $R * cos($teta1) * sin($fi1);
    $z1 = $R * sin($teta1);
    $x2 = $R * cos($teta2) * cos($fi2);
    $y2 = $R * cos($teta2) * sin($fi2);
    $z2 = $R * sin($teta2);
    return (sqrt( pow(($x1-$x2),2) + pow(($y1-$y2),2) + pow(($z1-$z2),2) ));
}
function uploadImage($target_url,$whereToStore){
    if ($target_url) {
        //$target_url = "https://site.ru/file.gz";
        $userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';
        $ch = curl_init($target_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        $output = curl_exec($ch);
        $fh = fopen($whereToStore, 'w');
        fwrite($fh, $output);
        fclose($fh);
        return true;
    }
    return false;
}
function getCoordinates($address) {
    $url="http://geocode-maps.yandex.ru/1.x/?geocode=".urlencode($address);
    //echo $url;
    @$content=file_get_contents($url);
    //echo $content;
    preg_match('/<pos>(.*?)<\/pos>/',$content,$point);
    preg_match('/<found>(.*?)<\/found>/',$content,$found);
    if (trim(next($found)) > 0) {
        $coords=explode(' ',trim(strip_tags($point[1])));
        $rez = [
            'lat' => $coords[1],
            'long' => $coords[0]
        ];
    } else {
        throw new HttpException('Could not geodecode address '.$address.' via geocode-maps.yandex.ru/1.x');
    }
    return $rez;
}