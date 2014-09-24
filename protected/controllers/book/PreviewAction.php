<?php

class PreviewAction extends CAction {

	public function run($book_id) {
		$controller = $this->getController();
		$controller->layout='//layouts/preview';

		$book = Book::model()->findByPk($book_id);

		if($book === null)
		{
			throw new CHttpException(404,'The specified book cannot be found.');
		}

		$controller->preview_book = $book;

		$controller->render('preview',$controller->data);
	}

}

?>
