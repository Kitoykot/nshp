<?php

namespace App;

class Connect
{
    private static $host = "127.0.0.1";
    private static $user = "root";
    private static $password = "";
    private static $name = "naruto-shop";

    public static function db()
    {
        $query = mysqli_connect(self::$host, self::$user, self::$password, self::$name);

        return $query;
    }
}