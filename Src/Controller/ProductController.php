<?php
namespace Src\Controller;

use Src\Services\ProductService;

class ProductController {

    private $db;
    private $requestMethod;

    private $productService;

    public function __construct($db, $requestMethod)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;

        $this->productService = new ProductService($this->db);
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
        $stmt = $this->productService->insert($input);
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

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
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