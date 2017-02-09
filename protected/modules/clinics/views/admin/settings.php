<div class="row-fluid">

    <div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'articles-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>
	
	<div>
		<?php echo $form->labelEx($model,'show_objects'); ?>
		<?php echo CHtml::activeRadioButtonList($model,'show_objects',array(1 => 'Показать', 0 => 'Не показать')); ?>
		<?php echo $form->error($model,'show_objects'); ?>
	</div>
	
	<div>
		<?php echo $form->labelEx($model,'main_text'); ?>
<?php
				 $this->widget('application.extensions.tinymce.TinyMce',
                    array(
                        'model'=>$model,
                        'attribute'=>'main_text',
                        //'editorTemplate'=>'full',
                        'skin'=>'cirkuit',
                        
                        //'useCompression'=>false,
                        'settings'=> array(
                            'mode' =>"textareas",
                            'theme' => 'advanced',
                            'skin' => 'cirkuit',
                            'theme_advanced_toolbar_location'=>'top',
                            'plugins' => 'advimage,spellchecker,safari,pagebreak,style,layer,save,advlink,advlist,iespell,inlinepopups,insertdatetime,contextmenu,directionality,noneditable,nonbreaking,xhtmlxtras,table,template,paste',
							'paste_remove_styles' => true,
							'paste_remove_spans' => true,
							'cleanup' => true,
							'valid_elements' => 'p,ul,li,table,tr,td,tbody,img[src]',
							'paste_word_valid_elements' => "p,ul,li,table,tr,td,tbody",
							'theme_advanced_buttons1' => "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,removeformat,|,tablecontrols",
							'theme_advanced_buttons2' => "cut,copy,paste,pastetext,|,bullist,numlist,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,forecolor,backcolor",
							//'theme_advanced_buttons2' => "paste,pastetext",
							'theme_advanced_buttons4' => "",
							'theme_advanced_buttons3' => "",
							//'theme_advanced_buttons3' => "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
                            'theme_advanced_toolbar_location' => 'top',
                            'theme_advanced_toolbar_align' => 'left',
                            'theme_advanced_statusbar_location' => 'bottom',
                            'theme_advanced_resizing_min_height' => 30,
                            'height' => 300,
                            
                        ),
                        
                        'fileManager' => array(
                                    'class' => 'application.extensions.elFinder.TinyMceElFinder',
                                    'popupConnectorRoute' => 'elfinder/elfinderTinyMce', // relative route for TinyMCE popup action
                                    'popupTitle' => "Files",
                             ), 
                        'htmlOptions'=>array('rows'=>5, 'cols'=>30, 'class'=>'tinymce'),
                    ));
?>


		<?php echo $form->error($model,'main_text'); ?>
	</div>

	<div>
		<?php echo $form->labelEx($model,'footer_text'); ?>
<?php
				 $this->widget('application.extensions.tinymce.TinyMce',
                    array(
                        'model'=>$model,
                        'attribute'=>'footer_text',
                        //'editorTemplate'=>'full',
                        'skin'=>'cirkuit',
                        
                        //'useCompression'=>false,
                        'settings'=> array(
                            'mode' =>"textareas",
                            'theme' => 'advanced',
                            'skin' => 'cirkuit',
                            'theme_advanced_toolbar_location'=>'top',
                            'plugins' => 'advimage,spellchecker,safari,pagebreak,style,layer,save,advlink,advlist,iespell,inlinepopups,insertdatetime,contextmenu,directionality,noneditable,nonbreaking,xhtmlxtras,table,template,paste',
							'paste_remove_styles' => true,
							'paste_remove_spans' => true,
							'cleanup' => true,
							'valid_elements' => 'p,ul,li,table,tr,td,tbody,img[src]',
							'paste_word_valid_elements' => "p,ul,li,table,tr,td,tbody",
							'theme_advanced_buttons1' => "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,removeformat,|,tablecontrols",
							'theme_advanced_buttons2' => "cut,copy,paste,pastetext,|,bullist,numlist,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,forecolor,backcolor",
							//'theme_advanced_buttons2' => "paste,pastetext",
							'theme_advanced_buttons4' => "",
							'theme_advanced_buttons3' => "",
							//'theme_advanced_buttons3' => "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
                            'theme_advanced_toolbar_location' => 'top',
                            'theme_advanced_toolbar_align' => 'left',
                            'theme_advanced_statusbar_location' => 'bottom',
                            'theme_advanced_resizing_min_height' => 30,
                            'height' => 300,
                            
                        ),
                        
                        'fileManager' => array(
                                    'class' => 'application.extensions.elFinder.TinyMceElFinder',
                                    'popupConnectorRoute' => 'elfinder/elfinderTinyMce', // relative route for TinyMCE popup action
                                    'popupTitle' => "Files",
                             ), 
                        'htmlOptions'=>array('rows'=>5, 'cols'=>30, 'class'=>'tinymce'),
                    ));
?>


		<?php echo $form->error($model,'footer_text'); ?>
	</div>
	
	<?php echo CHtml::submitButton('Сохранить'); ?>
	
	<?php $this->endWidget(); ?>
	</div>
</div>