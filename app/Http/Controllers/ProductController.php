<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTOs\EventResultDTO;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function getProductInformation(EventResultDTO $eventResultDTO) {
        try {
            $product = $this->productService->getProductInformation();

            if ($product->isEmpty()) {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'No se encontraron productos';

                return response()->json($eventResultDTO, 404);
            }

            $eventResultDTO->result = true;
            $eventResultDTO->message = 'Productos encontrados';
            $eventResultDTO->values['productRecords'] = $product;
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Error  ' . $e->getMessage();

            return response()->json($eventResultDTO);
        }

        return response()->json($eventResultDTO);
    }
}