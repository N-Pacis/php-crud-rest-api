<?php

namespace Src\Services;

class ProductService
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
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
            print("Statement "+$statement);
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
        products_db
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
        $statement = "
            INSERT INTO products_db
                (SKU, Name, Price,Product_Type,Height,Width,Length,Weight,Size)
            VALUES
                (:SKU, :Name, :Price,:Product_Type,:Height,:Width,:Length,:Weight,:Size);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'SKU' => $input['SKU'],
                'Name'  => $input['Name'],
                'Price'  => $input['Price'],
                'Product_Type'  => $input['Product_Type'],
                'Height' => $input['Height'] ?? null,
                'Width' => $input['Width'] ?? null,
                'Length' => $input['Length'] ?? null,
                'Weight' => $input['Weight'] ?? null,
                'Size' => $input['Size'] ?? null,
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($id)
    {
        $statement = "
            DELETE FROM products_db
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
