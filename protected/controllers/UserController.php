<?php

class UserController extends Controller
{	
	public function actions()
	{
		return array(
			'library'=>array('class'=>'application.controllers.user.LibraryAction'),
			'orders'=>array('class'=>'application.controllers.user.OrdersAction'),
			'cart'=>array('class'=>'application.controllers.user.CartAction'),
		);
	}


	public function actionAddtocart($book_id){
		if(Yii::app()->user->id)
		{
			$book = Book::model()->findByPk($book_id);
			if($book !== null)
			{
				if($book->is_free)
				{
					$library = new UserLibrary();
					$library->user_id = Yii::app()->user->id;
					$library->book_id = $book->book_id;
					if($library->save())
					{
						$this->redirect(array('user/library'));
					}else {
						print_r($library->getErrors());
					}
				}else {
					$this->manageCart($book_id);
					$this->redirect(array('user/cart'));
				}
				
			}else {
				$this->redirect(Yii::app()->homeurl);
			}
		}else {
			$this->redirect(array('site/login'));
		}
	}

	public function manageCart($book_id){
		$cartArr = Yii::app()->user->getState('cart');

		if(!isset($cartArr))
		{
			$cartArr = array();
		}
		
		array_push($cartArr, $book_id);
		$cartArr = array_unique($cartArr);
		
		Yii::app()->user->setState('cart',$cartArr);
	}

	public function actionRemovefromcart($book_id){
		$cartArr = Yii::app()->user->getState('cart');

		if(!isset($cartArr))
		{
			$cartArr = array();
		}
		
		$key = array_search($book_id, $cartArr);
		if (false !== $key) {
		    unset($cartArr[$key]);
		}
		
		Yii::app()->user->setState('cart',$cartArr);

		$this->redirect(array('user/cart'));
	}
}