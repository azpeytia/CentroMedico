<?php

namespace App\Repositories;

use App\Models\Inventory;

class InventoryRepository
{
    public function create($data)
    {
        return Inventory::create($data);
    }

    public function update($id, $data)
    {
        $inventory = Inventory::find($id);
        if ($inventory) {
            $inventory->update($data);
            return $inventory;
        }
        return null;
    }

    public function findByProductShiftAndDate($productId, $shiftId, $shiftDate)
    {
        return Inventory::where('product_id', $productId)
            ->where('shift_id', $shiftId)
            ->where('date', $shiftDate)
            ->first();
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

    public function getInventoryInformation($shiftId, $shiftDate)
    {
        return Inventory::with('product:id,name,presentation')
            ->where('shift_id', $shiftId)
            ->where('date', $shiftDate)
            ->get();
    }
}