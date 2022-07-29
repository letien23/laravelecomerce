<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    public function getLogin()
    {
        # code...
        return view('admin.pages.login');
    }
    public function postLogin(Request $request)
    {
        # code...
        $this->validate(
            $request,
            [
            'email'=>'required|email',
            'password'=>'required|min:6|max:20'
        ],
            [
            'email.required'=>'Vui lòng nhập email',
            'email.email'=>'Không đúng định dạng email',
            'password.required'=>'Vui lòng nhập mật khẩu',
            'password.min'=>'Mật khẩu ít nhất 6 ký tự',
            'password.max'=>'Mật khẩu tối đa 20 ký tự'
        ]
        );
        $credentials=['email'=>$request->email,'password'=>$request->password];
        if (Auth::attempt($credentials)) {//The attempt method will return true if authentication was successful. Otherwise, false will be returned.
            return redirect("admin/category/category-list");
        } else {
            return  view("admin.pages.login");
        }
    }
}