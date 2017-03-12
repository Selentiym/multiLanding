<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.03.2017
 * Time: 23:40
 *
 * @type ArticleRule $model
 */
$c = new CDbCriteria();
$c -> compare('id_object_type', $model -> id_object_type);
$c -> order = 'num ASC';
$objects = $model -> findAll($c);
echo "<h2>Кодекс объектов ".Article::getTypeName($model -> id_object_type)."</h2>";
//foreach ($objects as $o) {
//
//}
?>
<p class="pull-right">
    <?php echo CHtml::link('Добавить правило' , $this -> createUrl('admin/RuleCreate',['type' => $model -> id_object_type]), array('class' => 'btn')); ?>
</p>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'clinics-grid',
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
        array('name' => 'verbiage', 'header' => 'Название'),
        array('name' => 'negative', 'header' => 'Отрицание'),
        array('name' => 'num', 'header' => 'Приоритет'),
        array('name' => 'active', 'header' => 'Активно'),
        array('name' => 'expression', 'header' => 'Выражение'),
        array('name' => 'id_object', 'header' => 'Статья', 'value' => function($data){
            return $data -> article -> name;
        }),

        array(
            'class'=>'CButtonColumn',
            'template'=>'{update}&nbsp;{delete}',
            'deleteConfirmation'=>"js:'Вы действительно хотите удалить правило <'+$(this).parent().parent().children(':nth-child(2)').text()+'>?'",
            'buttons'=>array
            (
                'update' => array
                (
                    'label'=> CHtml::encode('Редактировать'),
                    'url'=>function ($data) {
                        return $this -> createUrl("admin/RuleUpdate",['id' => $data -> id]);
                    },
                ),
                'delete' => array
                (
                    'label'=> CHtml::encode('Удалить'),
                    'url'=>function ($data) {
                        return $this -> createUrl("admin/RuleDelete",['id' => $data -> id]);
                    },
                ),
            ),
        ),
    ),
));