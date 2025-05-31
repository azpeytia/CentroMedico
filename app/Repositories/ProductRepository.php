<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getAll()
    {
        return Product::all();
    }

    public function findById($id)
    {
        return Product::find($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update($id, array $data)
    {
        $product = $this->findById($id);
        if ($product) {
            $product->update($data);
            return $product;
        }
        return null;
    }

    public function delete($id)
    {
        $product = $this->findById($id);
        if ($product) {
            $product->delete();
            return true;
        }
        return false;
    }

    public function findByName($eventRecord)
    {
        return Product::where('name', 'like', "%$eventRecord%")->get();
    }
}