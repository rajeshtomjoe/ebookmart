<div class="row">
	<div class="span3">
		<?php echo TbHtml::stackedTabs(array(
		    array('label' => 'My Library', 'url' => '#', 'active' => true),
		    array('label' => 'My Orders', 'url' => $this->createUrl('user/orders')),
		    array('label' => 'My Cart', 'url' => $this->createUrl('user/cart'),),
		)); ?>
	</div>

	<div class="span9">
		<?php if(count($libraries) > 0):?>
			<div id="search-results">
				<ul class="media-list">
					<?php 

						$this->widget('bootstrap.widgets.TbListView', array(
						    'dataProvider'=>$libraries,
						    'itemView'=>'_book',
						    'template'=>'{summary}{items}{pager}'
						));

					?>
				</ul>
			</div>
		<?php else:?>
			<?php $this->widget('bootstrap.widgets.TbHeroUnit', array(
			    'heading' => 'No Books',
			    'content' => '<p>Please browse for books in the store</p>' . TbHtml::link('Go to Store',Yii::app()->homeurl, array('color' =>TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE)),
			)); ?>
		<?php endif;?>
	</div>
</div>
