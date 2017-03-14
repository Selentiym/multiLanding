<?php
class AdminController extends Controller {
	public function actions() {
		return [
		];
	}

	/**
	 * @return VKCommentsModule
	 */
	public function getModule() {
		return parent::getModule();
	}
	public function actionGetRandomVK(){
		$data = $this -> getModule() -> randomPerson();
		$rez = [];
		$rez ['html'] = $this -> renderPartial('/VKAccount', ['model' => VKAccount::createFromRaw($data)], true);
		$rez['id'] = $data -> id;
		echo json_encode($rez);
	}
}