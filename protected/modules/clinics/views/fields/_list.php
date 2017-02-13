<?php

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $('#fields-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
");
$word = ($model -> object_type) == Objects::model() -> getNumber('clinics') ? 'клиник' : 'докторов';
?>

<h1><?php echo CHtml::encode('Перечень полей '.$word); ?></h1>

<p class="pull-right">
    <?php echo CHtml::link('Добавить новое' , $this -> createUrl('admin/FieldCreateGlobal',['modelName' => Objects::model() -> getName ($model -> object_type)]), array('class' => 'btn')); ?>
</p>
<br/>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'fields-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'enablePagination' => true,
    'summaryText' => '',
    'template'=>'{pager}{items}',
    'pager' => array(
        'firstPageLabel'=>'<<',
        'prevPageLabel'=>'<',
        'nextPageLabel'=>'>',
        'lastPageLabel'=>'>>',
        'maxButtonCount'=>'10',
        'header'=>'<span>Перейти на страницу:</span>',
    ),
    'columns'=>array(
        'id',      
        array('name' => 'name', 'header' => $model->getAttributeLabel('name')),
        array('name' => 'title', 'header' => $model->getAttributeLabel('title')),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update}&nbsp;{delete}',
            'deleteConfirmation'=>"js:'Вы действительно хотите удалить поле <'+$(this).parent().parent().children(':nth-child(3)').text()+'>?'",
            'buttons'=>array
            (
                'update' => array
                (
                    'label'=> CHtml::encode('Редактировать'),
                    //'url'=>'Yii::app()->createUrl("admin/'.Objects::model() -> getName ($model -> object_type).'FieldUpdateGlobal", array("id"=>$data->id))',
                    'url'=>function($data){
                        $this -> createUrl('admin/FieldUpdateGlobal',['modelName' => Objects::model() -> getName ($data -> object_type), 'id' => $data->id]);
                    },
                ),
                'delete' => array
                (
                    'label'=> CHtml::encode('Удалить'),
                    //'url'=>'Yii::app()->createUrl("admin/FieldDeleteGlobal", array("id"=>$data->id))',
                    'url'=>function($data){
                        $this -> createUrl('admin/FieldDeleteGlobal',['id' => $data->id]);
                    },
                ),
            ),
        ),
    ),
)); ?>
