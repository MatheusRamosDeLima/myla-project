<?php

namespace Framework\Http;

class Response {
    public static function json(array $data = [], int $status = 200): void {
        http_response_code($status);
        // header('Content-Type: application/json');
    }
}