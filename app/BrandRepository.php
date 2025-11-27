<?php

namespace App;

use App\Models\Brand;
use App\BrandRepositoryInterface;

class BrandRepository implements BrandRepositoryInterface
{
    public function all()
    {
        return Brand::latest()->get();
    }

    public function find($id)
    {
        return Brand::findOrFail($id);
    }

    public function create(array $data): Brand
    {
        return Brand::create($data);
    }

    public function update($id, array $data): bool
    {
        $brand = $this->find($id);
        return $brand->update($data);
    }

    public function delete(Brand $brand): bool
    {
        return $brand->delete();
    }
}

