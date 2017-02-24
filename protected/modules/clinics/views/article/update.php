<h1><?php echo CHtml::encode('Редактировать статью <' . $model->name . '>'); ?></h1>

<?php $this->renderPartial('/article/_form', array('model'=>$model)); ?>