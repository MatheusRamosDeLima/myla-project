<?php

namespace App\Controllers;

use Framework\Mvc\Controller;
use Framework\Mvc\View;

use App\Models\ProductModel;
use App\Models\ImageModel;
use App\Models\CategoryModel;

class HomeController extends Controller {
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

		$mainCategories = ['bone', 'camiseta', 'camisa-polo', 'camiseta-regata', 'viseira', 'chapeu'];
		$randomProductsByCategories = [];
		foreach ($mainCategories as $categoryAddr) {
			$category = $this->Category->selectByField('addr', $categoryAddr)->fetchObject();
			$randomProducts = $this->Product->getRandomProductInCategory(4, $category->name)->fetchAll();
			$randomProductsByCategories[$category->name] = $randomProducts;
		}

    
        $view = new View('home', 'Ronaldo Ramos', 'home', 'home');
        $this->viewWithTemplate($view, [
        	'categories' => $categories,
        	'randomProducts' => $randomProductsByCategories,
        	'getCategoryByName' => function($name) {
        		$category = $this->Category->selectByField('name', $name)->fetchObject();
        		return $category;
        	},
        	'getImageByProduct' => function($product) {
        		$images = $this->Image->selectByField('product_id', $product->id)->fetchAll();
        		return $images[0];
        	}
        ]);
    }
}
