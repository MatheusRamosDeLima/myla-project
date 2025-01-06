<?php

namespace App\Models;

use Framework\Mvc\Model;

class CategoryModel extends Model {
    public function __construct() {
        $this->init('database', 'categories', ['name']);
    }
}
