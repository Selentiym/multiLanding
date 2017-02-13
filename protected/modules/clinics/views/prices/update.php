<h1><?php echo CHtml::encode('Редактировать цену <' . $model->name . '>'); ?></h1>

<?php $this->renderPartial('/prices/_form', array('model'=>$model)); ?>