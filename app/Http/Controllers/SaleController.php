<?php

namespace App\Http\Controllers;

use App\DTOs\EventResultDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveSaleInformationRequest;
use App\Http\Requests\Sales\GetSaleInformationRequest;
use App\Services\SaleService;
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

    public function salesAnalysis()
    {
        return view('sales.sales-analysis');
    }

    public function getSaleInformation(GetSaleInformationRequest $request): JsonResponse
    {
        $eventResultDTO = $this->saleService->getSaleInformation($request);

        return response()->json($eventResultDTO);
    }

    public function saveSaleInformation(SaveSaleInformationRequest $request): JsonResponse
    {
        $eventResultDTO = $this->saleService->saveSaleInformation($request);

        return response()->json($eventResultDTO);
    }
}