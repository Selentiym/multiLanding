<? 
// ----------------------------конфигурация-------------------------- // 

$adminemail="shubinsa1@gmail.com";  // e-mail админа
//$adminemail="bondartsev.nikita@gmail.com";  // e-mail админа
$theme="Заказ с сайта MRT (старый дизайн)";
 
$date=date("d.m.y"); // число.месяц.год 
 
$time=date("H:i"); // часы:минуты:секунды 
 
$backurl=Yii::app() -> baseUrl."/index";  // На какую страничку переходит после отправки письма 
 
//---------------------------------------------------------------------- // 
 
  
 
// Принимаем данные с формы 
 


if(!empty($_POST['name']) && !empty($_POST['name2'])){

$name=$_POST['name']; 
 
$name2=$_POST['name2']; 
$headers = "From: mrt-to-go@mail.ru\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html\r\n";
	$text = "Дата: <strong>{$date}</strong><br/>";
	$text .= "Время: <strong>{$time}</strong><br/>";
	$text .= "Имя: <strong>{$name}</strong><br/>";
	$text .= "Телефон: <strong>{$name2}</strong><br/>";
 
 
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
		'phone' => $name2,
		'description' => 'Заявка с мрттого'
	);
	if( $curl = curl_init() ) {
		curl_setopt($curl, CURLOPT_URL, 'http://o.mrimaster.ru/onlineRequest/submit?'.http_build_query($params));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
		$out = curl_exec($curl);
		//echo $out;
		curl_close($curl);
	}
	//?pid=-2&name=Иванова&phone=79112885151&description=мрт%20гм
 
 //*/


 
  
 
// Выводим сообщение пользователю 
 
print "<script language='Javascript'><!-- 
function reload() {location = \"$backurl\"}; setTimeout('reload()', 3000); 
//--></script> 
<head>
<link rel='stylesheet' href='main_style.css'>
</head>
<body style='background:;font-family: pf_dintext_proregular;'>
<div style='max-width:500px;margin:10% auto;border:1px solid #efeeee;;background:url(img/logo_mesage.png) no-repeat 50% 95%;color:#000;'>
<h2 style='text-align:center;font-size:20px;padding:2% 0 2% 0'>Спасибо за оформление заявки!</h2>

 
<p style='text-align:left;padding:2%;padding-bottom:60px;'>Подождите, сейчас вы будете перенаправлены на главную страницу...</p>
</div>
</body>";  
//exit; 
 
}else {
	print "<script language='Javascript'><!-- 
function reload() {location = \"$backurl\"}; setTimeout('reload()', 3000); 
//--></script> 
<head>
<link rel='stylesheet' href='main_style.css'>
</head>
<body style='background:;font-family: pf_dintext_proregular;'>
<div style='max-width:500px;margin:10% auto;border:1px solid #efeeee;;background:url(img/logo_mesage.png) no-repeat 50% 95%;color:#000;'>
<h2 style='text-align:center;font-size:20px;padding:2% 0 2% 0'>Заявка не отправлена попробуйте еще раз!</h2>

 
<p style='text-align:left;padding:2%;padding-bottom:60px;'>Подождите, сейчас вы будете перенаправлены на главную страницу...</p>
</div>
</body>";  
}
 
?>