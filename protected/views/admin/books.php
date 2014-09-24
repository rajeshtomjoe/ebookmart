<?php $this->widget('bootstrap.widgets.TbGridView', array(
   'dataProvider' => $books->search(),
   'type' => TbHtml::GRID_TYPE_BORDERED,
   'template' => "{items}{pager}",
   'columns' => array(
        array(
            'name' => 'book_id',
            'header' => '#',
            'htmlOptions' => array('color' =>'width: 60px'),
        ),
        array(
            'name' => 'book_title',
            'header' => 'Title',
        ),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{update}'
        )
    ),
)); ?>