<?php

class IndexAction extends CAction {

	public function run() {
		$controller = $this->getController();

		$books = new Book();

		$authors = '';
		$categories = '';
		$title = '';
		$price = null;

		if(isset($_GET['filter']))
		{
			if(isset($_GET['filter']['authors']))
			{
				$authors = $_GET['filter']['authors'];
				$authorsArr = explode(',', $authors);
				$authorsArr = array_filter($authorsArr);
				$books->bookAuthors = $authorsArr;
			}

			if(isset($_GET['filter']['categories']))
			{
				$categories = $_GET['filter']['categories'];
				$categoriesArr = explode(',', $categories);
				$categoriesArr = array_filter($categoriesArr);
				$books->bookCategories = $categoriesArr;
			}

			if(isset($_GET['filter']['title']))
			{
				$title = $_GET['filter']['title'];
				$books->book_title = $title;
			}

			if(isset($_GET['filter']['price']))
			{
				$price = $_GET['filter']['price'];
				$books->price = $_GET['filter']['price'];
			}
		}

		$controller->data['ebooks'] = $books->search();
		$controller->data['categories'] = $categories;
		$controller->data['authors'] = $authors;
		$controller->data['title'] = $title;
		$controller->data['price'] = $price;

		$controller->render('index',$controller->data);
	}

}

?>
