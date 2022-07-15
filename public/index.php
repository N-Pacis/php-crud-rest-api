<?php
require "../bootstrap.php";
use Src\Controller\ProductController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

if ($uri[1] !== 'product') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$productId = null;
if (isset($uri[2])) {
    $productId = (int) $uri[2];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

print("DB CONNECTION");
print($dbConnection);
print("DB");
$controller = new ProductController($dbConnection, $requestMethod, $productId);
$controller->processRequest();