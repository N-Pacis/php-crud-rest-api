<?php

namespace Src\Services;

interface ProductService
{

    public function findAll();

    public function find($id);

    public function insert(array $input);

    public function delete($id);
}