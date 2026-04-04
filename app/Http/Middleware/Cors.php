<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedOrigins = config('cors.allowed_origins', ['*']);
        $allowedMethods = config('cors.allowed_methods', ['*']);
        $allowedHeaders = config('cors.allowed_headers', ['*']);

        if ($request->isMethod('OPTIONS')) {
            $response = response('', 204);
        } else {
            $response = $next($request);
        }

        $origin = $request->headers->get('Origin');
        
        if (in_array('*', $allowedOrigins) || in_array($origin, $allowedOrigins)) {
            $response->headers->set('Access-Control-Allow-Origin', in_array('*', $allowedOrigins) ? '*' : $origin);
            $response->headers->set('Access-Control-Allow-Methods', implode(', ', in_array('*', $allowedMethods) ? ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'] : $allowedMethods));
            $response->headers->set('Access-Control-Allow-Headers', implode(', ', in_array('*', $allowedHeaders) ? ['Content-Type', 'Authorization', 'X-Requested-With', 'X-CSRF-TOKEN'] : $allowedHeaders));
            $response->headers->set('Access-Control-Allow-Credentials', 'true');
            $response->headers->set('Access-Control-Max-Age', '86400');
        }

        return $response;
    }
}
