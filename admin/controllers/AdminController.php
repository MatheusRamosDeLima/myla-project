<?php

require_once __DIR__.'/../models/ProductModel.php';
require_once  __DIR__.'/../models/CategoryModel.php';

class AdminController {
	private string $viewPath;
	private ProductModel $Product;
	private CategoryModel $Category;

	public function __construct() {
		$this->viewPath = __DIR__.'/../views';
		$this->Product = new ProductModel;
		$this->Category = new CategoryModel;
	}

	public function index() {
		$products = $this->Product->findAll();
		$categories = $this->Category->findAll();

		$numberOfProductsByCategory = [];
		foreach ($categories as $category) {
			$productsByCategory = $this->Product->findByField('category', $category->name)->fetchAll();
			$numberOfProducts = count($productsByCategory);
			$numberOfProductsByCategory["{$category->name}"] = $numberOfProducts;
		}

		require_once "{$this->viewPath}/index.php";
	}

	public static function error(?string $errorMessage = null) {
		echo "<h1>Página de erro</h1>";
		if ($errorMessage) echo "<p>$errorMessage</p>";
	}
}
