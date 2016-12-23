<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.12.2016
 * Time: 21:14
 *
 * AController is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class AController extends Controller
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $baseHref=false;
    public $viewPrefix='';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu=array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs=array();

    /**
     * @var string page description
     */
    public $pageDescription = '';


    public function render($view,$data=null,$return=false)
    {
        return parent::render($this->viewPrefix.$view,$data,$return);
    }
}