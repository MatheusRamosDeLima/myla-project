<?php

namespace App\Models;

use Framework\Mvc\Model;

class ProductModel extends Model {
    public function __construct() {
        $this->init('database', 'products', ['title', 'sku', 'category', 'description']);
    }

    public function getRandomProductInCategory(int $i, string $category) {
    	$query = self::$connection->prepare("SELECT * FROM {$this->table} WHERE category=? ORDER BY RANDOM() LIMIT $i");
    	$query->execute([$category]);
    	return $query;
    }

    public function getRandomProductInCategoryExcept(int $i, string $category, int $id) {
    	$query = self::$connection->prepare("SELECT * FROM {$this->table} WHERE category=? AND id!=? ORDER BY RANDOM() LIMIT $i");
    	$query->execute([$category, $id]);
    	return $query;    	
    }
}
