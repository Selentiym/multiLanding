<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.06.2017
 * Time: 12:09
 */
class baseSpecHelpers {
    /**
     * @param string $verbiage of the trigger to be rendered
     * @param mixed[] $triggers
     * @return string - the html code of the trigger (for TickTrigger instances only!)
     */
    public static function customCheckbox($verbiage, &$triggers){
        return Triggers::triggerHtml($verbiage,$triggers,[],['renderFunc' => function($trigger, $htmlOptions, $dopParameters, $data){
            $mainVal = current($trigger -> trigger_values);
            $children = $trigger -> getChildrenHtml($data, $htmlOptions['id']);
            if ($dopParameters['noChildren']) {
                $children = '';
            }
            $htmlOptions['class'] .= ' custom-control-input';
            return "<label for='{$htmlOptions['id']}' class='custom-control custom-checkbox'>".CHtml::checkBox(
                $trigger -> verbiage,
                in_array($mainVal -> verbiage,empty($data[$trigger -> verbiage]) ? [] : [$data[$trigger -> verbiage]]),
                $htmlOptions
            ) . '<span class="custom-control-indicator"></span>' .
            " <span class='custom-control-description'>{$mainVal->value}</span></label>" . $children;
        }]);
    }

    public static function salesWord($number){
        if (($number < 20)&&($number > 10)) {
            $str = $number.' скидок';
        } elseif ($number % 10 == 1) {
            $str = $number.' скидка';
        } elseif (in_array($number % 10, [2,3,4])) {
            $str = $number.' скидки';
        } else {
            $str = $number.' скидок';
        }
        return $str;
    }

    /**
     * @param int $num
     * @return string
     */
    public static function medCenterWordRod($num){
        $r = $num;
        if ($num == 11) {
            $r .= ' медицинских центров';
        } elseif ($num % 10 == 1) {
            $r .= ' медицинского центра';
        } elseif($num % 10 != 1 ){
            $r .= ' медицинских центров';
        }
        return $r;
    }
    /**
     * @return array
     */
    public static function dataForStandardArticleCards(){
        $baseTheme = Yii::app() -> getTheme() -> baseUrl;
        return [
            'msc' => [
                'url' => Yii::app() -> controller -> createUrl('home/clinics',['area' => 'msc'], '&',true),
                'imageUrl' => $baseTheme . '/images/msk.png',
                'name' => 'Адреса и цены на МРТ и КТ в Москве',
                'description' => 'Лучшие предложения МРТ и КТ диагностики в Москве, более 170 клиник, информация о ценах и акциях, выбрать ближайший центр - адреса, районы, метро.  МРТ и КТ с контрастом, обзор частных и государственных клиник, где можно пройти обследование ночью, принимают ли маленьких детей.'
            ],
            'lib' => [
                'url' => Yii::app() -> getBaseUrl() . '/',
                'imageUrl' => $baseTheme . '/images/lib.png',
                'name' => 'Библиотека',
                'description' => 'Всё об МРТ и КТ исследованиях, когда назначают, основные показания и противопоказания, советы по подготовке. Чем отличается МРТ от КТ, принцип работы, как проходит исследование. Ответы на самые часто задаваемые вопросы Вы найдёте в статьях этого раздела.'
            ],
            'spb' => [
                'url' => Yii::app() -> controller -> createUrl('home/clinics',['area' => 'spb'], '&',true),
                'imageUrl' => $baseTheme . '/images/spb.png',
                'name' => 'Адреса и цены на МРТ и КТ в СПб',
                'description' => 'Выгодные предложения МРТ и КТ диагностики в Санкт-Петербурге, более 100 медцентров, информация о ценах и скидках, выбрать ближайшую клинику - адреса, районы, метро.  МРТ и КТ с контрастированием, обзор частных и государственных центров, где можно пройти обследование круглосуточно, с какого возраста проводят диагностику ребенку.'
            ]
        ];
    }
    public static function articleForImagedShortcut(Article $a){
        $arr = [];
        $arr ['url'] = Yii::app() -> controller -> createUrl('home/articleView',['verbiage' => $a -> verbiage]);
        $arr ['imageUrl'] = ($url = $a -> getImageUrl()) ? $url : Yii::app() -> getTheme() -> baseUrl . '/images/noImgArticle.png';
        $arr ['name'] = $a -> name;
        $arr ['description'] = $a -> description;
        return $arr;
    }
}