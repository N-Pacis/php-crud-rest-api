<?php

namespace Src\ServiceImpls;

use Src\Models\Product;
use Src\Services\ProductService;

class ProductServiceImpl implements ProductService
{

    private $db = null;

    public function __construct($dbconnection)
    {
        $this->db = $dbconnection;
    }

    public function findAll()
    {
        $statement = " SELECT * FROM products;";

        try {
            $statement = $this->db->query($statement);
            $statement->setFetchMode(\PDO::FETCH_CLASS,"Src\Models\Product");
            return $statement->fetchAll();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find(int $id)
    {
        $statement = "SELECT * FROM products WHERE id = ?;";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
            $statement->setFetchMode(\PDO::FETCH_CLASS,"Src\Models\Product");
            return $statement->fetch();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findBySku(String $sku)
    {
        $statement = "SELECT * FROM products WHERE SKU = :SKU;";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('SKU' => $sku));
            $statement->setFetchMode(\PDO::FETCH_CLASS,"Src\Models\Product");
            return $statement->fetch();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(Product $product)
    {
        $data = [
            'SKU' => $product->getSKU(),
            'Name' => $product->getName(),
            'Price' => $product->getPrice(),
            'Product_Type' => $product->getProductType(),
            'Height' => $product->getHeight(),
            'Width' => $product->getWidth(),
            'Length' => $product->getLength(),
            'Weight' => $product->getWeight(),
            'Size' => $product->getSize()
        ];

        $columns = implode(",",array_keys($data));
        $bind_params = implode(', ', array_map(function($value) { return ':' . $value; }, array_keys($data)));

        $query = " INSERT INTO products ($columns) VALUES ($bind_params);";

        try {

            $statement = $this->db->prepare($query);
            if($statement->execute($data)) {
                return true;
            }
            return false;
            
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete(int $id)
    {
        $statement = "DELETE FROM products WHERE id = :id;";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('id' => $id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
