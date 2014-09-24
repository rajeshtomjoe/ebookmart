<?php

class CartAction extends CAction {

	public function run() {
		$controller = $this->getController();
		$controller->data['cartBooks'] = null;
		if(Yii::app()->user->id)
		{
			$cartArr = Yii::app()->user->getState('cart');

			
			if(isset($cartArr))
			{
				$cartBooks = Book::model()->cartBooks($cartArr);
				
				$controller->data['cartBooks'] = $cartBooks;
				$controller->data['total_price'] = Book::model()->totalPrice($cartArr);
			}

		}else {
			$controller->redirect(array('site/login'));
		}
		$controller->render('cart',$controller->data);
	}

}

?>
