<?php

namespace Core;

use PDO;
use PDOException;

class Database
{
    protected static $connection;

    public static function connect()
    {
        if (!self::$connection) {
            $config = Config::get('database');

            if (!$config) {
                throw new \Exception("Database configuration not found.");
            }

            $dsn = "{$config['driver']}:host={$config['host']};port={$config['port']};dbname={$config['database']};charset={$config['charset']}";

            try {
                self::$connection = new PDO($dsn, $config['username'], $config['password']);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                throw new \Exception("Database connection error: " . $e->getMessage());
            }
        }

        return self::$connection;
    }

    public static function getConnection()
    {
        return self::connect();
    }
}
