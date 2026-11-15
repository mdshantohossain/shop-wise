<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellerRegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class SellerController extends Controller
{
    /**
     * @throws \Throwable
     */
    public function register(SellerRegisterRequest $request, AuthService $authService): JsonResponse
   {
       $inputs = $request->validated();

       $inputs['role'] = 'seller';

       $authService->register($inputs);

       return response()->json([
           'success' => true,
           'message' => 'Seller registered successfully',
       ]);
   }

   public function updateProfile()
   {

   }
}
