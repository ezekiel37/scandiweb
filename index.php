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

$database = new Database();

$controller = new ProductController();

$check =  $controller->processRequest($_SERVER["REQUEST_METHOD"], $database, $id);
