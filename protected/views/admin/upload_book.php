<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'htmlOptions'=>array(
        'enctype' => 'multipart/form-data',
    )
)); ?>
 
<fieldset>
 
    <legend>Upload Epub</legend>
 
  
    <?php echo $form->fileFieldControlGroup($book, 'file'); ?>
    
 
</fieldset>
 
<?php echo TbHtml::formActions(array(
    TbHtml::submitButton('Submit', array('color' => TbHtml::BUTTON_COLOR_PRIMARY))
)); ?>
 
<?php $this->endWidget(); ?>