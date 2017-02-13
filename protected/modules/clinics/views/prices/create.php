<h1><?php echo CHtml::encode('Создать цену'); ?></h1>

<?php $this->renderPartial('/prices/_form', array('model'=>$model)); ?>