<?php

require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../app/web/routes.php";

use Framework\Core;
use Framework\Http\Route;

Core::start(Route::getRoutes());