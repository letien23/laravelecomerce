<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginMiddldeware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // if(Auth::check()){
        //     $user=Auth::user();
        //     // if($user->level==1 || $user->level==2){
                
        //     // }
        //     return $next($request);
        // }
        // else{
        //     return redirect('admin.page.login');
        // }
        if(Auth::check()){
            $user=Auth::user();
            if($user->level==1 || $user->level==2){
                return $next($request);
            }
            else {
                return redirect('admin.page.login');
            }
        }
        else {
            return redirect('admin.page.login');
        }
    }
    
}