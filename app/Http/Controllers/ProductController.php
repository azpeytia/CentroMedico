<?php

namespace App\Http\Controllers;

use App\DTOs\EventResultDTO;
use App\Services\ProductService;
use Illuminate\Http\Request;

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

    public function searchProductInformation(Request $request, EventResultDTO $eventResultDTO) {
        try {
            $records = $this->productService->searchProductInformation($request->eventRecord);

            if ($records) {
                $eventResultDTO->values['productRecords'] = $records;
                $eventResultDTO->result = true;
                $eventResultDTO->message = 'Se han encontrado los registros de productos exitosamente';
            } else {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'No se encontraron registros de productos para el nombre proporcionado';
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Error  ' . $e->getMessage();

            return response()->json($eventResultDTO, 500);
        }

        return response()->json($eventResultDTO);
    }
}