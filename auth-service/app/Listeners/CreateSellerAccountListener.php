<?php

namespace App\Listeners;

use App\Events\SellerRegisteredEvent;
use App\Models\Seller;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class CreateSellerAccountListener implements ShouldQueue
{
    public function handle(SellerRegisteredEvent $event): void
    {
        $inputs = $event->data;
        DB::transaction(function () use ($inputs) {
            $data = [];

            $baseSlug = strtolower(str_replace(' ', '-', $inputs['store_name']));
            $slug = $baseSlug;
            $count = 1;

            $data['user_id'] = $inputs['user_id'];
            $data['store_name'] = $inputs['store_name'];
            $data['seller_type'] = $inputs['seller_type'];
            $data['store_phone'] = $inputs['store_phone'];
            $data['store_email'] = $inputs['store_email'];
            $data['description'] = $inputs['description'];
            $data['city'] = $inputs['city'];
            $data['state'] = $inputs['state'];
            $data['address'] = $inputs['address'];

            while(Seller::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count;
                $count++;
            }

            $data['slug'] = $slug;

           Seller::create($data);

        });
    }
}
