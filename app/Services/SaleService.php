<?php

namespace App\Services;

use App\DTOs\EventResultDTO;
use App\Repositories\SaleRepository;
use App\Repositories\SaleProductRepository;

class SaleService
{
    protected $saleRepository;
    protected $saleProductRepository;

    public function __construct(SaleRepository $saleRepository, SaleProductRepository $saleProductRepository)
    {
        $this->saleRepository = $saleRepository;
        $this->saleProductRepository = $saleProductRepository;
    }

    public function saveSaleInformation($request): EventResultDTO
    {
        $eventResultDTO = new EventResultDTO();

        try {
            $sale = $this->saleRepository->create([
                'patient_id' => $request->input('patient_id'),
                'shift_id' => $request->input('shift_id'),
                'user_id' => $request->input('user_id'),
                'total' => $request->input('total'),
                'status' => $request->input('status'),
                'payment_method' => $request->input('payment_method'),
                'is_active' => $request->input('is_active', true),
                'is_suspended' => $request->input('is_suspended', false),
                'is_deleted' => $request->input('is_deleted', false),
            ]);

            if (!$sale) {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'Problemas al salvar la información de la venta';

                return $eventResultDTO;
            }

            $products = $request->input('products', []);
            foreach ($products as $product) {
                $this->saleProductRepository->create([
                    'sale_id' => $sale->id,
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'unit_price' => $product['unit_price'],
                    'subtotal' => $product['subtotal'],
                    'is_active' => $product['is_active'] ?? 1,
                ]);
            }

        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Proceso fallido: ' . $e->getMessage();

            return $eventResultDTO;
        }

        $eventResultDTO->values['saleRecords'] = $sale;
        $eventResultDTO->message = 'Venta registrada correctamente';

        return $eventResultDTO;
    }
}