<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.02.2017
 * Time: 21:40
 */
class TaskController extends CController {
    /**
     * Ajax action that returns children info by the given task id
     */
    public function actionChildren(){
        $data = $_GET;
        if ($data['id']) {
            $model = Task::model()->findByPk($data['id']);
            $models = $model -> children;
        } else {
            $models = array_merge(Task::model() -> root() -> findAll(), Task::model() -> uncategorized() -> findAll());
        }
        echo json_encode(UHtml::giveArrayFromModels($models,function($el){
            /**
             * @type Task $el
             */
            return $el -> dumpForProject();
        }), JSON_PRETTY_PRINT);
    }

    /**
     * @param integer $id of the task! not of the text
     */
    public function actionGetText($id) {
        $task = Task::model() -> findByPk($id);
        /**
         * @type Task $task
         */
        echo json_encode($task -> dumpText(), JSON_FORCE_OBJECT);
    }
}