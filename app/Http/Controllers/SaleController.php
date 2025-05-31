<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveSaleInformationRequest;
use App\Services\SaleService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SaleController extends Controller
{
    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function create()
    {
        return view('sales.create');
    }

    public function saveSaleInformation(SaveSaleInformationRequest $request): JsonResponse
    {
        $eventResultDTO = $this->saleService->saveSaleInformation($request);

        return response()->json($eventResultDTO);
    }
}