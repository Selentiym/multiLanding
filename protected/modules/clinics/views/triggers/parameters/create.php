<h1><?php echo CHtml::encode('Создать новый параметр триггера <'.$model -> trigger -> name.'>'); ?></h1>

<?php $this->renderPartial('/triggers/parameters/_form', array('model'=>$model)); ?>

<?php CustomFlash::showFlashes(); ?>