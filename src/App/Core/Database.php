<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    public function __construct(
        private string $host,
        private string $name,
        private string $user,
        private string $password
    ) {
    }

    public function getConnection(): PDO
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->name};charset=utf8";
            return new PDO($dsn, $this->user, $this->password, [

                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_STRINGIFY_FETCHES => false
            ]);
        } catch (PDOException $e) {
           echo die($e->getMessage());
        }

        //         echo $this->host;
        // echo $this->password;
    }
}

// namespace App\core;
// use PDO;
// use PDOException;

// class Database
// {
//     public static $con;
//     private $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);

//     public function __construct()
//     {
//         try{
//             $string = "mysql:host=Localhost; dbname=scandiweb";
//             self::$con = new PDO($string, "scandiweb", "scandiweb001", $this->options);
//         }
//         catch (PDOException $e){
//             die($e->getMessage());
//         }
//     }

//     public static function getInstance()
//     {
//         if(self::$con){
//             return self::$con;
//         }

//         self::$con = new self();
//         return self::$con;
//     }
// }
