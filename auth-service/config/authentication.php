<?php

return [
    'access_ttl' => (int) env(
        'ACCESS_TOKEN_TTL',
        600
    ),

    'refresh_ttl' => (int) env(
        'REFRESH_TOKEN_TTL',
        2592000
    ),

    'cookie_name' => env(
        'REFRESH_COOKIE',
        'shopwise_rt'
    ),

    'cookie_domain' => env(
        'COOKIE_DOMAIN',
        'http://localhost:8080'
    ),

    'cookie_secure' => (bool) env(
        'COOKIE_SECURE',
        true
    ),

    'cookie_same_site' => env(
        'COOKIE_SAME_SITE',
        'lax'
    ),

    'cookie_http_only' => (bool) env(
        'COOKIE_HTTP_ONLY',
        'false'
    ),

    'web_origins' => array_values(array_filter(
        array_map(
            'trim',
            explode(',', env('WEB_ORIGINS', ''))
        )
    )),
];
