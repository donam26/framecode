<?php
namespace Core;

class Request {
    public static function uri() 
    {
        return trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function input($key, $defualt = null) 
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $_POST[$key] ?? $defualt;
        }

        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            return $_GET[$key] ?? $defualt;
        }

        return $defualt;
    } 

    public static function all()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $_POST;
        }

        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            return $_GET;
        }

        return [];
    }
}