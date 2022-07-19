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
            $statement = $this->db->prepare($query);
            $statement->bindParam(":SKU",$input['SKU']);
            $statement->bindParam(":Name",$input['Name']);
            $statement->bindParam(":Price",$input['Price']);
            $statement->bindParam(":Product_Type",$input['Product_Type']);
            $statement->bindParam(":Height",$input['Height']);
            $statement->bindParam(":Weight",$input['Weight']);
            $statement->bindParam(":Length",$input['Length']);
            $statement->bindParam(":Size",$input['Size']);
            $statement->bindParam(":Width",$input['Width']);

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
