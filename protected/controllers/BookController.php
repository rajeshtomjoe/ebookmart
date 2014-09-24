<?php

class BookController extends Controller
{	
	public function actions()
	{
		return array(
			'index'=>array('class'=>'application.controllers.book.IndexAction'),
			'preview'=>array('class'=>'application.controllers.book.PreviewAction'),
			'read'=>array('class'=>'application.controllers.book.ReadAction')
		);
	}

	public function actionGetauthors() {
		if(isset($_GET['ids']))
		{
			$author_ids = explode(',', $_GET['ids']);
			$authors = Author::model()->findAllByPk($author_ids);
		}else {
			$criteria = new CDbCriteria();
            $criteria->compare('author_name', $_GET['q'], true);
			$authors = Author::model()->findAll($criteria);
		}
		
		$authorsArr = array();
		foreach ($authors as $key => $value) {
			$temp = array();
			$temp['id'] = $value->author_id;
			$temp['text'] = $value->author_name;
			array_push($authorsArr, $temp);
		}

		echo json_encode($authorsArr);
	}

	public function actionGetcategories() {
		if(isset($_GET['ids']))
		{
			$category_ids = explode(',', $_GET['ids']);
			$categories = Category::model()->findAllByPk($category_ids);
		}else {
			$criteria = new CDbCriteria();
            $criteria->compare('category_name', $_GET['q'], true);
			$categories = Category::model()->findAll($criteria);
		}
		
		$categoriesArr = array();
		foreach ($categories as $key => $value) {
			$temp = array();
			$temp['id'] = $value->category_id;
			$temp['text'] = $value->category_name;
			array_push($categoriesArr, $temp);
		}

		echo json_encode($categoriesArr);
	}

	// public function actionTest() {
	// 	$filename = Yii::app()->basePath.'/ebooks/epub/A Study in Scarlet by Arthur Conan Doyle.epub';
	// 	header('Content-type: application/epub+zip');
	// 	header('Content-disposition:attachment;filename="A Study in Scarlet by Arthur Conan Doyle.epub"');
	// 	header('Content-Transfer-Encoding: binary');
	// 	readfile($filename);
	// }
}