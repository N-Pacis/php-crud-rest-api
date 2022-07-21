<?php

namespace Src\Services;

class ProductService
{

    private $db = null;

    public function __construct($dbconnection)
    {
        $this->db = $dbconnection;
    }

    public function findAll()
    {
        $statement = "
            SELECT 
                id, SKU, Name, Price,Product_Type,Height,Width,Length,Weight,Size
            FROM
                products;
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($id)
    {
        $statement = "
        SELECT 
        id, SKU, Name, Price,Product_Type,Height,Width,Length,Weight,Size
    FROM
        products
            WHERE id = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(array $input)
    {
        $query = "
            INSERT INTO products
                (SKU, Name, Price,Product_Type,Height,Width,Length,Weight,Size)
            VALUES
                (:SKU, :Name, :Price,:Product_Type,:Height,:Width,:Length,:Weight,:Size);
        ";

        try {
            $price = (int) $input['price'];
            $height = (int) $input['height'];
            $width = (int) $input['width'];
            $length = (int) $input['length'];
            $weight = (int) $input['weight'];
            $size = (int) $input['size'];

            $statement = $this->db->prepare($query);
            $statement->bindParam(":SKU",$input['sku']);
            $statement->bindParam(":Name",$input['name']);
            $statement->bindParam(":Price",$price);
            $statement->bindParam(":Product_Type",$input['productType']);
            $statement->bindParam(":Height",$height);
            $statement->bindParam(":Weight",$weight);
            $statement->bindParam(":Length",$length);
            $statement->bindParam(":Size",$size);
            $statement->bindParam(":Width",$width);

            if($statement->execute()) {
                return true;
            }
            return false;
            
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($id)
    {
        $statement = "
            DELETE FROM products
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('id' => $id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
