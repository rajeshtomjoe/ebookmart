<ul class="media-list">
	<?php if($ebooks->getItemCount() > 0):?>
		<?php 

			$this->widget('bootstrap.widgets.TbListView', array(
			    'dataProvider'=>$ebooks,
			    'itemView'=>'_book',
			    'template'=>'{summary}{items}{pager}'
			));

		?>
	<?php else:?>
		<?php $this->widget('bootstrap.widgets.TbHeroUnit', array(
			    'heading' => 'No Books Found',
			    'content' => '<p>Please modify your search Criteria for better results</p>' . TbHtml::link('Reset Search',Yii::app()->homeurl, array()),
			)); ?>
	<?php endif;?>
</ul>