<?php

namespace App\Http\Controllers;


use App\Http\Requests\SellerRegisterRequest;

class SellerController extends Controller
{
    public function register(SellerRegisterRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->validated()
        ]);
    }
}
