<?php

namespace App\Services;

use App\DTOs\EventResultDTO;
use App\Http\Requests\Sales\GetSaleInformationRequest;
use App\Repositories\InventoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SaleRepository;
use App\Repositories\SaleProductRepository;
use Illuminate\Support\Facades\DB;

class SaleService
{
    protected $inventoryRepository;
    protected $productRepository;
    protected $saleRepository;
    protected $saleProductRepository;

    public function __construct(
        InventoryRepository $inventoryRepository,
        ProductRepository $productRepository,
        SaleRepository $saleRepository,
        SaleProductRepository $saleProductRepository
    ) {
        $this->inventoryRepository = $inventoryRepository;
        $this->productRepository = $productRepository;
        $this->saleRepository = $saleRepository;
        $this->saleProductRepository = $saleProductRepository;
    }

    public function getSaleInformation(GetSaleInformationRequest $request)
    {
        $eventResultDTO = new EventResultDTO();
        $category = $request->input('category');

        try {
            $sales = $this->saleRepository->getSalesByPeriod($request->input('startDate'), $request->input('endDate'));

            if(!$sales) {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'No hay ventas registradas en este periodo';

                return $eventResultDTO;
            }

            $salesTotal = 0;

            foreach($sales as $sale) {
                $salesTotal += number_format($sale->total, 2, '.', '');
            }

            $eventResultDTO->values['sales'] = $salesTotal;
            $eventResultDTO->message = 'Ventas encontradas';
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Proceso fallido: ' . $e->getMessage();

            return $eventResultDTO;
        }

        return $eventResultDTO;
    }

    public function saveSaleInformation($request): EventResultDTO
    {
        $eventResultDTO = new EventResultDTO();

        DB::beginTransaction();

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
                DB::rollBack();
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'Problemas al salvar la información';

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

                $productModel = $this->productRepository->findById($product['product_id']);
                if ($productModel) {
                    $newStock = $productModel->stock - $product['quantity'];
                    $updateData = [
                        'stock' => $newStock,
                    ];
                    if ($newStock == 0) {
                        $updateData['is_empty'] = 1;
                        $updateData['is_active'] = 0;
                    }
                    $this->productRepository->update($productModel->id, $updateData);
                }

                $inventory = $this->inventoryRepository->findByProductShiftAndDate(
                    $product['product_id'],
                    $request->input('shift_id'),
                    $request->input('shift_date')
                );
                if ($inventory) {
                    $this->inventoryRepository->update($inventory->id, [
                        'sold_stock' => $inventory->sold_stock + $product['quantity']
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Proceso fallido: ' . $e->getMessage();

            return $eventResultDTO;
        }

        $eventResultDTO->values['saleRecords'] = $sale;
        $eventResultDTO->message = 'Venta registrada correctamente';

        return $eventResultDTO;
    }
}