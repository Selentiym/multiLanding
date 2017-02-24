<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#articles-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo CHtml::encode('Перечень статей'); ?></h1>

<p class="pull-right">
    <?php echo CHtml::link('Добавить новую' , $this -> createUrl('admin/ArticleCreate'), array('class' => 'btn')); ?>
</p>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'articles-grid',
	'dataProvider'=>$model->search(),
    'enablePagination' => true,
    'summaryText' => '',
	'filter'=>$model,
	'columns'=>array(
        array('name' => 'id', 'header' => $model->getAttributeLabel('id')),
        array('name' => 'name', 'header' => $model->getAttributeLabel('name')),
        array('name' => 'verbiage', 'header' => $model->getAttributeLabel('verbiage')),
        array('name' => 'parent_id', 'header' => $model->getAttributeLabel('parent_id'), 'value' => '($data->parent_id == 0)? CHtml::encode("0 (Корневая статья)"): Article::model() -> findByPk($data->parent_id) -> name'),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update}&nbsp;{delete}',
            'deleteConfirmation'=>"js:'Вы действительно хотите удалить статью <'+$(this).parent().parent().children(':nth-child(2)').text()+'>?'",
            'buttons'=>array
            (
                'update' => array
                (
                    'label'=> CHtml::encode('Редактировать'),
                    'url'=>function($data){return $this->createUrl("admin/ArticleUpdate", array("id"=>$data->id));},
                ),
                'delete' => array
                (
                    'label'=> CHtml::encode('Удалить'),
                    'url'=>function($data){return $this->createUrl("admin/ArticleDelete", array("id"=>$data->id));},
                ),
            ),

        ),
	),
));

$this->widget('application.extensions.tree.Tree',
    array(
        'url' => $this -> createUrl('admin/GiveArticleChildren'),
        'config' => [
            'generateButtons' => 'js:function(branch){
                if (!branch) {return;}
                if (!branch.parent.parent) {return;}
                branch.edit = $("<a>",{
                    class: "edit button",
                    title: "Редактирвать текст",
                    href:"'.$this -> createUrl('admin/ArticleUpdate').'/?id="+branch.id
                });
                branch.buttonContainer.append(branch.edit);

                branch.addChildButton = $("<span>",{
                    title:"Добавить потомка",
                    class:"plus button"
                });
                branch.addChildButton.click(function(){
                    $.post("'.$this -> createUrl("admin/createArticleFast").'/?id=" + branch.id,
                        {name:"Новая статья"}, null,"json"
                    ).done(function(data){
                        if (data.success) {
                            branch.createChild(data.dump);
                        } else {
                            alert("Ошибка при создании!");
                        }
                    });
                });
                branch.buttonContainer.append(branch.addChildButton);
            }'
        ]
    ));


?>
