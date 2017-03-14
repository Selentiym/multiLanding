<?php
class AdminController extends Controller {
	public function actionIndex() {
		$this->render('index');
	}

	/**
	 * @return VKCommentsModule
	 */
	public function getModule() {
		return parent::getModule();
	}
	public function actionGetRandomVK(){
		$data = $this -> getModule() -> randomPerson();
		$this -> renderPartial('/rawVK', ['data' => $data]);
	}
}