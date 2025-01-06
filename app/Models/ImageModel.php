<?php

namespace App\Models;

use Framework\Mvc\Model;

class ImageModel extends Model {
    public function __construct() {
        $this->init('database', 'images', ['addr', 'product_id']);
    }
}
