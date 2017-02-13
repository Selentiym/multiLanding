<h1><?php echo CHtml::encode('Редактировать значение поля <'.$model->field->title.'> '.(get_class($object) == 'clinics' ? 'клиники': 'доктора').' <'.$object -> name.'>.'); ?></h1>

<?php $this->renderPartial('/fields/object/_form', array('model'=>$model, 'object' => $object)); ?>