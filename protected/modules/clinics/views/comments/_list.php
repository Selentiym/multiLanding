<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13.03.2017
 * Time: 21:51
 * @type clinics|doctors $model
 * @type AdminController $this
 * @type ClinicsModule $mod
 */
$mod = $this -> getModule();
$commentsMod = $mod -> getObjectsReviewsPool(get_class($model));
$comments = $commentsMod -> getComments($model -> id);

$text = CHtml::encode('Отзывы о '.(get_class($model) == 'clinics' ? 'клинике' : 'докторе') . ' <'.$model -> name.'>');
echo "<h1>$text</h1>";
?>
<p class="pull-right">
    <?php echo CHtml::link('Добавить новый' , $this -> createUrl('admin/objectCommentCreate',['modelName' => get_class($model), 'id' => $model -> id]), array('class' => 'btn')); ?>
</p>
<br/>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'comments-grid',
    'dataProvider'=>new CArrayDataProvider($comments),
    'enablePagination' => false,
    'summaryText' => '',
    'template'=>'{items}',
    'columns'=>array(
        array('name' => 'text', 'header' => 'Текст отзыва'),
        array('name' => 'approved', 'header' => 'Одобрен'),

        array(
            'class'=>'CButtonColumn',
            'template'=>'{update}&nbsp;{delete}',
            'deleteConfirmation'=>"js:'Вы действительно хотите удалить отзыв <'+$(this).parent().parent().children(':nth-child(2)').text()+'>?'",
            'buttons'=>array
            (
                'update' => array
                (
                    'label'=> CHtml::encode('Редактировать'),
                    'url'=>function ($data) use ($model){
                        return $this -> createUrl("admin/objectCommentUpdate",['idComment' => $data -> id, 'id' => $model -> id,'modelName' => get_class($model)]);
                    },
                ),
                'delete' => array
                (
                    'label'=> CHtml::encode('Удалить'),
                    'url'=>function ($data) use ($model){
                        return $this -> createUrl("admin/objectCommentDelete",['idComment' => $data -> id, 'id' => $model -> id,'modelName' => get_class($model)]);
                    },
                ),
            ),
        ),
    ),
)); ?>