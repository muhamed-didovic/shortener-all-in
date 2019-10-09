<?php

namespace App\Http\Middleware;

use Validator;
use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //dd('1');
        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     => '*',
//            'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With'
        ];
    
        if ($request->isMethod('OPTIONS'))
        {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }
    
        $response = $next($request);
        foreach($headers as $key => $value)
        {
            $response->header($key, $value);
        }
    
        return $response;
        
//        $headers = [
//            'Access-Control-Allow-Origin' => '*',
//            'Access-Control-Allow-Methods' => 'HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS',
//            'Access-Control-Allow-Headers' => 'Content-Type',
//        ];
////        dd('11');
//        if ($request->getMethod() === 'OPTIONS') {
//            return response(null, 200, $headers);
//        }
//
//        $response = $next($request);
//
//        foreach ($headers as $key => $value) {
//            $response->header($key, $value);
//        }
//
//        return $response;
    }
}
