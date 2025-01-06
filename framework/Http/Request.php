<?php

namespace Framework\Http;

class Request {
    public static function uri(): string {
        return $_SERVER['REQUEST_URI'];
    }
    public static function method(): string {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
    public static function get(): array {
        return $_GET;
    }
    public static function post(): array {
        return $_POST;
    }
}