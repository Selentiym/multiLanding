<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 22.05.2017
 * Time: 16:04
 */
class Service extends clinics {
    public function parsePrices() {
        if (!$this -> external_link) {
            return [];
        }
        require_once(Yii::getPathOfAlias('application.components.simple_html_dom') . '.php');
        $html = file_get_html($this -> external_link);
        $enc = "utf-8";
        $rez = [];
        $lines = $html -> find('tr.price-details');
        foreach ($lines as $line) {
            $str = $line -> innerText();
            $arr = array_map('strip_tags',explode('</td>',$str));
            $arr[1]=preg_replace('/[^\d]/','',$arr[1]);
            $key = $arr[0];
            $val = $arr[1];
            $rez[mb_strtolower(trim($key),$enc)] = $val;
        }
        return $rez;
    }

    public function getPriceValuesArray($refresh = false, $triggers = []){
        if ((!isset($this -> _priceValues))||$refresh) {
            $old = parent::getPriceValuesArray(true);
            $this -> _priceValues = [];
            $objs = ObjectPrice::model() -> findAllByAttributes(['object_type' => Objects::getNumber('clinics')]);
            //Потом будем для них искать минимальную цену
            $toSearch = [];
            foreach ($objs as $price) {
                //Проставляем найденные на mrt-catalog'е цены
                if ($old[$price -> id] instanceof ObjectPriceValue) {
                    $this -> _priceValues[$price -> id] = $old[$price -> id];
                } else {
                    $toSearch[$price -> id] = $price;
                }
            }
            //Ищем минимальные по партнерам
            $searched = ObjectPrice::calculateMinValues($toSearch,$triggers);
            foreach ($searched as $id => $price) {
                if ($price -> getCachedPrice() instanceof ObjectPriceValue) {
                    $this -> _priceValues[$id] = $price -> getCachedPrice();
                }
            }
        }
        return $this -> _priceValues;
    }

    // this is standard function for getting a model of the current class
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}