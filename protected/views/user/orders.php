<div class="row">
	<div class="span3">
		<?php echo TbHtml::stackedTabs(array(
		    array('label' => 'My Library', 'url' => $this->createUrl('user/library')),
		    array('label' => 'My Orders', 'url' => '#', 'active' => true),
		    array('label' => 'My Cart', 'url' => $this->createUrl('user/cart'),),
		)); ?>
	</div>

	<div class="span9">
		<?php if(isset($userOrders) && $userOrders->getItemCount() > 0):?>
			<?php $this->widget('bootstrap.widgets.TbGridView', array(
			   'dataProvider' => $userOrders,
			   'type' => TbHtml::GRID_TYPE_BORDERED,
			   'template' => "{summary}{items}{pager}",
			   'columns' => array(
			        array(
			            'name' => 'order_id',
			            'header' => '#',
			            'htmlOptions' => array('color' =>'width: 60px'),
			        ),
			        array(
			            'name' => 'order_total_price',
			            'header' => 'Total Amount',
			        ),
			        array(
			            'name' => 'order_created_date',
			            'header' => 'Order Date/Time',
			        )
			    ),
			)); ?>

		<?php else:?>
			<?php $this->widget('bootstrap.widgets.TbHeroUnit', array(
			    'heading' => 'No Orders',
			    'content' => '<p>Please browse for books in the store</p>' . TbHtml::link('Go to Store',Yii::app()->homeurl, array()),
			)); ?>
		<?php endif;?>
	</div>
</div>