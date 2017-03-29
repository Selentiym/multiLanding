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
$comments = $commentsMod -> getComments($model -> id, new CDbCriteria());

Yii::app() -> getClientScript() -> registerScript('toggleComment',"
    var urlChangeable = '".$commentsMod -> createUrl('admin/toggleComment',['id' => 'idPlace'])."';
    $('body').on('click','.approvedToggle',function(){
        var saveClicked = $(this);
        var id = saveClicked.attr('data-id');
        saveClicked = saveClicked.find('a');
        $.post(urlChangeable.replace(/idPlace/, id), {},function(){},'JSON').done(function(data){
            if (data.success) {
                if (data.approved) {
                    saveClicked.html('Одобрен');
                } else {
                    saveClicked.html('Не одобрен');
                }
            } else {
                alert('mistake!');
            }
        });
    });
",CClientScript::POS_READY);

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
        array('name' => 'text', 'header' => 'Текст отзыва'),
        array('name' => 'approved', 'header' => 'Одобрен', 'value' => function($data){
            echo "<div class='change approvedToggle' data-id='$data->id'>";
            echo '<a href="#">';
            if ($data -> approved) {
                echo "Одобрен";
            } else {
                echo "Не одобрен";
            }
            echo "</a>";
            echo '</div>';
        }),
//        array('name' => 'approved', 'header' => 'Одобрен', 'value' => function($data){
//            return CHtml::ajaxLink($data -> approved, $data -> getModule() -> createUrl('admin/toggleComment',['id' => $data -> id]),[
//                'success' => 'js:function(data){
//                    alert("123");
//                }'
//            ]);
//        }),

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