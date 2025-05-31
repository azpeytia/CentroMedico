<?php

namespace App\Repositories;

use App\Models\Sale;

class SaleRepository
{
    public function create(array $data): ?Sale
    {
        return Sale::create($data);
    }
}