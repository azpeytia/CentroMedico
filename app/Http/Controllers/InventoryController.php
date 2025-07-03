<?php

namespace App\Http\Controllers;

use App\DTOs\EventResultDTO;
use App\Http\Requests\SaveShiftInventoryRequest;
use App\Http\Requests\UpdateShiftInventoryRequest;
use App\Http\Requests\Inventories\UpdateInventoryStockRequest;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InventoryController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function inventoryByShift()
    {
        return view('inventories.inventory-by-shift');
    }

    public function shiftManagement()
    {
        return view('inventories.shift-management');
    }

    public function restockInventory()
    {
        return view('inventories.restock-inventory');
    }

    public function inventoryRequisition(Request $request, EventResultDTO $eventResultDTO)
    {
        return view('inventories.inventory-requisition');
    }

    public function saveShiftInventoryInformation(SaveShiftInventoryRequest $request, EventResultDTO $eventResultDTO)
    {
        $productRecords = $request->validated();

        try {
            $this->inventoryService->saveShiftInventoryInformation($productRecords);

            $eventResultDTO->result = true;
            $eventResultDTO->message = 'Se ha iniciado el turno de inventarios exitosamente';
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Error al guardar el registro: ' . $e->getMessage();

            return response()->json($eventResultDTO, 500);
        }

        return response()->json($eventResultDTO);
    }

    public function updateInventoryStock(UpdateInventoryStockRequest $request): JsonResponse
    {
        $result = $this->inventoryService->updateInventoryStock($request);

        return response()->json($result);
    }

    public function updateShiftInventoryInformation(UpdateShiftInventoryRequest $request, EventResultDTO $eventResultDTO)
    {
        $productRecords = $request->validated();

        try {
            $records = $this->inventoryService->updateShiftInventoryInformation($productRecords);
            if ($records) {
                $eventResultDTO->result = true;
                $eventResultDTO->message = 'Se ha terminado el turno de inventarios exitosamente';
            } else {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'No se encontró un inventario para el turno y fecha proporcionados';
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Error  ' . $e->getMessage();

            return response()->json($eventResultDTO, 500);
        }

        return response()->json($eventResultDTO);
    }

    public function getInventoryRequestInformation (Request $request, EventResultDTO $eventResultDTO) {
        $shiftId = $request->input('eventRecord.shiftId');
        $shiftDate = $request->input('eventRecord.shiftDate');

        try {
            $records = $this->inventoryService->getInventoryRequestInformation($shiftId, $shiftDate);

            $eventResultDTO->values['inventoryRequestRecords'] = $records;
            $eventResultDTO->result = true;
            $eventResultDTO->message = 'Se va a generar la requisición';
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Error  ' . $e->getMessage();

            return response()->json($eventResultDTO, 500);
        }

        return response()->json($eventResultDTO);
    }

    public function getInventoryInformation(Request $request, EventResultDTO $eventResultDTO)
    {
        $shiftId = $request->input('eventRecord.shiftId');
        $shiftDate = $request->input('eventRecord.shiftDate');

        try {
            $records = $this->inventoryService->getInventoryInformation($shiftId, $shiftDate);

            if ($records) {
                $eventResultDTO->values['inventoryRecords'] = $records;
                $eventResultDTO->result = true;
                $eventResultDTO->message = 'Se ha encontrado un turno de inventarios iniciado';
            } else {
                $eventResultDTO->result = false;
                $eventResultDTO->message = 'No se encontró un turno de inventarios iniciado';
            }
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Error  ' . $e->getMessage();

            return response()->json($eventResultDTO, 500);
        }

        return response()->json($eventResultDTO);
    }
}