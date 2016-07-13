<?php

namespace WebDevBr;

class Config
{
    private static $data;

    public static function set(array $data)
    {
        self::$data = $data;
    }

    public static function get($item = null)
    {
        if ($item !== null and isset(self::$data[$item])) {
            return self::$data[$item];
        } else if ($item === null) {
            return self::$data;
        }

        return null;
    }
}