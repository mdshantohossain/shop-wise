<?php

namespace App\Observers;

use App\Jobs\ProductCacheJob;
use service\Catalog\app\Models\Product;
use service\Catalog\app\Models\Review;

class ReviewObserver
{
    /**
     * Handle the Review "created" event.
     */
    public function created(Review $review): void
    {
        $this->revalidateProductCached($review->product_id);
    }

    public function updated(Review $review): void
    {
        $this->revalidateProductCached($review->product_id);
    }

    public function deleted(Review $review): void
    {
        $this->revalidateProductCached($review->product_id);
    }

    public function revalidateProductCached(int $id): void
    {
        $product = Product::find($id);
        ProductCacheJob::dispatch($product->id, $product->slug, $product->category_id);
    }
}
