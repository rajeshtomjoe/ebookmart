<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $this->preview_book->book_title;?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <meta name="apple-mobile-web-app-capable" content="yes">
  <?php Yii::app()->bootstrap->register(); ?>
		<?php  
			$baseUrl = Yii::app()->baseUrl; 
			$cs = Yii::app()->getClientScript();
      $cs->registerScriptFile($baseUrl.'/js/libs/zip.min.js');
			$cs->registerScriptFile($baseUrl.'/js/epub.min.js');
			$cs->registerCssFile($baseUrl.'/css/epub.css');
		?>

        <script>
            "use strict";
            
            var Book = ePub("<?php echo $baseUrl.'/ebooks/epub/'.$this->preview_book->book_epub_filename;?>");
            zip.workerScriptsPath = "<?php echo $baseUrl.'/js/libs/';?>";
        </script>
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
        <div id="main" style="margin: 10px;">
          <div id="prev" onclick="Book.prevPage();" class="arrow">‹</div>
          <div id="area"></div>
          <div id="next" onclick="Book.nextPage();"class="arrow">›</div>
          <div id="loader"><img src="../images/loader.gif"></div>
          <select id="toc"></select>
        </div>

        <script>            
            
            Book.getMetadata().then(function(meta){

                document.title = meta.bookTitle+" – "+meta.creator;
                
            });

            Book.getToc().then(function(toc){

              var $select = document.getElementById("toc"),
                  docfrag = document.createDocumentFragment();

              toc.forEach(function(chapter) {
                var option = document.createElement("option");
                option.textContent = chapter.label;
                option.ref = chapter.href;

                docfrag.appendChild(option);
              });

              $select.appendChild(docfrag);

              $select.onchange = function(){
                  var index = $select.selectedIndex,
                      url = $select.options[index].ref;
                  
                  Book.goto(url);
                  return false;
              }

            });
            
            Book.ready.all.then(function(){
              document.getElementById("loader").style.display = "none";
            });

            Book.renderTo("area");

        </script>
    </body>
</html>
