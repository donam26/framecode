<?php

use Core\Config;
use Core\Database;

require __DIR__ . '/../vendor/autoload.php';
require './bootstrap/bootstrap.php';
require 'Container.php';

$config = [];
foreach (glob(__DIR__ . '/../config/*.php') as $file) {
    $config = array_merge($config, require $file);
}

Config::set($config);

try {
    Database::connect(); 
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Nạp các tệp route
require_once '../routes/index.php';