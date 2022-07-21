<?php
require "./bootstrap.php";

use Src\Controller\ProductController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$requestMethod = $_SERVER["REQUEST_METHOD"];

$dbConnection->exec('CREATE TABLE IF NOT EXISTS products (
    id INT  PRIMARY KEY AUTO_INCREMENT,
    SKU VARCHAR(100) NOT NULL UNIQUE,
    Name VARCHAR(100) NOT NULL,
    Product_Type VARCHAR(100) NOT NULL,
    Price INT DEFAULT NULL,
    Size INT DEFAULT NULL,
    Weight INT DEFAULT NULL,
    Height INT DEFAULT NULL,
    Width INT DEFAULT NULL,
    Length INT DEFAULT NULL
);');
$controller = new ProductController($dbConnection, $requestMethod);
$controller->processRequest();
