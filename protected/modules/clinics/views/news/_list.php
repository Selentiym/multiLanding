<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#trigger-values-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo CHtml::encode('Новости объекта <' . $model->name .'>'); ?></h1>

<p class="pull-right">
    <?php echo CHtml::link('Добавить новую' , $this -> createUrl('admin/NewsCreate',['id' => $_GET['id'],'modelName' => get_class($model)]), array('class' => 'btn')); ?>
</p>

<?php
$news = new News();
$news -> attributes = $_GET['News'];
$news -> id_object = $model -> id;
$news -> object_type = Objects::getNumber(get_class($model));
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'news-grid',
	'dataProvider'=>$news->search(),
	'filter'=>$news,
    'enablePagination' => true,
    'summaryText' => '',
	'columns'=>array(
        array('name' => 'id', 'header' => 'ID'),
        array('name' => 'heading', 'header' => 'Заголовок'),
//        array('name' => 'text', 'header' => 'Текст новости'),
        array('name' => 'validFrom', 'header' => 'От'),
        array('name' => 'validTo', 'header' => 'До'),
        array('name' => 'published', 'header' => 'Дата добавления'),

		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}&nbsp;{delete}',
            'deleteConfirmation'=>"js:'Вы действительно хотите удалить новость <'+$(this).parent().parent().children(':nth-child(2)').text()+'>?'",
            'buttons'=>array
            (
                'update' => array
                (
                    'label'=> CHtml::encode('Редактировать'),
                    //'url'=>'Yii::app()->createUrl("admin/triggerValueUpdate", array("id"=>$data->id))',
                    'url'=>function($data) use ($model){
						return $this -> createUrl('admin/NewsUpdate',['id'=>$data->id, 'modelName' => get_class($model)]);
					},
                ),
                'delete' => array
                (
                    'label'=> CHtml::encode('Удалить'),
                    //'url'=>'Yii::app()->createUrl("admin/triggerValueDelete", array("id"=>$data->id))',
                    'url'=>function($data){
						return $this -> createUrl('admin/NewsDelete',['id'=>$data->id]);
					},
                ),
            ),

		),
	),
)); ?>
