<?php

namespace App\Repositories;

use App\Models\SaleProduct;

class SaleProductRepository
{
    public function create(array $data): SaleProduct
    {
        return SaleProduct::create($data);
    }
}