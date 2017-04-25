<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.04.2017
 * Time: 17:22
 */
function icon($icon, $text, $class = ''){
    echo '
<div class="row no-gutters align-items-center">
    <div class="col-auto"><i class="'.$class.' fa fa-'.$icon.' fa-lg fa-fw" aria-hidden="true"></i>&nbsp;</div>
    <div class="col"><div class="text">'.$text.'</div></div>
</div>';
}

function echoClinicsNumber ($arr){
    $verbs = translateVerbiages($arr);
    $num = countClinics($verbs);
    $r = $num.clinicWord($num);
    return CHtml::link($r,Yii::app() -> getController() -> createUrl('home/clinics', $verbs,'&',false,true));
};
function clinicWord ($num) {
    $r = '';
    if ($num == 11) {
        $r .= ' клиниках';
    } elseif ($num % 10 == 1) {
        $r .= ' клинике';
    } elseif($num % 10 != 1 ){
        $r .= ' клиниках';
    }
    return $r;
}
function echoMedCentersNumber ($arr) {
    $verbs = translateVerbiages($arr);
    $num = countClinics($verbs);
    $r = $num;
    if ($num == 11) {
        $r .= ' медицинских центрах';
    } elseif ($num % 10 == 1) {
        $r .= ' медицинском центре';
    } elseif($num % 10 != 1 ){
        $r .= ' медицинских центрах';
    }
    return CHtml::link($r,Yii::app() -> getController() -> createUrl('home/clinics', $verbs,'&',false,true));
};
function translateVerbiages ($verbs) {
    $condition = [];
    foreach ($verbs as $verb) {
        $condition[$verb] = $_GET[$verb];
    }
    $condition = array_filter($condition);
    return $condition;
}
function countClinics ($condition){
    return count(Yii::app() -> getModule('clinics') -> getClinics($condition));
}
function generateGeo($fr, &$triggers, $form = 'Predl'){

    $geo = false;
    //$geoName = $fr('area', 'areaNameRod');
    if ($triggers['prigorod']) {
        $geo = $fr('prigorod','prigorod'.$form);
    }
    if ($triggers['okrug']) {
        $geo = $fr('okrug','ao'.$form).' Москвы';
    }
    if (!$geo) {
        $geo = $fr('area','areaName'.$form);
    }
    return $geo;
}
function generateText($triggers){
    $fr = encapsulateTriggersForRender($triggers);

    $research = $fr('research', 'value');
    if (!$research) {
        if ($triggers['mrt']) {
            $r = 'МРТ ';
        }
        if ($triggers['kt']) {
            $r = $r ? $r.' и КТ' : 'КТ' ;
        }
        $r = $r ? $r : 'МРТ или КТ';
    } else {
        $r = $research;
        $rRod = $fr('research','nameRod');
        $rVin = $fr('research','nameVin');
    }
    $rRod = isset($rRod) ? $rRod : $r;
    $rVin = isset($rVin) ? $rVin : $r;

    $street = $fr('street','value');
    $type = $fr('magnetType', 'type');
    $slices = preg_replace('/[^\d]/','',$fr('slices','value'));
    $field = $fr('field','value');

    $geo = generateGeo($fr, $triggers);

    $mod = Yii::app() -> getModule('clinics');
    echo "<p>Где можно сделать $rVin в {$geo}?</p>";
    echo "<p>В $geo диагностику $r можно пройти в ".echoClinicsNumber(['mrt','kt','research','area','prigorod','okrug']).'</p>';


//    if ($research) {
        echo "<p>Сколько стоит {$r}?</p>";
        echo "<p>Средняя цена на $rVin в {$geo} с учетом всех параметров равна <strong>{$mod->averagePrice($triggers)}руб</strong></p>";
//    }
    if ($street) {
        echo "<p>Где можно сделать $r в непосредственной близости от адреса: {$street}?</p>";
        echo "Пройти $rVin можно в ".echoMedCentersNumber(['district','street'])." в непосредственной близости от адреса: {$street}";
    } elseif ($triggers['district']) {
        if ($distr = $fr('district', 'noDistrict')) {
        } else {
            $distr = $fr('district','districtPredl').' районе';
        }
        echo "<p>Где можно сделать $rVin в $distr?</p>";
        echo "<p>Пройти $rVin можно в ".echoMedCentersNumber(['district','mrt','kt','research','area'])." в $distr.</p>";
    } elseif ($metro = $fr('metro','value')) {
        echo "<p>Где можно сделать $rVin в возле метро $metro?</p>";
        echo "<p>Пройти $rVin можно в ".echoMedCentersNumber(['metro'])." возле метро $metro.</p>";
    }
    if (($type)&&(!$slices)&&(!$field)) {
        echo "<p>$rVin на ".$fr('magnetType','tomografTypeCommentPredl').' томографе можно пройти в '.echoClinicsNumber(['mrt','kt','research','area','magnetType'])."</p>";
    } elseif ($field) {
        echo "<p>$rVin на $field ".$fr('field','fieldCommentPredl')." томографе можно пройти в ".echoClinicsNumber(['mrt','kt','research','area','magnetType','field'])."</p>";
    } elseif ($slices) {
        echo "<p>$rVin на {$slices}-срезовом томографе можно пройти в ".echoClinicsNumber(['mrt','kt','research','area','magnetType','field'])."</p>";
    }
    if ($triggers['contrast']) {
        echo "<p>$rVin с контрастированием можно сделать в ".echoMedCentersNumber(['mrt','kt','research','area','contrast'])."</p>";
        //Определяем, что интересно пользоателю: мрт или кт
        if ($research) {
            $rType = PriceType::getAlias($research->id_type);
        } elseif ($triggers['mrt'] && $triggers['kt']) {
            $rType = 'both';
        } else {
            if ($triggers['mrt']) {
                $rType = 'mrt';
            }
            if ($triggers['kt']) {
                $rType = 'kt';
            }
        }
        if ($rType == 'mrt') {
            echo "
                    <p>Это исследование, при котором пациенту внутривенно вводят парамагнитное контрастное вещество. В отличие от компьютерной томографии, контрастные вещества, используемые в МРТ диагностике легче переносятся организмом, но все же проверить функцию почек перед проведением исследования рекомендуется (анализ на креатинин). Использование контрастного усиления позволяет получить дополнительную диагностическую информацию при поиске и дифференциации новообразований (как доброкачественных, так и злокачественных), позволяет более качественно визуализировать сосуды, также контрастное усиление необходимо в ряде специализированных видов КТ и МРТ диагностики, таких как Перфузия.</p>
                    ";
        } elseif ($rType == 'kt') {
            echo "<p>Это исследование, при котором пациенту внутривенно вводят йодсодержащее контрастное вещество. Нужно понимать, что использование контраста при проведении компьютерной томографии имеет ограничения и противопоказания, к которым относятся: аллергия на йод и сниженная функция почек (рекомендуется сделать анализ на креатинин). Использование контрастного усиления позволяет получить дополнительную диагностическую информацию при поиске и дифференциации новообразований (как доброкачественных, так и злокачественных), позволяет визуализировать сосуды, также контрастное усиление необходимо в ряде специализированных видов КТ и МРТ диагностики, таких как Перфузия.</p>";
        } else {
            echo "<p>Это исследование, при котором пациенту внутривенно вводят йодсодержащее (в случае КТ) или парамагнитное (в случае МРТ) контрастное вещество. Нужно понимать, что использование контраста при проведении компьютерной томографии имеет ограничения и противопоказания, к которым относятся: аллергия на йод и сниженная функция почек (рекомендуется сделать анализ на креатинин). В отличие от компьютерной томографии, контрастные вещества, используемые в МРТ диагностике легче переносятся организмом, но все же проверить функцию почек перед проведением исследования стоит. Использование контрастного усиления позволяет получить дополнительную диагностическую информацию при поиске и дифференциации новообразований (как доброкачественных, так и злокачественных), при КТ позволяет визуализировать сосуды (они не видны без использования контраста), а при МРТ улучшает видимость сосудов, также контрастное усиление необходимо в ряде специализированных видов КТ и МРТ диагностики, таких как Перфузия.Это исследование, при котором пациенту внутривенно вводят йодсодержащее (в случае КТ) или парамагнитное (в случае МРТ) контрастное вещество. Нужно понимать, что использование контраста при проведении компьютерной томографии имеет ограничения и противопоказания, к которым относятся: аллергия на йод и сниженная функция почек (рекомендуется сделать анализ на креатинин). В отличие от компьютерной томографии, контрастные вещества, используемые в МРТ диагностике легче переносятся организмом, но все же проверить функцию почек перед проведением исследования стоит. Использование контрастного усиления позволяет получить дополнительную диагностическую информацию при поиске и дифференциации новообразований (как доброкачественных, так и злокачественных), при КТ позволяет визуализировать сосуды (они не видны без использования контраста), а при МРТ улучшает видимость сосудов, также контрастное усиление необходимо в ряде специализированных видов КТ и МРТ диагностики, таких как Перфузия.</p>";
        }
    }
    if ($triggers['children']) {
        echo "<p>Сделать $rVin ребенку можно в ".echoClinicsNumber(['research','mrt','kt','children','area'])."</p>";
    }
    if ($triggers['sortBy'] == 'priceUp') {
        echo "<p>Медицинские клиники, представленные ниже, отфильтрованы по возрастанию цены на $rVin с учетом: Скидок, Акций и цен Ночью. От более дешевого ценового предложения к более высокому.</p>";
    }
    if ($triggers['time']) {
        echo "<p>Ниже представлены медицинские центры, где $r можно пройти круглосуточно.</p>";
    }
}
function encapsulateTriggersForRender($triggers){
    $triggersPrepared = Article::prepareTriggers($triggers);
    Yii::app() -> getModule('clinics') -> refreshRendered();
    return function ($trigger, $field) use ($triggersPrepared){
        return Yii::app() -> getModule('clinics') -> renderParameter($triggersPrepared, $trigger,$field);
    };
}