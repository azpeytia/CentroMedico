<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\DTOs\EventResultDTO;

class ProductController extends Controller
{
    public function getProductInformation(Product $product, EventResultDTO $eventResultDTO) {
        try {
            $eventResultDTO->values['productRecords'] = $product->get();
        } catch (\Exception $e) {
            $eventResultDTO->result = false;
            $eventResultDTO->message = 'Error  ' . $e->getMessage();
            return response()->json($eventResultDTO);
        }
        return response()->json($eventResultDTO);
    }
}
