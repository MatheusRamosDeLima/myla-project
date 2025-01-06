<?php

namespace App\Controllers;

use Framework\Mvc\Controller;
use Framework\Mvc\View;

use App\Models\ProductModel;
use App\Models\ImageModel;
use App\Models\CategoryModel;

class ShopController extends Controller {
	private ProductModel $Product;
	private ImageModel $Image;
	private CategoryModel $Category;

	public function __construct() {
		$this->Product = new ProductModel;
		$this->Image = new ImageModel;
		$this->Category = new CategoryModel;
	}

	public function index() {
		$categories = $this->Category->selectAll();

		$randomProductsByCategories = [];
		foreach ($categories as $category) {
			$randomProducts = $this->Product->getRandomProductInCategory(4, $category->name)->fetchAll();
			$randomProductsByCategories[$category->name] = $randomProducts;
		}
    
        $view = new View('Shop/index', 'Loja', 'Shop/index');
        $this->viewWithTemplate($view, [
        	'categories' => $categories,
        	'randomProducts' => $randomProductsByCategories,
        	'getCategoryByName' => function($name) {
        		return $this->Category->selectByField('name', $name)->fetchObject();
        	},
        	'getImageByProduct' => function($product) {
        		$images = $this->Image->selectByField('product_id', $product->id)->fetchAll();
        		return $images[0];
        	}
        ]);
	}

	public function category(string $categoryAddr) {
		$categories = $this->Category->selectAll();

		$categoryFound = $this->Category->selectByField('addr', $categoryAddr)->fetchObject();

		if (!$categoryFound) {
			$this->error404();
			return;
		}
		
		$productsByCategory = $this->Product->selectByField('category', $categoryFound->name)->fetchAll();
		
		$view = new View('/Shop/category', ucfirst($categoryFound->name), 'Shop/category');
		$this->viewWithTemplate($view, [
			'categories' => $categories,
			'category' => $categoryFound,
			'products' => $productsByCategory,
			'getImagesByProduct' => function($product) {
        		$images = $this->Image->selectByField('product_id', $product->id)->fetchAll();
        		return $images;
        	}
		]);
	}

	public function product(string $productId) {
		$categories = $this->Category->selectAll();
	
		$product = $this->Product->selectByField('id', $productId)->fetchObject();

		if (!$product) {
			$this->error404();
			return;
		}

		$images = $this->Image->selectByField('product_id', $productId)->fetchAll();

		$category = $this->Category->selectByField('name', $product->category)->fetchObject();

		$productsByCategory = $this->Product->selectByField('category', $category->name)->fetchAll();

		if (count($productsByCategory) > 1) {
			$randomProducts = $this->Product->getRandomProductInCategoryExcept(4, $category->name, $product->id);
		}
		else $randomProducts = [];
		
		$view = new View('/Shop/product', $product->title, 'Shop/product', 'Shop/product');
		$this->viewWithTemplate($view, [
			'categories' => $categories,
			'product' => $product,
			'images' => $images,
			'category' => $category,
			'productsByCategory' => $productsByCategory,
			'randomProducts' => $randomProducts,
			'getImagesByProduct' => function($product) {
        		$images = $this->Image->selectByField('product_id', $product->id)->fetchAll();
        		return $images;
        	}
		]);
	}
}
