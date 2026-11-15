<?php

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

function forward(string $url, Request $request)
{
    try {
        $http = Http::acceptJson()
            ->asJson()
            ->connectTimeout(3)
            ->timeout(10)
            ->retry(
                3,
                100,
                fn ($exception) => $exception instanceof ConnectionException
                    || ($exception instanceof RequestException
                        && $exception->response->serverError()),
                throw: false
            );

        $res = match (strtoupper($request->method())) {
            'GET'  => $http->get($url, $request->query()),
            'POST' => $http->post($url, $request->all()),
            default => abort(405, 'HTTP method not supported'),
        };

        return response($res->body(), $res->status())
            ->header('Content-Type', 'application/json');

    } catch (ConnectionException $e) {
        logger()->error($e);

        return response()->json([
            'message' => 'Auth service unavailable',
        ], 503);

    } catch (\Throwable $th) {
        logger()->error($th);

        return response()->json([
            'message' => 'Gateway error',
        ], 500);
    }
}
