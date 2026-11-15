<?php

namespace App\Supports;

use Symfony\Component\HttpFoundation\Cookie;

class AuthCookie
{
    public static function make(string $token): Cookie
    {
        return cookie(
            config('authentication.cookie_name'),
            $token,
            (int) ceil(
                config('authentication.refresh_ttl') / 60
            ),
            path:'/',
            domain: config('authentication.cookie_domain'),
            secure: config('authentication.cookie_secure'),
            httpOnly: config('authentication.cookie_http_only'),
            sameSite: config('authentication.cookie_same_site')
        );
    }

    public static function forget(): Cookie
    {
        return cookie()->forget(
            name: config('authentication.cookie_name'),
            path: '/',
            domain: config('authentication.cookie_domain')
        );
    }
}
