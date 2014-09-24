<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>
 
<fieldset>
 
    <legend>Login</legend>
 
    
    <?php echo $form->emailFieldControlGroup($model, 'username',array('required'=>true)); ?>
    <?php echo $form->passwordFieldControlGroup($model, 'password',array('required'=>true)); ?>

 
	<?php echo TbHtml::formActions(array(
	    TbHtml::submitButton('Login', array('color' => TbHtml::BUTTON_COLOR_PRIMARY))
	)); ?>
 
<?php $this->endWidget(); ?>