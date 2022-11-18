<?php


require __DIR__ . "/vendor/autoload.php";

use App\Core\Database;
use App\Controller\ProductController;

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');
    header('Access-Control-Max-Age: 1728000');
    header('Content-Length: 0');
    header('Content-Type: text/plain');
    die();
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$parts = explode("/", $_SERVER["REQUEST_URI"]);



if ($parts[1] != "products") {
    echo "not found 404 error";
    http_response_code(404);
    exit;
}

$id = $parts[2] ?? null;

// $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = "eu-cdbr-west-03.cleardb.net";
$cleardb_username = "b9786c552a00d9";
$cleardb_password = "c675098c";
// $cleardb_db = substr($cleardb_url["path"],1);
$cleardb_db = "heroku_d2fd36cf9777c31";


$database = new Database($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

$controller = new ProductController();


$check =  $controller->processRequest($_SERVER["REQUEST_METHOD"],  $database, $id);














