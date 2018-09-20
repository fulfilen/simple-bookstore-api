<?php  
namespace App\Middleware;
class ValidationErrorsMiddleware extends Middleware
{
    public function __invoke($req, $res, $next)
    {     
        $response =  $next($res, $res);
        return $response;
    }
}
