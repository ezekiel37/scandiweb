<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    public function __construct(
        // private string $host,
        // private string $name,
        // private string $user,
        // private string $password
    ) {
    }

    public function getConnection(): PDO
    {
        try {
            $dsn = "mysql:host=eu-cdbr-west-03.cleardb.net; dbname=heroku_d2fd36cf9777c31;charset=utf8";
            return new PDO($dsn, "b9786c552a00d9", "c675098c", [

                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_STRINGIFY_FETCHES => false
            ]);
        } catch (PDOException $e) {
           die($e->getMessage());
        }

    }
}

