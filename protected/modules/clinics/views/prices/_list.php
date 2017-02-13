<?php
$modelName = get_class($model);
$model = new ObjectPrice();
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
?>

<h1><?php echo CHtml::encode('Перечень цен '.$word); ?></h1>

<p class="pull-right">
    <?php echo CHtml::link('Добавить новую' , $this -> createUrl('admin/PriceCreate',['modelName' => $modelName]), array('class' => 'btn')); ?>
</p>
<br/>

<?php
$model -> object_type = Objects::getNumber($modelName);
$this->widget('zii.widgets.grid.CGridView', array(
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
        array('name' => 'name', 'header' => 'Название'),
        array('name' => 'id_type', 'value' => function($data){ echo $data -> type -> name; }, 'header' => 'Тип'),
        array('name' => 'id_block','value' => function($data){ echo $data -> block -> name; } , 'header' => "Блок"),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update}&nbsp;{delete}',
            'deleteConfirmation'=>"js:'Вы действительно хотите удалить цену <'+$(this).parent().parent().children(':nth-child(2)').text()+'>?'",
            'buttons'=>array
            (
                'update' => array
                (
                    'label'=> CHtml::encode('Редактировать'),
                    //'url'=>'Yii::app()->createUrl("admin/'.Objects::model() -> getName ($model -> object_type).'FieldUpdateGlobal", array("id"=>$data->id))',
                    'url'=>function($data){
                        return $this -> createUrl('admin/PriceUpdate',['id' => $data->id]);
                    },
                ),
                'delete' => array
                (
                    'label'=> CHtml::encode('Удалить'),
                    //'url'=>'Yii::app()->createUrl("admin/FieldDeleteGlobal", array("id"=>$data->id))',
                    'url'=>function($data){
                        return $this -> createUrl('admin/PriceDelete',['id' => $data->id]);
                    },
                ),
            ),
        ),
    ),
)); ?>
