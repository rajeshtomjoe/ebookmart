<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />


	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); ?>
	<?php  
		$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
		$cs->registerScriptFile($baseUrl.'/js/select2.min.js', CClientScript::POS_END);
		$cs->registerScriptFile($baseUrl.'/js/script.js', CClientScript::POS_END);
		$cs->registerCssFile($baseUrl.'/css/select2.css');
		$cs->registerCssFile($baseUrl.'/css/select2-bootstrap.css');
		$cs->registerCssFile($baseUrl.'/css/main.css');
	?>
</head>

<body>

	<?php $this->widget('bootstrap.widgets.TbNavbar', array(
	    'color' => TbHtml::NAVBAR_COLOR_INVERSE,
	    'display'=> TbHtml::NAVBAR_DISPLAY_STATICTOP,
	    'brandLabel' => 'Bookmart',
		'items'=>  array(
	        array(
	            'class' => 'bootstrap.widgets.TbNav',
	            'items' => array(
	                array('label' => 'My Library', 'url' => $this->createUrl('user/library'),'visible'=>!Yii::app()->user->isGuest),
	                array(
	                	'label' => Yii::app()->user->name, 'url' => '#',
	                	'visible'=>!Yii::app()->user->isGuest,
	                	'items'=> array(
	                		array('label' => 'My Orders', 'url' => $this->createUrl('user/orders')),
	                		array('label' => 'My Cart', 'url' => $this->createUrl('user/cart')),
	                		TbHtml::menuDivider(),
	                		array('label' => 'logout', 'url' => $this->createUrl('site/logout')),
	                	)
	                ),
	                array('label' => 'Login', 'url' => $this->createUrl('site/login'),'visible'=>Yii::app()->user->isGuest),
	                array('label' => 'Register', 'url' => $this->createUrl('site/register'),'visible'=>Yii::app()->user->isGuest),
	            ),
	            'htmlOptions'=>array('class'=>'pull-right')
	        ),
	    )
	)); ?>
	<div class="container">
		<div class="content">
			<?php echo $content; ?>
		</div>
	</div>

</body>
</html>
