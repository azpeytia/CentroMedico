<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProductInformation()
    {
        return $this->productRepository->getAll();
    }

    public function searchProductInformation($eventRecord)
    {
        return $this->productRepository->findByName($eventRecord);
    }
}