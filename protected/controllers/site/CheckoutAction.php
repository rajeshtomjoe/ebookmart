<?php

class CheckoutAction extends CAction {

	public function run() {
		$controller = $this->getController();
		if(Yii::app()->user->id)
		{
			$cartArr = Yii::app()->user->getState('cart');
			if(isset($cartArr))
			{
				$order = new Order();
				$transaction = $order->dbConnection->beginTransaction();
				$order->user_id = Yii::app()->user->id;
				$order->order_total_price = Book::model()->totalPrice($cartArr);
				if($order->save())
				{
					$result = false;
					foreach ($cartArr as $key => $value) {
						$library = new UserLibrary();

						$library->user_id = Yii::app()->user->id;
						$library->order_id = $order->order_id;
						$library->book_id = $value;
						$result = $library->save();
					}

					if($result)
					{
						$transaction->commit();
						Yii::app()->user->setState('cart',null);
						$controller->redirect(array('user/orders'));
					}else {
						$transaction->rollback();
						$controller->redirect(array('user/cart'));
					}
				}else {
					$transaction->rollback();
					$controller->redirect(array('user/cart'));
				}

			}else {
				$controller->redirect(array('user/cart'));
			}
		}else {
			$controller->redirect(Yii::app()->homeurl);
		}
	}

}

?>
