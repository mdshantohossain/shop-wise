<?php

namespace App\Modules\Order\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use service\Catalog\app\Models\Product;
use service\Catalog\app\Models\ProductVariant;

class OrderDetail extends Model
{
    protected $guarded = [];

    public function product(): BelongsTo
    {
        return $this->belongsTo(service\Catalog\app\Models\Product::class, 'product_id');
    }

    public function variant(): HasOne
    {
        return $this->hasOne(service\Catalog\app\Models\ProductVariant::class, 'id', 'variant_id');
    }
}
