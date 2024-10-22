<?php

namespace Core;

class Config
{
    protected static $config = [];

    public static function set($config)
    {
        self::$config = $config;
    }

    public static function get($key = null)
    {
        if ($key === null) {
            return self::$config;
        }

        return self::$config[$key] ?? null;
    }
}
