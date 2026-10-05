<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use service\Catalog\app\Models\Product;

class Wishlist extends Model
{
    public function product(): BelongsTo
    {
        return $this->belongsTo(service\Catalog\app\Models\Product::class, 'product_id');
    }
}
