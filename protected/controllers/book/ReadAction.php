<?php

class ReadAction extends CAction {

	public function run($book_id) {
		$controller = $this->getController();
		if(Yii::app()->user->id)
		{
			$controller->layout='//layouts/book';

			$book = Book::model()->findByPk($book_id);

			if($book === null)
			{
				throw new CHttpException(404,'The specified book cannot be found.');
			}

			$library = UserLibrary::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'book_id'=>$book->book_id));

			if($library === null)
			{
				$controller->redirect(Yii::app()->homeurl);
			}

			$controller->preview_book = $book;
		}else {
			$controller->redirect(array('site/login'));
		}
		

		$controller->render('preview',$controller->data);
	}

}

?>
