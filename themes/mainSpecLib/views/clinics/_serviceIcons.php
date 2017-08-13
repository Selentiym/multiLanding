<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13.08.2017
 * Time: 16:12
 *
 * @type Service $model
 */
$phone = $model -> getPhoneObject();
$this -> renderPartial('/clinics/_icon',['iClass' => 'fa-phone', 'text' => CHtml::link($phone -> getFormatted(),'tel:'.$phone -> getUnformatted())]);
$this -> renderPartial('/clinics/_icon', ['iClass' => 'fa-child', 'text' => "Обследования <strong>детям</strong>, в том числе <strong>без наркоза</strong>"]);
$this -> renderPartial('/clinics/_icon', ['iClass' => 'fa-map', 'text' => "Клиники по <strong>всему городу</strong>!"]);
$this -> renderPartial('/clinics/_icon', ['iClass' => 'fa-train', 'text' => 'Любая <strong>удобная Вам станция</strong> метро']);
$this -> renderPartial('/clinics/_icon', ['iClass' => 'fa-calendar-check-o', 'text' => 'Звоните <strong>с 8:00 до 23:00</strong>, заявки принимаем <strong>круглосуточно</strong>!']);
$this -> renderPartial('/clinics/_icon', ['iClass' => 'fa-hand-stop-o', 'text' => '<strong>Без ограничений</strong> по весу или объему!']);