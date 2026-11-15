<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public string $authServiceUrl;

    public function __construct()
    {
        $this->authServiceUrl = rtrim(config('services.auth.url'), '/');
    }

    public function login(Request $request)
    {
        return forward( $this->authServiceUrl .'/api/v1/auth/login', $request);
    }

    public function register(Request $request)
    {
        return forward( $this->authServiceUrl .'/api/v1/auth/register', $request);
    }

    public function sellerRegister(Request $request)
    {
        return forward( $this->authServiceUrl .'/api/v1/seller/register', $request);
    }
}
