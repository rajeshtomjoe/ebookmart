<div class="row">
	<div class="span3">
		<?php echo TbHtml::stackedTabs(array(
		    array('label' => 'My Library', 'url' => $this->createUrl('user/library')),
		    array('label' => 'My Orders', 'url' => $this->createUrl('user/orders'),),
		    array('label' => 'My Cart', 'url' => '#', 'active' => true),
		)); ?>
	</div>

	<div class="span9">
		<?php if(isset($cartBooks) && $cartBooks->getItemCount() > 0):?>
			<div id="search-results">
				<ul class="media-list">
					<?php 

						$this->widget('bootstrap.widgets.TbListView', array(
						    'dataProvider'=>$cartBooks,
						    'itemView'=>'_cart_book',
						    'template'=>'{summary}{items}{pager}'
						));

					?>
				</ul>
				<h1 class="pull-left">Total: <?php echo $total_price?></h1>
				<?php echo TbHtml::link('Checkout',$this->createUrl('site/checkout'), array('class'=>'btn btn-success btn-large pull-right'));?>
			</div>
		<?php else:?>
			<?php $this->widget('bootstrap.widgets.TbHeroUnit', array(
			    'heading' => 'No Books Added',
			    'content' => '<p>Please browse for books in the store</p>' . TbHtml::link('Go to Store',Yii::app()->homeurl, array()),
			)); ?>
		<?php endif;?>
	</div>
</div>