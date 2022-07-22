<?php

namespace Src\Services;

use Src\Models\Product;

interface ProductService
{

    public function findAll();

    public function find(int $id);

    public function findBySku(String $sku);

    public function insert(Product $product);

    public function delete(int $id);
}