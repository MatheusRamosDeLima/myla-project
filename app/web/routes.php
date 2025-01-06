<?php

use Framework\Http\Route;

use App\Controllers\HomeController;
Route::get('/', [HomeController::class, 'index']);
/*Route::post('/send_email', [HomeController::class, 'sendEmail']);*/

use App\Controllers\ShopController;
Route::get('/loja', [ShopController::class, 'index']);
Route::get('/categoria/{id}', [ShopController::class, 'category']);
Route::get('/produto/{id}', [ShopController::class, 'product']);
