<?php 

namespace App\Middleware;

class JWTAuthMiddleware extends Middleware
{
    public function __invoke($request, $response, $callable)
    {
        
        return $callable();
    }
}
