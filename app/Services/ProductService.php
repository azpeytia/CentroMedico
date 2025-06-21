<?php

namespace App\Services;

use App\DTOs\EventResultDTO;
use App\Http\Requests\Products\LoadProductInformationRequest;
use App\Http\Requests\Products\UpdateProductStockRequest;
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

    public function loadProductInformation(LoadProductInformationRequest $request): EventResultDTO
    {
        $eventResultDTO = new EventResultDTO();

        try {
            $productRecord = $this->productRepository->findByGtinBarCode($request->input('gtinBarCode'));

            if (!$productRecord) {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'No se encontró un producto para el código proporcionado';

                return $eventResultDTO;
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Proceso fallido: ' . $e->getMessage();

            return $eventResultDTO;
        }

        $eventResultDTO->values['productRecord'] = $productRecord;
        $eventResultDTO->message = 'Producto encontrado';

        return $eventResultDTO;
    }

    public function searchProductInformation($eventRecord)
    {
        return $this->productRepository->findByName($eventRecord);
    }

    public function updateProductStock(UpdateProductStockRequest $request): EventResultDTO
    {
        $eventResultDTO = new EventResultDTO();

        try {
            $product = $this->productRepository->updateProductStock(
                $request->input('gtinBarCode'),
                (int) $request->input('quantity')
            );

            if (!$product) {
                return EventResultDTO::error('No se encontró un producto con el código de barras proporcionado');
            }

            return EventResultDTO::success('Producto actualizado exitosamente', [
                'productRecord' => $product
            ]);
        } catch (\Exception $e) {
            return EventResultDTO::error('Error inesperado: ' . $e->getMessage());
        }
    }
}