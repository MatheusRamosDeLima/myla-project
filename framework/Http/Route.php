<?php

namespace Framework\Http;

class Route {
    private static array $routes;

    public static function get(string $path, array $action): void {
        self::$routes[] = [
            'path' => $path,
            'action' => $action,
            'method' => 'get'
        ];
    }
    public static function post(string $path, array $action): void {
        self::$routes[] = [
            'path' => $path,
            'action' => $action,
            'method' => 'post'
        ];
    }
    public static function put(string $path, array $action): void {
        self::$routes[] = [
            'path' => $path,
            'action' => $action,
            'method' => 'put'
        ];
    }
    public static function delete(string $path, array $action): void {
        self::$routes[] = [
            'path' => $path,
            'action' => $action,
            'method' => 'delete'
        ];
    }
    public static function match(array $methods, string $path, array $action): void {
        for ($i = 0; $i < count($methods); $i++) {
            $methods[$i] = strtolower($methods[$i]);
        }

        self::$routes[] = [
            'path' => $path,
            'action' => $action,
            'method' => $methods
        ];
    }

    public static function getRoutes(): array {
        return self::$routes;
    }
}