<?php

require_once 'AdminController.php';

require_once  __DIR__.'/../models/CategoryModel.php';

require_once __DIR__.'/../helpers/NormalizeString.php';

class CategoryController {
	private CategoryModel $Category;
	private ProductModel $Product;

	public function __construct() {
		$this->Category = new CategoryModel;
		$this->Product = new ProductModel;
	}

	public function store() {
		if (!$_POST['category_name']) {
			AdminController::error();
			return;
		}

		$name = $_POST['category_name'];
		$name = strtolower($name);

		$addr = NormalizeString::get($name);

		try {
			$this->Category->store($name, $addr);
		} catch (\Throwable $e) {
			echo $e;
		}

		header('Location: /');
	}

	public function destroy($id) {
		$category = $this->Category->findByField('id', $id);
	
		if (!$category || $this->Product->findByField('category', $category->name)->fetchAll()) {
			AdminController::error('Categoria não existe ou ainda há produtos relacionados a essa categoria.');
			return;
		}

		$this->Category->destroy('id', $id);

		header('Location: /');
	}
}
