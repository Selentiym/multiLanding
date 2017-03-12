<h1><?php echo CHtml::encode('Добавить новое правило в кодекс для объектов '.Article::getTypeName($model -> id_object_type)); ?></h1>
<br/>
<?php $this->renderPartial('/rule/_form', array('model'=>$model)); ?>