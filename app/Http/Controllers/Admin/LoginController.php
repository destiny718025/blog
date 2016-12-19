<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Model\User;
use \Crypt;
require_once 'resources/org/code/Code.class.php';
class LoginController extends CommonController
{
    public function login(){
        if($input=Input::all()){
            $code = new \Code;
            $_code = $code->get();
            if($_code!=strtoupper($input['code'])){
                return back()->with('msg','驗證碼錯誤!');
            }
            $user = User::first();
            if($user->user_name!=$input['user_name']|| Crypt::decrypt($user->user_pass)!=$input['user_pass']){
                return back()->with('msg','用戶名或密碼錯誤!');
            }
            session(['user'=>$user['user_name']]);
            return redirect('admin');
        }else{
            return view('admin.login');
        }
    }
    public function code(){
        $code = new \Code;
        $code->make();
    }
    public function quit(){
        session(['user'=>null]);
        return redirect('admin/login');
    }
}
