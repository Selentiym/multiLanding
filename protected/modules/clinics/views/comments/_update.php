<?php $text = 'Редактировать отзыв о '.(get_class($model) == 'clinics' ? 'клинике' : 'докторе') . ' <'.$model -> name.'>'; ?>
    <h1><?php echo CHtml::encode($text); ?></h1>
    <br/>
<?php echo $form; ?>
