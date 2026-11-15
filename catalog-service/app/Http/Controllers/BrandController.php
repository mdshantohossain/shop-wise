<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use service\Catalog\app\Models\Brand;

class BrandController extends Controller
{
    public string $cacheKey = 'brands.all';
    public function getBrands()
    {
        $brands = Cache::remember($this->cacheKey, now()->addDay(), function () {
            return Brand::where('status', 1)->get();
        });

        return response()->json([
            'success' => true,
            'data' => $brands,
        ]);
    }

    public function revalidateBrandsCache()
    {
        Cache::forget($this->cacheKey);
    }
}
