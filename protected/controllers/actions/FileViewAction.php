<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.07.2016
 * Time: 10:03
 */
class FileViewAction extends UAction implements iCallFunc {
    use tCallFunc;
    /**
     * @var callable access function to be called to access page
     */
    public $access = true;
    /**
     * @var callable access function to be called to access page
     */
    public $guest = false;
    /**
     * @var string view for render
     */
    public $view;
    /**
     * @var bool $partial whether to use renderPartial or Render
     */
    public $partial = false;
    /**
     * if $this ->partial is true, then this option shows whether to show scripts
     */
    public $showScripts = false;
    /**
     *
     */
    public $layout = 0;
    /**
     * @throws CHttpException
     */
    public function run()
    {
        if ((!Yii::app() -> user -> isGuest)||($this -> guest)) {
            if (!is_callable($this -> access)) {
                $this -> access = function(){ return $this -> access;};
            }
            if (is_callable($this -> access)) {
                /** Работа с историей  */
                if (is_callable($this -> ignore)) {
                    $this -> ignore = call_user_func($this -> ignore);
                }
                /** Конец работы с историей */
                $name = $this -> access;
                if ($name()) {
                    if ($this -> layout !== 0) {
                        $this->controller->layout = $this->layout;
                    }
                    if (!$this->partial){
                        $this->controller->render($this->getAttribute('view'), array('get' => $_GET));
                    } else {
                        $this->controller->renderPartial($this->view, array('get' => $_GET), false, $this -> showScripts);
                    }
                } else {
                    $this -> controller -> render('//accessDenied');
                }
            }
            //}
        } else {
            $this -> controller -> redirect(Yii::app() -> baseUrl.'/login');
        }
    }
    /**
     * @param string $name
     * @return bool
     */
    function _isAllowedToEvaluate($name) {
        return true;
    }
}
?>