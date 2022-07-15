<?php
require 'bootstrap.php';

$statement = <<<EOS
    CREATE TABLE IF NOT EXISTS products (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        SKU VARCHAR(100) NOT NULL UNIQUE,
        Name VARCHAR(100) NOT NULL,
        Price INT DEFAULT NOT NULL,
        Size INT DEFAULT NULL,
        Weight INT DEFAULT NULL,
        Height INT DEFAULT NULL,
        Width INT DEFAULT NULL,
        Length INT DEFAULT NULL,
        PRIMARY KEY (id)
    )
EOS;

try {
    $createTable = $dbConnection->exec($statement);
    echo "Success!\n";
} catch (\PDOException $e) {
    exit($e->getMessage());
}