<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public string $url;

    public function __construct()
    {
        $this->url = rtrim(config('services.auth.url'), '/');
    }

    public function register(Request $request)
    {

    }

    public function sellerRegister(Request $request)
    {
        return forward( $this->url .'/api/v1/seller/register' , $request);
    }
}
