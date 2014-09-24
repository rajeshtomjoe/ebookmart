<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>
 
<fieldset>
 
    <legend>Register</legend>
 
    
    <?php echo $form->textFieldControlGroup($register, 'user_name',array('required'=>true)); ?>
    <?php echo $form->emailFieldControlGroup($register, 'user_email',array('required'=>true)); ?>
    <?php echo $form->passwordFieldControlGroup($register, 'user_password',array('required'=>true)); ?>

 
	<?php echo TbHtml::formActions(array(
	    TbHtml::submitButton('Submit', array('color' => TbHtml::BUTTON_COLOR_PRIMARY))
	)); ?>
 
<?php $this->endWidget(); ?>