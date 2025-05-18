<?php

namespace App\Repositories;

use App\Models\Inventory;

class InventoryRepository
{
    public function create($data)
    {
        return Inventory::create($data);
    }

    public function findForUpdate($shiftId, $productId, $shiftDate)
    {
        return Inventory::where('shift_id', $shiftId)
            ->where('product_id', $productId)
            ->where('date', $shiftDate)
            ->first();
    }

    public function getInventoryRequest($shiftId, $shiftDate)
    {
        return Inventory::with('product:id,name,presentation')
            ->where('shift_id', $shiftId)
            ->where('date', $shiftDate)
            ->get();
    }
}