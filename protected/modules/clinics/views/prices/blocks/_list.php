<?php
$model = new ObjectPriceBlock();
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

<h1><?php echo CHtml::encode('Перечень блоков цен'); ?></h1>

<p class="pull-right">
    <?php echo CHtml::link('Добавить новый блок цен' , $this -> createUrl('admin/PriceBlockCreate'), array('class' => 'btn')); ?>
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
        array('name' => 'name', 'header' => 'Название'),
        array('name' => 'num', 'header' => 'Приоритет'),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update}&nbsp;{delete}',
            'deleteConfirmation'=>"js:'Вы действительно хотите удалить блок цен <'+$(this).parent().parent().children(':nth-child(2)').text()+'>?'",
            'buttons'=>array
            (
                'update' => array
                (
                    'label'=> CHtml::encode('Редактировать'),
                    //'url'=>'Yii::app()->createUrl("admin/'.Objects::model() -> getName ($model -> object_type).'FieldUpdateGlobal", array("id"=>$data->id))',
                    'url'=>function($data){
                        return $this -> createUrl('admin/PriceBlockUpdate',['id' => $data->id]);
                    },
                ),
                'delete' => array
                (
                    'label'=> CHtml::encode('Удалить'),
                    //'url'=>'Yii::app()->createUrl("admin/FieldDeleteGlobal", array("id"=>$data->id))',
                    'url'=>function($data){
                        return $this -> createUrl('admin/PriceBlockDelete',['id' => $data->id]);
                    },
                ),
            ),
        ),
    ),
)); ?>
