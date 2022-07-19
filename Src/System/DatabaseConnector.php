<?php
namespace Src\System;

use PDO;
use PDOException;

class DatabaseConnector {

    private $dbConnection = null;

    public function __construct()
    {
        $url = getenv('DATABASE_URL');
        // $user = getenv('DB_USER');
        // $password = getenv('DB_PASSWORD');
        try {
            $this->dbConnection = new PDO($url);
            
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->dbConnection;
    }
}
