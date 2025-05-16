<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTOs\EventResultDTO;
use App\Http\Requests\SaveshiftInventoryRequest;
use App\Http\Requests\UpdateShiftInventoryRequest;
use App\Models\Inventory;

class InventoryController extends Controller
{
    public function shiftManagement()
    {
        return view('inventories.shift-management');
    }

    public function saveShiftInventoryInformation(SaveShiftInventoryRequest $request, EventResultDTO $eventResultDTO)
    {
        $productRecords = $request->validated();

        foreach ($productRecords as $record) {
            try {
                $inventory = new Inventory();
                $inventory->product_id = $record['productId'];
                $inventory->shift_id = $record['shiftId'];
                $inventory->date = $record['shiftDate'];
                $inventory->opening_stock = $record['productStock'];

                $inventory->save();
            } catch (\Exception $e) {
                return response()->json([
                    'result' => false,
                    'message' => 'Error al guardar el registro: ' . $e->getMessage()
                ], 500);
            }
        }

        $eventResultDTO->result = true;
        $eventResultDTO->message = 'Se ha iniciado el turno de inventarios exitosamente';
        return response()->json($eventResultDTO);
    }

    public function updateShiftInventoryInformation(UpdateShiftInventoryRequest $request, EventResultDTO $eventResultDTO)
    {
        $productRecords = $request->validated();

        foreach($productRecords as $record) {
            try {
                $inventory = Inventory::where('shift_id', $record['shiftId'])
                    ->where('product_id', $record['productId'])
                    ->where('date', $record['shiftDate'])
                    ->first();

                if ($inventory) {
                    $inventory->closing_stock = $inventory->opening_stock - $inventory->sold_stock;

                    $inventory->save();
                } else {
                    $eventResultDTO->result = false;
                    $eventResultDTO->message = 'No se encontró un inventario para el turno y fecha proporcionados';
                    return response()->json($eventResultDTO);
                }
            } catch (\Exception $e) {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'Error  ' . $e->getMessage();
                return response()->json($eventResultDTO);
            }
        }

        $eventResultDTO->result = true;
        $eventResultDTO->message = 'Se ha terminado el turno de inventarios exitosamente';
        return response()->json($eventResultDTO);
    }

    public function getInventoryRequestInformation (Request $request, Inventory $inventory, EventResultDTO $eventResultDTO) {
        $shiftId = $request->input('eventRecord.shiftId');
        $shiftDate = $request->input('eventRecord.shiftDate');

        try {
            $eventResultDTO->values['inventoryRequestRecords'] = $inventory->with('product:id,name,presentation')
            ->where('shift_id', $shiftId)
            ->where('date', $shiftDate)
            //->where('is_finished', 1)
            ->get();

            if ($eventResultDTO->values['inventoryRequestRecords']) {
                $eventResultDTO->result = true;
                $eventResultDTO->message = 'Se va a generar la requisición';
            } else {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'No se generar la requisición';
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Error  ' . $e->getMessage();
            return response()->json($eventResultDTO);
        }
        return response()->json($eventResultDTO);
    }
}