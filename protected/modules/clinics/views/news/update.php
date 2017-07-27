<h1><?php echo CHtml::encode('Редактировать новость'); ?></h1>

<?php $this->renderPartial('/news/_form', array('model'=>$model)); ?>