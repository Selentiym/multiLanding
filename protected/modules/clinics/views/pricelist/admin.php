<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#price-list-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo CHtml::encode('Перечень цен на услуги '.(get_class($object) == get_class(clinics::model()) ? 'клиники' : 'врача').' <' . $object->name .'>'); ?></h1>

<p class="pull-right">
	<?php echo CHtml::link('Добавить новую' , $this -> createUrl('admin/PricelistCreate',['modelName' => get_class($object), 'id' => $object->id]), array('class' => 'btn')); ?>
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'price-list-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'enablePagination' => true,
		'summaryText' => '',
		'columns'=>array(
				array('name' => 'id', 'header' => $model->getAttributeLabel('id')),
			//array('name' => 'object_id', 'header' => $model->getAttributeLabel('object_id')),
			//array('name' => 'object_type', 'header' => $model->getAttributeLabel('object_type'), 'value' => 'Objects::model() -> getName($data -> object_type)'),
				array('name' => 'name', 'header' => $model->getAttributeLabel('name')),
				array('name' => 'price', 'header' => $model->getAttributeLabel('price')),

				array(
						'class'=>'CButtonColumn',
						'template'=>'{update}&nbsp;{delete}',
						'deleteConfirmation'=>"js:'Вы действительно хотите удалить цену <'+$(this).parent().parent().children(':nth-child(2)').text()+'>?'",
						'buttons'=>array
						(
								'update' => array
								(
										'label'=> CHtml::encode('Редактировать'),
										'url'=>function ($data) {
											return $this -> createUrl("admin/PricelistUpdate",['id' => $data -> id]);
										},
								),
								'delete' => array
								(
										'label'=> CHtml::encode('Удалить'),
										'url'=>function ($data) {
											return $this -> createUrl("admin/PricelistDelete",['id' => $data -> id]);
										},
								),

						),

				),
		),
)); ?>
