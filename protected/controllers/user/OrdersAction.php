<?php

class OrdersAction extends CAction {

	public function run() {
		$controller = $this->getController();
		if(Yii::app()->user->id){
			$orders = new Order();
			$controller->data['userOrders'] = $orders->userOrders();
			
		}else {
			$controller->redirect(array('site/login'));
		}
		$controller->render('orders',$controller->data);
	}

}

?>
