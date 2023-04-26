<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

class JsonErrorMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response->exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
            $status = $response->exception->getStatusCode();
            $message = $response->exception->getMessage();
            return response()->json(['error' => $message], $status);
        }

        return $response;
    }
}
