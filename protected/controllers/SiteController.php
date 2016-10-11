<?php

class SiteController extends Controller
{
	const FULL_CYCLE_MINS = 2;
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			/*'index'=>array(
				'class'=>'application.controllers.actions.FileViewAction',
				'view' => '//subs/index'
			),*/
			'index'=>array(
				'class'=>'application.controllers.site.ModelViewAction',
				'modelClass' => 'Rule',
				'view' => function($rule){
					/**
					 * @type CWebApplication $app
					 */
					$app = Yii::app();
					$folder = $app->session->get('folder');
					$newVisit = false;
					if (!$folder) {
						$newVisit = true;
						$time = time();
						//Каждые self::FULL_CYCLE_MINS/2 минут меняем представление.
						if ($time % (60 * self::FULL_CYCLE_MINS) < 30 * self::FULL_CYCLE_MINS) {
							$folder = '//subs/';
						} else {
							$folder = '//subs_thirdDesign/';
							//$folder = '//subs_newDesign/';
						}
					}
					//пересохраняем сессию

					$folder = '//subs_thirdDesign/';
					//$folder = '//subs_newDesign/';
					//$folder = '//subs/';
					$view = new View();
					$view -> folder = $folder;
					$view -> newVisit = $newVisit;
					$view -> agent = $_SERVER['HTTP_USER_AGENT'];
					$view -> address = urldecode($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
					$view -> save();
					$app->session->add('folder', $folder);
					return $folder . 'index';
				},
				'scenario' => Rule::USE_RULE,
				'external' => $_GET
			),
			'post' => array(
				'class'=>'application.controllers.site.FileViewAction',
				'view' => '//subs/post',
				'partial' => true
			),
			'post_newDesign' => array(
				'class'=>'application.controllers.site.FileViewAction',
				'view' => '//subs_newDesign/post',
				'partial' => true
			),
			'post_thirdDesign' => array(
				'class'=>'application.controllers.site.FileViewAction',
				'view' => '//subs_thirdDesign/post',
				'partial' => true
			),
		);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	public function actionCheck() {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Устанавливаем параметр, чтобы curl возвращал данные, вместо того, чтобы выводить их в браузер.
		curl_setopt($ch, CURLOPT_URL, 'http://mrt-to-go.ru');
		curl_setopt($ch, CURLOPT_COOKIE, '');
		$data = curl_exec($ch);
	}
	/**
	 *
	 */
	public function actionTransfer(){
		$count = 0;
		foreach (Rule::model() -> findAll() as $rule) {
			if ($rule -> price) {
				$rule -> prices_input = array($rule -> price -> id);
			}
			if ($rule -> save()){
				$count ++;
			} else {
				var_dump($rule -> getErrors());
			}
		}
		echo $count;
	}
	public function actionBlock(){
		if (Yii::app()->request->isAjaxRequest) {
			$section = Section::model()->findByPk($_POST['section_id']);
			$rule = Rule::model()->findByPk($_POST["rule_id"]);
			$base = Yii::app()->baseUrl;
			$tel = $_POST['tel'];
			$prices_temp = $rule -> prices;
			$rule -> price = current($prices_temp);
			if (!(is_a($rule -> price, 'Price'))) {
				$rule -> price = Price::model() -> findByPk(Price::trivialId());
			}
			$this->renderPartial(Yii::app() -> session -> get('folder') . $section->view, array('model' => $rule, 'base' => $base, 'tel' => $tel));
		} else {
			echo "Ajax use only!";
		}
	}
	public function actionGiveStatistics(){
		$a = $_POST;
		$periodMins = $a["periodMins"];
		$from = $a["from"];
		$to = $a["to"];
		$key = $a["key"];
		$rez = [];
		if ($key == '123qwerty123jjjjkkkklll') {
			$sql = "SELECT COUNT(`id`) as `count`, @mins := FLOOR((UNIX_TIMESTAMP(`date`)%(86400))/(60*$periodMins))*$periodMins as `minutesFromDaystart`, FLOOR(@mins/60) as `hours`, @mins%60 as `minutes` FROM `tbl_views` WHERE `robot`='0' AND `date` > FROM_UNIXTIME($from) AND `date` < FROM_UNIXTIME($to) GROUP BY FLOOR((UNIX_TIMESTAMP(`date`)%(86400))/(60*$periodMins)) ORDER BY @mins ASC";
			$q = mysqli_query(MysqlConnect::getConnection(), $sql);


			while ($arr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
				//var_dump($arr);
				$key = date('G:i', $arr['minutesFromDaystart'] * 60);
				$count = (int)$arr['count'];
				if ($count > 0) {
					$rez[$key] = $count;
					//$cc ++;
				}
			}
			//echo $cc;
			//var_dump($rez);

		} else {
			$rez['error'] = 'Ключ неверный.';
		}
		echo json_encode($rez, JSON_PRETTY_PRINT);
	}
}