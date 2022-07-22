<?php
namespace Src\Controller;

use Src\Models\Product;
use Src\ServiceImpls\ProductServiceImpl;
use Src\Services\ProductService;

class ProductController {

    private $db;
    private $requestMethod;

    private ProductService $productService;

    public function __construct($db, $requestMethod)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;

        $this->productService = new ProductServiceImpl($this->db);
    }

    public function processRequest()
    {
        
        switch ($this->requestMethod) {
            case 'GET':                
                $response = $this->getAllProducts();
                break;
            case 'POST':
                $response = $this->registerProduct();
                break;
            case 'PUT':
                $response = $this->deleteProduct();
                break;
            case 'OPTIONS':
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getAllProducts()
    {
        $result = $this->productService->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function registerProduct()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateProduct($input)) {
            return $this->unprocessableEntityResponse();
        }
        if ($this->checkProductExistence($input['sku'])){
            return $this->productAlreadyExists($input['sku']);
        }

        $product = Product::initializeValues($input['sku'], $input['name'], (float) $input['price'],$input['productType'],(float) $input['height'],(float) $input['width'],(float) $input['length'],(float) $input['weight'],(float) $input['size']);

        $stmt = $this->productService->insert($product);
        if($stmt){
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = null;
        }
        else{
            $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
            $response['body'] = null;
        }
        return $response;
    }

    private function deleteProduct()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        $ids = $input['ids'];
        foreach ($ids as $id) {
            $result = $this->productService->find($id);
            if (! $result) {
                return $this->notFoundResponse();
            }
            $this->productService->delete($id);
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function validateProduct($input)
    {
        if (! isset($input['sku']) || ! isset($input['name']) || !isset($input['price'])) {
            return false;
        }
        return true;
    }

    private function checkProductExistence($sku){
        $result = $this->productService->findBySku($sku);
        if ($result) {
            return true;
        }
        return false;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function productAlreadyExists(String $sku)
    {
        $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
        $response['body'] = json_encode([
            'error' => 'Product with SKU ' . $sku . ' already exists'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}