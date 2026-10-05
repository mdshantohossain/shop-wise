<?php

namespace App\Services;

use App\Models\Banner;

class BannerService
{

    public function createOrUpdate(array $data, ?Banner $banner = null): ?Banner
    {
        try {


            return null;

        } catch (\Throwable $th) {
            report($th);
            return null;
        }
    }
}
