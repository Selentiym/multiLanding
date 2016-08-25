<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16.08.2016
 * Time: 12:17
 */

/*echo '123';
Yii::app() -> end();*/
$adminemail="shubinsa1@gmail.com";  // e-mail админа
//$adminemail="bondartsev.nikita@gmail.com";  // e-mail админа
$theme="Заказ с сайта MRT (новый дизайн)";

$date=date("d.m.y"); // число.месяц.год

$time=date("H:i"); // часы:минуты:секунды

$name = trim($_GET["name"]);
$phone = trim($_GET["phone"]);


    $headers = "From: mrt-to-go@mail.ru\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html\r\n";
    $text = "Дата: <strong>{$date}</strong><br/>";
    $text .= "Время: <strong>{$time}</strong><br/>";
    $text .= "Имя: <strong>{$name}</strong><br/>";
    $text .= "Телефон: <strong>{$phone}</strong><br/>";


    require_once(Yii::getPathOfAlias('webroot.vendor') . DIRECTORY_SEPARATOR . 'autoload.php');
    $mail = new PHPMailer(true);
    $mail = new PHPMailer(true);
    $mail->IsSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAuth = true;
    $mail->Username = 'mrimaster.msk@gmail.com';
$mail->Password = include(Yii::getpathOfAlias('application.components') . '/mrimaster.pss.php');
    $mail->Mailer = "smtp";

    $mail->From = 'directors@mrimaster.ru';
    $mail->FromName = 'mrt-to-go.ru';
    $mail->Sender = 'directors@mrimaster.ru';
    $mail->CharSet = "UTF-8";
    $mail->addAddress($adminemail);
    $mail->addAddress('lg.operator.2@gmail.com');
    $mail->addAddress('olga.seadorova@gmail.com');

    $mail->Subject = $theme;
    $mail->isHtml(true);
    $mail->Body = $text;
    if (!$mail->Send()) {
        //echo "sent!";
    }
    $params = array(
        'pid' => -2,
        'name' => $name,
        'phone' => $phone,
        'description' => 'Заявка с мрттого (новый дизайн)'
    );
    if( $curl = curl_init() ) {
        curl_setopt($curl, CURLOPT_URL, 'http://o.mrimaster.ru/onlineRequest/submit?'.http_build_query($params));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        $out = curl_exec($curl);
        //echo $out;
        curl_close($curl);
    }