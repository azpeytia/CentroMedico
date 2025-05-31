<?php

namespace App\Services;

use App\Repositories\InventoryRepository;

class InventoryService
{
    protected $inventoryRepository;

    public function __construct(InventoryRepository $inventoryRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
    }

    public function saveShiftInventoryInformation($productRecords)
    {
        foreach ($productRecords as $record) {
            $data = [
                'product_id' => $record['productId'],
                'shift_id' => $record['shiftId'],
                'date' => $record['shiftDate'],
                'opening_stock' => $record['productStock'],
            ];
            $this->inventoryRepository->create($data);
        }
    }

    public function updateShiftInventoryInformation($productRecords)
    {
        foreach ($productRecords as $record) {
            $inventory = $this->inventoryRepository->findForUpdate(
                $record['shiftId'],
                $record['productId'],
                $record['shiftDate']
            );

            if ($inventory) {
                $inventory->closing_stock = $inventory->opening_stock - $inventory->sold_stock;
                $inventory->save();
            } else {
                return false;
            }
        }
        return true;
    }

    public function getInventoryRequestInformation($shiftId, $shiftDate)
    {
        return $this->inventoryRepository->getInventoryRequest($shiftId, $shiftDate);
    }

    public function getInventoryInformation($shiftId, $shiftDate)
    {
        return $this->inventoryRepository->getInventoryInformation($shiftId, $shiftDate);
    }
}