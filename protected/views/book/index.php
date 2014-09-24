<div class="row">
	<div class="span3">
		<?php $this->renderPartial('_filters',$this->data);?>
	</div>

	<div class="span9" id="search-results">
		<h3>Search Results</h3>
		<?php $this->renderPartial('_books',$this->data);?>
	</div>
</div>
