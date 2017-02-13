<h1><?php echo CHtml::encode('Создать новое значение поля клиники <'.$object -> name .'>.'); ?></h1>

<?php $this->renderPartial('/fields/object/_form', array('model'=>$model, 'object_id' => $id, 'object' => $object)); ?>