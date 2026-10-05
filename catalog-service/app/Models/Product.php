<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Product extends Model
{
    protected $guarded = [];

    protected $casts = [
        'product_policy_id' => 'array'
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }
    public function otherImages(): HasMany
    {
        return $this->hasMany(OtherImage::class);
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product_id');
    }
    public function variants(): HasMany
    {
        return  $this->hasMany(ProductVariant::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function policies()
    {
        $ids = $this->product_policy_id;

        if (is_string($ids)) {
            $ids = json_decode($ids, true);
        }

        return ProductPolicy::whereIn('id', $ids ?? [])->select(['id', 'title', 'image']);
    }
}
