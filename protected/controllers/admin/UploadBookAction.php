<?php

class UploadBookAction extends CAction {

	public $categories_obj;
	public $authors_obj;
	public $book_trans;

	public function run() {


		$controller = $this->getController();

		if(Yii::app()->user->id != 1)
		{
			$controller->redirect(Yii::app()->homeurl);
		}

		$book = new Epub;

		if(isset($_POST['Epub']))
        {
            $book->attributes=$_POST['Epub'];

            $book->file = CUploadedFile::getInstance($book,'file');
            $file = "{$book->file}";
            $path = Yii::app()->basePath.'/../ebooks/epub/'.$file;

            if($book->validate())
            {
                if($book->file->saveAs($path))
                {
                	$epub = new EpubParser($path);
                	$this->saveToDb($epub,$file);
                }
            }
        }
		
		$controller->render('upload_book',array('book'=>$book));
	}

	public function saveToDb($epub,$file) {
		$title = $epub->Title();
		$authors = $epub->Authors();
		$description = $epub->Description();
		$categories = $epub->Subjects();
		$publisher_name = $epub->Publisher();
		$copyright = $epub->Copyright();
		$language = $epub->Language();
		$isbn = $epub->ISBN();

		$publisher = null;

		$result = true;

		$book = new Book();
		if(!empty($publisher_name))
		{
			$publisher = $this->getPublisherModel($publisher_name);
		}

		if(!empty($authors))
		{
			$this->createAuthorsObj($authors);
		}

		if(!empty($categories))
		{
			$this->createCategoriesObj($categories);
		}

		$this->book_trans = $book->dbConnection->beginTransaction();
		try
		{
			if(isset($publisher))
			{
				if(isset($publisher->publisher_id))
				{
					$book->publisher_id = $publisher->publisher_id;
				}else {
					$publisher->publisher_name = $publisher_name;
					$result = $result && $publisher->save();
					if($result) {
						$book->publisher_id = $publisher->publisher_id;
					}else {
						$this->rollback();
						return false;
					}
				}
			}
		    
		    $book->book_title = $title;
		    $book->book_description = $description;
		    $book->book_copyright = $copyright;
		    $book->book_language = $language;
		    $book->book_isbn = $isbn;
		    $book->book_epub_filename = $file;

		    if(isset($this->authors_obj) && !empty($this->authors_obj))
	    	{
	    		$author_ids = array();
	    		foreach ($this->authors_obj as $ka => $kv) {
	    			if(isset($kv->author_id))
	    			{
	    				array_push($author_ids, $kv->author_id);
	    			}else {
	    				$result = $result && $kv->save();
						if($result) {
							array_push($author_ids, $kv->author_id);
						}else {
							$this->rollback();
							return false;
						}
	    			}
	    		}

	    		if(!empty($author_ids))
	    		{
	    			$book->authors = Author::model()->findAllByPk($author_ids);
	    		}
	    	}

	    	if(isset($this->categories_obj) && !empty($this->categories_obj))
	    	{
	    		$category_ids = array();
	    		foreach ($this->categories_obj as $kc => $kvc) {
	    			if(isset($kvc->category_id))
	    			{
	    				array_push($category_ids, $kvc->category_id);
	    			}else {
	    				$result = $result && $kvc->save();
						if($result) {
							array_push($category_ids, $kvc->category_id);
						}else {
							$this->rollback();
							return false;
						}
	    			}
	    		}

	    		if(!empty($category_ids))
	    		{
	    			$book->categories = Category::model()->findAllByPk($category_ids);
	    		}
	    	}

	    	$result = $result && $book->save();

	    	if($result)
	    	{
	    		$img = $epub->Cover();
	    	
		    	if(isset($img['data']) && !empty($img['found']))
		    	{
		    		$path = Yii::app()->basePath.'/../images/epub/cover/';
		    		$cover_path = $path.$book->book_id.'_cover'.'.jpg';
			        //$decoded = base64_decode($img['data']);

			        file_put_contents($cover_path, $img['data'] );
			        $book->book_cover_image_url = $book->book_id.'_cover'.'.jpg';
			        $result = $result && $book->save();
		    	}
	    	}

		    if($result)
		    {
		    	$this->commit();
		    } else {
		    	$this->rollback();
		    }
		        
		}
		catch(Exception $e)
		{
		    $this->rollback();
		    throw $e;
		}

	}

	public function rollback() {
		$this->book_trans->rollback();
	}


	public function commit() {
		$this->book_trans->commit();
	}


	public function getPublisherModel($name){
		$model = Publisher::model()->findByAttributes(array('publisher_name'=>$name));

		if($model === null)
		{
			return new Publisher();
		}else {
			return $model;
		}
	}

	public function createAuthorsObj($authors) {
		foreach ($authors as $key => $name) {
			$this->authors_obj[$key] = $this->getAuthorModel($name);
			$this->authors_obj[$key]->author_name = $name;
		}
	}

	public function getAuthorModel($name){
		$model = Author::model()->findByAttributes(array('author_name'=>$name));

		if($model === null)
		{
			return new Author();
		} else {
			return $model;
		}
	}

	public function createCategoriesObj($categories) {
		foreach ($categories as $key => $name) {
			$this->categories_obj[$key] = $this->getCategoryModel($name);
			$this->categories_obj[$key]->category_name = $name;
		}
	}

	public function getCategoryModel($name){
		$model = Category::model()->findByAttributes(array('category_name'=>$name));

		if($model === null)
		{
			return new Category();
		}else {
			return $model;
		}
	}

}

?>
