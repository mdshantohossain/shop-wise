<?php

namespace App\Services;

use App\Models\Faq;
use Illuminate\Support\Facades\DB;

class FaqService
{
    public function createOrUpdate(array $inputs, Faq $faq = null): ?Faq
    {
       return DB::transaction(function () use ($inputs, $faq) {
            return $faq ? tap($faq)->update($inputs) : Faq::create($inputs);
        });
    }
}
