<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController
{
    private Product $productModel;

    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }

    public function listProducts(): void
    {
        try {
            $products = $this->productModel->getAll();
            header('Content-Type: application/json');
            echo json_encode($products);
        } catch (\Exception $e) {
            error_log('Error fetching products: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Unable to fetch products.']);
        }
    }
}
