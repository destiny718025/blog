<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Model\User;
use \Crypt;
use Illuminate\Support\Facades\Validator;
class IndexController extends CommonController
{
    public function index(){
        return view('admin.index');
    }
    public function info(){
        return view('admin.info');
    }
    public function quit(){
        session(['user'=>null]);
        return redirect('admin/login');
    }
    public function pass(){
        if($input=Input::all()){
            $rules=[
                'password'=>'required|between:6,20|confirmed',
            ];
            $message=[
                'password.required'=>'新密碼不能為空',
                'password.between'=>'新密碼必須6-20位',
                'password.confirmed'=>'新密碼與確認密碼不同',
            ];
            $validator = Validator::make($input,$rules,$message);
            if($validator->passes()){
                $user = User::first();
                $_password = Crypt::decrypt($user->user_pass);
                if($input['password_o']==$_password){
                    $user->user_pass=Crypt::encrypt($input['password']);
                    $user->update();
                    return back()->with('errors','密碼修改成功!');
                }else{
                    return back()->with('errors','原密碼錯誤');
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return view('admin.pass');
        }
    }
}
