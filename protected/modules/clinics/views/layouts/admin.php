<?php
/* @var $this Controller */
/**
* @type ClinicsModule $mod
*/
$mod = $this -> getModule();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <!-- custom CSS -->
    <?php //Yii::app()->bootstrap->register(); ?>
    <?php $mod -> registerCSSFile('/css/styles.css'); ?>
    <?php $mod -> registerCSSFile('/css/clinics.css'); ?>
    <?php $mod -> registerCSSFile('/css/jquery-ui.css'); ?>
    <?php $mod -> registerCSSFile('/css/chosen.min.css'); ?>

    <?php Yii::app()->getClientScript()->registerCoreScript('jquery.ui'); ?>
    <?php $mod -> registerJSFile('/js/functions.js'); ?>
    <?php $mod -> registerJSFile('/js/chosen.jquery.min.js'); ?>

    <title><?php echo CHtml::encode(Yii::app()->name . ' - Админка'); ?></title>
</head> 

<body>

<div id="container" class="container-fluid">
        <?php echo CHtml::link(CHtml::image($mod -> getAssetsPath() . '/images/logout_small.png', CHtml::encode('Выйти')), $this -> createUrl('admin/logout'), array('class' => 'pull-right')); ?>

    <div class="row-fluid">
        <?php if ($this->isSuperAdmin()): ?>
            <div class="span2">
                <div id="leftside-cols">
                    <?php
                        $this->widget('zii.widgets.CMenu', array(
                            'items'=>array(
                                //array('label'=> CHtml::encode('Общие настройки'), 'url'=>array('admin/settings'), 'itemOptions' => array('class' => 'page_item')),
                                //array('label'=> CHtml::encode('Пункты меню'), 'url'=>array('admin/MenuButtons'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Клиники'), 'url'=>array('admin/clinics'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Доктора'), 'url'=>array('admin/doctors'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Статьи'), 'url'=>array('admin/ArticleList'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Правила'), 'url'=>array('admin/Rules'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Триггеры'), 'url'=>array('admin/triggers'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Поля для клиник'), 'url'=>array('admin/clinicsFieldsGlobal'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Поля для докторов'), 'url'=>array('admin/doctorsFieldsGlobal'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Блоки цен'), 'url'=>array('admin/PriceBlockList'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Перечень цен клиник'), 'url'=>array('admin/PriceList','modelName'=>'clinics'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Перечень цен докторов'), 'url'=>array('admin/PriceList','modelName'=>'doctors'), 'itemOptions' => array('class' => 'page_item')),
                                //array('label'=> CHtml::encode('Специализация'), 'url'=>array('admin/specialities'), 'itemOptions' => array('class' => 'page_item')),
                                //array('label'=> CHtml::encode('Фильтры для сортировки (клиники)'), 'url'=>array('admin/clinicsFilters'), 'itemOptions' => array('class' => 'page_item')),
                                //array('label'=> CHtml::encode('Фильтры для сортировки (доктора)'), 'url'=>array('admin/doctorsFilters'), 'itemOptions' => array('class' => 'page_item')),
                                //array('label'=> CHtml::encode('Комментарии'), 'url'=>array('admin/comments'), 'itemOptions' => array('class' => 'page_item')),
                                array('label'=> CHtml::encode('Описания при поиске'), 'url'=>array('admin/Descriptions'), 'itemOptions' => array('class' => 'page_item')),
                                //array('label'=> CHtml::encode('Баннеры'), 'url'=>array('admin/banners'), 'itemOptions' => array('class' => 'page_item')),
                                //array('label'=> CHtml::encode('Пользователи'), 'url'=>array('admin/users'), 'itemOptions' => array('class' => 'page_item')),
                            ),
                        ));
                    ?>
                </div>
            </div>
        
            <div class="span10">   
                <?php echo $content;?>
				<?php CustomFlash::showFlashes(); ?>
            </div> <!-- span10 Left Pane -->
        <?php else: ?>
              <?php echo $content;?>      
			  <?php CustomFlash::showFlashes(); ?>
        <?php endif;?>  
		
    </div>

<?php $this->renderPartial('/layouts/_footer'); ?>

</div> <!-- container -->

</body>
</html>
