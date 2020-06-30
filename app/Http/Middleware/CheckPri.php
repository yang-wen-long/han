<?php

namespace App\Http\Middleware;

use Closure;
//redis的方法
use Illuminate\Support\Facades\Redis;
class CheckPri
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
        $token = $request->input("token");
        $uid = Redis::get($token);
        if(!$uid){
            //未登录
            $response = [
                "error" => 50014,
                "msg"   => "鉴权失败，请登录在试"
            ];
            echo json_encode($response,JSON_UNESCAPED_UNICODE);
            die;
        }
        return $next($request);
    }
}
