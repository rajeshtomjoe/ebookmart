<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>
 
<fieldset>
 
    <legend>Update</legend>
 
    
    <?php echo $form->textAreaControlGroup($book, 'book_title',array('required'=>true)); ?>
    <?php echo $form->textAreaControlGroup($book, 'book_description'); ?>
    <?php echo $form->textFieldControlGroup($book, 'book_copyright'); ?>
    <?php echo $form->textFieldControlGroup($book, 'book_language'); ?>
    <?php echo $form->textFieldControlGroup($book, 'book_isbn'); ?>
    <?php echo $form->textFieldControlGroup($book, 'book_price'); ?>
    <?php echo $form->checkBoxControlGroup($book, 'is_free'); ?>
 
    <?php echo TbHtml::formActions(array(
        TbHtml::submitButton('Save', array('color' => TbHtml::BUTTON_COLOR_PRIMARY))
    )); ?>
 
<?php $this->endWidget(); ?>