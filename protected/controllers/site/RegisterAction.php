<?php

class RegisterAction extends CAction {

	public function run() {
		$controller = $this->getController();

		if(Yii::app()->user->id)
		{
			$controller->redirect(Yii::app()->homeurl);
		}
		
		$register = new User();
		if(isset($_POST['User']))
	    {
	        // collects user input data
	        $register->attributes=$_POST['User'];
	        $password = $register->user_password;
	        // validates user input and redirect to previous page if validated
	        if($register->validate())
	        {
	        	if($register->save())
	        	{
	        		$login = new LoginForm();
	        		$login->username = $register->user_email;
	        		$login->password = $password;
	        		if($login->login())
	        		{
	        			$controller->redirect(Yii::app()->homeurl);
	        		}
	        	}
	        }
	            
	    }
		$controller->render('register',array('register'=>$register));
	}

}

?>
