<li class="media">
    <a class="pull-left" href="#book<?php echo $data->book_id?>" data-toggle="modal">
      <?php if(isset($data->book->book_cover_image_url) && !empty($data->book->book_cover_image_url)):?>
        <img class="media-object" src="<?php echo Yii::app()->baseurl.'/images/epub/cover/'.$data->book->book_cover_image_url;?>">
      <?php else:?>
        <img class="media-object" src="<?php echo Yii::app()->baseurl.'/images/cover_empty.jpg';?>">
    <?php endif;?>
      
    </a>
    <div class="media-body">
      <h4 class="media-heading">
      	<a href="#book<?php echo $data->book->book_id?>" data-toggle="modal">
      		<?php echo $data->book->book_title?>
      	</a>
      </h4>
      <p>
      	<?php foreach ($data->book->authors as $key => $value):?>
  		   <?php echo $value->author_name; ?>
  	    <?php endforeach;?>
      </p>
      
      <div class="book-actions">
        <?php if($data->book->is_free):?>
          <div class="search-price-tag">FREE</div>
        <?php else:?>
          <div class="search-price-tag">Rs. <?php echo $data->book->book_price;?></div>
        <?php endif;?>
          <a href="<?php echo $this->createUrl('book/read',array('book_id'=>$data->book->book_id));?>" class="btn btn-default">Read Book</a>
      </div>
    </div>
</li>

<div id="book<?php echo $data->book_id?>" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><?php echo $data->book->book_title?></h3>
  </div>
  <div class="modal-body">
    <div class="media">
      <a class="pull-left" href="#">
        <?php if(isset($data->book->book_cover_image_url) && !empty($data->book->book_cover_image_url)):?>
        <img class="media-object" src="<?php echo Yii::app()->baseurl.'/images/epub/cover/'.$data->book->book_cover_image_url;?>">
      <?php else:?>
        <img class="media-object" src="<?php echo Yii::app()->baseurl.'/images/cover_empty.jpg';?>">
    <?php endif;?>
      </a>
      <div class="media-body">
        <h4 class="media-heading">
           by 
    
          <?php foreach ($data->book->authors as $ka => $va):?>
           <?php 
            $authors = array();
            array_push($authors, $va->author_name);
            echo implode(', ', $authors);
          ?>
          <?php endforeach;?>
        </h4>
        <?php if(count($data->book->categories) > 0):?>
        <strong>Subjects</strong>
        <p>
          <?php foreach ($data->book->categories as $kc => $vc):?>
           <?php echo $vc->category_name; ?><br>
          <?php endforeach;?>
        </p>
        <?php endif;?>
        
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <?php if($data->book->is_free):?>
        <div class="search-price-tag">FREE</div>
      <?php else:?>
        <div class="search-price-tag">Rs. <?php echo $data->book->book_price;?></div>
      <?php endif;?>
    <a href="<?php echo $this->createUrl('book/read',array('book_id'=>$data->book->book_id));?>" class="btn btn-default">Read Book</a>
  </div>
</div>