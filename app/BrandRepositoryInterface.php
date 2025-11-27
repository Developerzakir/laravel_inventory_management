<?php

namespace App;

use App\Models\Brand;

interface BrandRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data): Brand;
    public function update($id, array $data): bool;
    public function delete(Brand $brand): bool;
}
