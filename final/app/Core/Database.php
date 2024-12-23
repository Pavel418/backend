<?php

namespace App\Core;

use PDO;
use PDOException;
use App\Config\Config;

class Database {
    private static $connection;

    public static function connect() {
        if (!self::$connection) {
            try {
                $dsn = sprintf(
                    "mysql:host=%s;dbname=%s;charset=utf8",
                    Config::get('DB_HOST'),
                    Config::get('DB_NAME')
                );
                
                self::$connection = new PDO(
                    $dsn,
                    Config::get('DB_USER'),
                    Config::get('DB_PASS')
                );

                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage() . "<br>" . $dsn);
            }
        }

        return self::$connection;
    }
}
