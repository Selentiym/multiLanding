<?php
/**
 * @type TriggerParameter $model
 */
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $('#trigger-parameters-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>


<h1><?php echo CHtml::encode('Перечень параметров для триггера <'.$model -> trigger -> name.'>'); ?></h1>

<p class="pull-right">
    <?php echo CHtml::link('Добавить новый' , $this -> createUrl('admin/TriggerParameterCreate',['id' => $model -> trigger -> id]), array('class' => 'btn')); ?>
</p>


<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'triggers-grid',
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
        array('name' => 'verbiage', 'header' => $model->getAttributeLabel('verbiage')),
        array('name' => 'defaultValue', 'header' => $model->getAttributeLabel('defaultValue')),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update}&nbsp;{delete}',
            'deleteConfirmation'=>"js:'Вы действительно хотите удалить параметр <'+$(this).parent().parent().children(':nth-child(2)').text()+'>?'",
            'buttons'=>array
            (
                'update' => array
                (
                    'label'=> CHtml::encode('Редактировать'),
                    'url'=>function($data){
                        return $this -> createUrl('admin/TriggerParameterUpdate',['id' => $data -> id]);
                    }
                    //'url'=>'Yii::app()->createUrl("admin/triggerUpdate", array("id"=>$data->id))',
                ),
                'delete' => array
                (
                    'label'=> CHtml::encode('Удалить'),
                    'url'=>function($data){
                        return $this -> createUrl('admin/TriggerParameterDelete',['id' => $data -> id]);
                    },
                    //'url'=>'Yii::app()->createUrl("admin/triggerDelete", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>
