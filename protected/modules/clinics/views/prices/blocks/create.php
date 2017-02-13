<h1><?php echo CHtml::encode('Создать блок цен'); ?></h1>

<?php $this->renderPartial('/prices/blocks/_form', array('model'=>$model)); ?>