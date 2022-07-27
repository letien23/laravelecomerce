<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //dd("phải cần có quyền truy cập admin hoặc kỹ thuật viên");
        if(Auth::check()){
            $user=Auth::user();
            if($user->level==1 || $user->level==2){
                return $next($request);
            }
            else {
                return redirect('/dangnhap');
            }
        }
        else {
            return redirect('/dangnhap');
        }
    }
}