<?php

class LibraryAction extends CAction {

	public function run() {
		$controller = $this->getController();
		if(Yii::app()->user->id)
		{
			$libraries = UserLibrary::model()->userBooks();
			$controller->data['libraries'] = $libraries;
		}else {
			$controller->redirect(array('site/login'));
		}
		
		$controller->render('library',$controller->data);
	}

}

?>
