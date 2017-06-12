<?php
class AdminController extends Controller {
	protected function beforeAction(){
		Comment::setModule($this -> getModule());
		VKAccount::setModule($this -> getModule());
		return true;
	}
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
	public function actionGetReviewsHtml(){
		$data = $_POST;
		if (empty($data['ids'])) {
			$data['ids'] = [];
		}
		$page = $data['currentPage'];
		if (!$page) {
			$page = 0;
		}
		$pageSize = $this -> getModule() -> pageSize;
		$ids = array_slice($data['ids'],$page * $pageSize, $pageSize);
		$this -> renderPartial('/_comments',[
			'reviews' => Comment::model() -> findAllByPk($ids),
			'showButton' => $page < (ceil(count($data['ids']) / $pageSize) - 1)
		]);
	}
	/**
	 * Saves an added comment.
	 */
	public function actionAddReview() {
		Comment::setModule($this -> getModule());
		$model = new Comment();
		$isNew = true;
		if (isset($_POST['Comment'])) {
			$model->attributes = $_POST['Comment'];

			$vkAccount = VkAccount::createByVkId($model->vk_id);
			$model->vk_id = $vkAccount->id;
			$vkAccount->occupied = 1;
			$vkAccount->save();
			$rez = [];
			if ($model->save()) {
				$isNew = false;
				$rez['success'] = true;
				$rez['html'] = $this -> renderPartial('/_comments',['showButton' => false, 'reviews' => [$model]], true);
			} else {
				$rez['success'] = false;
				$errors = $model->getErrors();
				$error_message = '';
				foreach ($errors as $error) {
					$error_message .= implode('<br/>', $error);
				}
			}
			echo json_encode($rez);
		}
	}
	public function actionToggleComment($id){
		$c = Comment::model() -> findByPk($id);
		$rez['success'] = false;
		if ($c instanceof Comment) {
			$c -> approved = (int)(!$c -> approved);
			$rez['success'] = $c -> save();
			$err = $c -> getErrors();
		}
		$rez['approved'] = $c -> approved;
		echo json_encode($rez);
	}
}