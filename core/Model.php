<?php 

namespace Core;

use Core\Database;
use PDO;

abstract class Model {
    protected static $table;
    protected $connection;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }

    public static function get()
    {
        $instance = new static();
        $query = "SELECT * FROM " . static::$table;
        $stmt = $instance->connection->query($query);
        return $stmt->fetchAll(PDO::FETCH_CLASS, get_called_class());
    }
}
