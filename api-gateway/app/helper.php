<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

function forward( $url, Request $request)
{
    try {
        $res = Http::acceptJson()
                    ->asJson()
                    ->connectTimeout(3)
                    ->timeout(10)
                    ->retry(3, 100)
                    ->throw()
                    ->post($url, $request);

        return response(
            $res->body(),
            $res->status()
        )->header('Content-Type', 'application/json');

    } catch (\Throwable $th) {
        logger()->error($th);
        $statusCode = $th->getCode();
        if ($statusCode < 100 || $statusCode > 599) {
            $statusCode = 503;
        }

        return response()->json([
            'message' => 'Auth service error',
            'error' => $th->getMessage()
        ], $statusCode);
    }
}
