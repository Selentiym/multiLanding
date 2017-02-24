<h1><?php echo CHtml::encode('Создать статью'); ?></h1>

<?php $this->renderPartial('/article/_form', array('model'=>$model)); ?>