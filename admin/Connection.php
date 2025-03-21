<?php

class Connection {
    protected static ?PDO $instance = null;
    private static ?string $dbName = null;

    private function __construct() {}

    // Singleton to SQLite (each sqlite file is a database)
    public static function getInstance(string $dbName):PDO {
        if (!isset(self::$instance) || self::$dbName !== $dbName) {
            try {
                self::$instance = new \PDO('sqlite:'.__DIR__."/../app/Database/$dbName.sqlite", null, null, [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]);
                self::$dbName = $dbName;
            } catch (\Throwable $e) {
                echo $e;
            }
        }
        return self::$instance;
    }
}
