<?php

namespace App\Repositories;

use App\Models\Sale;

class SaleRepository
{
    public function getSalesByPeriod($startDate, $endDate)
    {
        return Sale::whereBetween('created_at', [$startDate, $endDate])
            ->get();
    }

    public function create(array $data): ?Sale
    {
        return Sale::create($data);
    }
}