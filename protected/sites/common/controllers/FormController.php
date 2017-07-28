<?php

class FormController extends AController
{
	public function actionSubmit()
	{
		$rez['success'] = true;
		$adminemail="shubinsa1@gmail.com";  // e-mail админа
		//$adminemail="bondartsev.nikita@gmail.com";  // e-mail админа
		@$theme="Заказ с сайта MRT (".Yii::app() -> name.")";
		if (!$theme) {
			$theme = 'Заказ с сайта MRT, ошибка при получении имени лендинга';
		}
		$date=date("d.m.y"); // число.месяц.год

		$time=date("H:i"); // часы:минуты:секунды

		$name = trim($_GET["name"]);
		$phone = trim($_GET["phone"]);


		$params = array(
				'pid' => Yii::app() -> params['formLine'],
				'name' => $name,
				'phone' => $phone,
				'description' => 'Заявка с '.Yii::app() -> name
		);

		/**
		 * Send data to DocDoc
		 */

		if ($_GET['city'] == 'msc') {
			try {
				$rez['success'] = false;
				if ($curl = curl_init()) {
					curl_setopt($curl, CURLOPT_URL, 'https://'. Yii::app()->params['dd.credentials'] .'@back.docdoc.ru/api/rest/1.0.6/json/request');
					curl_setopt($curl, CURLOPT_POST, true);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					$formattedNumber = preg_replace('/[^\d]/ui','',$params['phone']);
					$cancel = false;
					switch (mb_strlen($formattedNumber,'utf-8')) {
						case 11:
							if ((mb_substr($formattedNumber,0,1)) != 7) {
								$formattedNumber = '7'.mb_substr($formattedNumber,1);
							}
							break;
						case 10:
							$formattedNumber = '7'.$formattedNumber;
							break;
						default:
							$cancel = true;
							break;
					}
					if (!$cancel) {
						curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode([
							'city' => 1,
							'phone' => $formattedNumber
						]));
						$rez['success'] = true;
						$raw = curl_exec($curl);
						$out = json_decode($raw);
						if ($out -> Response -> status == 'success') {
							$rez['success'] = true;
						}
					}
					curl_close($curl);
				}
			} catch (Exception $e) {}
		}

		/**
		 *
		 */

//посылаем заявку к себе
		if( $curl = curl_init() ) {
			try {
				curl_setopt($curl, CURLOPT_URL, 'http://p.mrimaster.ru/stat/FormAssign?' . http_build_query($params));
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				$id_submit = curl_exec($curl);
				//echo $out;
				curl_close($curl);
			} catch (Exception $e) {

			}
		}
		try {
			$mod = Yii::app() -> getModule('tracker');
			$enter = $mod -> enter;
			if ($enter instanceof aEnter) {
				$enter -> formed = 1;
				$enter -> id_submit = (($id_submit) && ($id_submit != 'none')) ? $id_submit : null;
				$enter -> save();
			}
		} catch (Exception $e) {

		}

//посылаем заявку на новую систему тоже
		if( $curl = curl_init() ) {
			try {
				curl_setopt($curl, CURLOPT_URL, 'http://web-utils.ru/api/form?' . http_build_query($params));
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				$out = curl_exec($curl);
				//echo $out;
				curl_close($curl);
			} catch (Exception $e) {

			}
		}



		try {
			$toSave = new FormSubmit();
			$toSave->name = $name;
			$toSave->phone = $phone;
			$toSave->save();
		} catch (Exception $e) {

		}

		$headers = "From: mrt-to-go@mail.ru\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html\r\n";
		$text = "Дата: <strong>{$date}</strong><br/>";
		$text .= "Время: <strong>{$time}</strong><br/>";
		$text .= "Имя: <strong>{$name}</strong><br/>";
		$text .= "Телефон: <strong>{$phone}</strong><br/>";

		try {
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
			$mail->addAddress('nik_bondar@mail.ru');

			$mail->Subject = $theme;
			$mail->isHtml(true);
			$mail->Body = $text;
			if (!$mail->Send()) {
				//echo "sent!";
			}
		} catch (Exception $e) {

		}
		echo json_encode($rez);
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}