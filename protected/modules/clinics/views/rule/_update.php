<h1><?php echo CHtml::encode('Редактировать правило <'); ?> <?php echo $model->verbiage; ?>> кодекса для объектов <?php echo Article::getTypeName($model -> id_object_type); ?> </h1>
<br/>
<?php $this->renderPartial('/rule/_form', array('model'=>$model)); ?>