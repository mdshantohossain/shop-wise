<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellerRegisterRequest;

class SellerController extends Controller
{
   public function register(SellerRegisterRequest $request)
   {
       $data  = ['ok'];
       return response()->json('ok');
   }
}
