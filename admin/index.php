<?php

class Core {
	private static string $controller;
	private static string $method;
	private static array $params;

	public static function start(array $routes): void {
		$uri = self::getUri();
		$dispatch = self::dispatch($uri, $routes);
		if (!$dispatch) self::invalidRoute();
		call_user_func_array([new self::$controller, self::$method], self::$params);
	}

	private static function getUri(): string {
		$uri = trim($_SERVER['REQUEST_URI'], '/');
		return $uri;
	}

	private static function dispatch(string $url, array $routes): bool {
		$isMethodAllowed = false;
		$isRouteFound = false;
	
        foreach ($routes as $route) {
            $pattern = '#^'.preg_replace('/{id}/', '([\w-]+)', trim($route['path'], '/')).'$#';
            if (preg_match($pattern, $url, $matches)) {
                $isRouteFound = true;

                array_shift($matches);

                $isMethodAllowed = self::isMethodAllowed($route);

                if ($isMethodAllowed) {
                    list(self::$controller, self::$method) = $route['action'];
                    self::$params = $matches;

                    return true;
                }
            }
        }
	
        if (!$isMethodAllowed) self::invalidRoute();

        if ($isRouteFound) return true;

        return false;
	}

	private static function isMethodAllowed(array $route): bool {
	    $isMethodAllowed = false;

	    $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);

	    if (is_string($route['method']) && $route['method'] === $requestMethod) $isMethodAllowed = true;

	    return $isMethodAllowed;
	}

	private static function invalidRoute(): void {
	    self::$controller = AdminController::class;
	    self::$method = 'error';
	    self::$params = [];
	}
}

class Route {
	public static array $routes = [];

	public static function add(string $method, string $uri, array $action): void {
		self::$routes[] = [
			'method' => strtolower($method),
			'path' => $uri,
			'action' => $action
		];
	}
	public static function get(): array {
		return self::$routes;
	}
}

require_once __DIR__.'/controllers/AdminController.php';
require_once __DIR__.'/controllers/ProductController.php';
require_once __DIR__.'/controllers/CategoryController.php';

# AdminController
Route::add('get', '/', [AdminController::class, 'index']);
# ProductController
Route::add('get', '/product/{id}', [ProductController::class, 'index']);
Route::add('get', '/product_create', [ProductController::class, 'create']);
Route::add('post', '/product_store', [ProductController::class, 'store']);
Route::add('get', '/product_edit/{id}', [ProductController::class, 'edit']);
Route::add('post', '/product_update/{id}', [ProductController::class, 'update']);
Route::add('post', '/product_destroy/{id}', [ProductController::class, 'destroy']);
# CategoryController
Route::add('post', '/category_store', [CategoryController::class, 'store']);
Route::add('post', '/category_destroy/{id}', [CategoryController::class, 'destroy']);

Core::start(Route::get());
