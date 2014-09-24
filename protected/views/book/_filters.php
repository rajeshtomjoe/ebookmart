<div class="filters">
	<h4>Filter by</h4>
	<?php echo TbHtml::beginFormTb('',$this->createUrl('book/index'),'get'); ?>
	        <?php echo TbHtml::label('Title', 'filter[title]'); ?>
	        <?php echo TbHtml::textField('filter[title]', $title, array('placeholder' => 'Search by title')); ?>
			
			<?php echo TbHtml::label('Authors', 'filter[authors]'); ?>
	        <?php echo TbHtml::hiddenField('filter[authors]', $authors,array('class'=>'author-filter','data-url'=>$this->createUrl('book/getauthors'))); ?>
	        
	        <?php echo TbHtml::label('Categories', 'filter[categories]'); ?>
	        <?php echo TbHtml::hiddenField('filter[categories]', $categories,array('class'=>'category-filter','data-url'=>$this->createUrl('book/getcategories'))); ?>

	        <?php echo TbHtml::radioButton('filter[price]', (isset($price) && $price == 'paid')?true:false, array('label' => 'Paid','value'=>'paid')); ?>
	        <?php echo TbHtml::radioButton('filter[price]', (isset($price) && $price == 'free')?true:false, array('label' => 'Free','value'=>'free')); ?>

	        <?php echo TbHtml::submitButton('Apply',array('class'=>'btn-success')); ?>
	        <?php echo TbHtml::link('Reset',$this->createUrl('book/index'),array('class'=>'btn btn-primary')); ?>
	<?php echo TbHtml::endForm(); ?>
</div>