<?php

class AdminController extends Controller
{	
	public function actions()
	{
		return array(
			'uploadbook'=>array('class'=>'application.controllers.admin.UploadBookAction')
		);
	}

	public function actionBooks(){
		if(Yii::app()->user->id != 1)
		{
			$this->redirect(Yii::app()->homeurl);
		}
		$books = new Book();
		if(isset($_GET['Book']))
	        $books->attributes =$_GET['Book']; 

		$this->render('books',array('books'=>$books));
	}

	public function actionUpdate($id){
		if(Yii::app()->user->id != 1)
		{
			$this->redirect(Yii::app()->homeurl);
		}
		$book = Book::model()->findByPk($id);

		if($book === null)
		{
			throw new CHttpException(404,'The specified book cannot be found.');
		}

		if(isset($_POST['Book'])){
			$book->attributes = $_POST['Book'];

			if($book->validate())
			{
				if($book->save())
				{
					$this->refresh();
				}
			}
		}

		$this->render('book',array('book'=>$book));
	}
}