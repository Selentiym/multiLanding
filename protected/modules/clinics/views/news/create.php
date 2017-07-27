<h1><?php echo CHtml::encode('Создать новость'); ?></h1>

<?php $this->renderPartial('/news/_form', array('model'=>$model)); ?>