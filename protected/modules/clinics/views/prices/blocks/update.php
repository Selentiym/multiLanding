<h1><?php echo CHtml::encode('Редактировать блок цен <' . $model->name . '>'); ?></h1>

<?php $this->renderPartial('/prices/blocks/_form', array('model'=>$model)); ?>