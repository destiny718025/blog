<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\Navs;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
class NavsController extends CommonController
{
    //get.admin/Navs 全部自定義導航  desc為倒序 asc為正序
    public function index(){
        $data = Navs::orderBy('nav_order','asc')->get();
        return view('admin.navs.index',compact('data'));
    }
    public function changeOrder(){
        $input = Input::all();
        $navs = Navs::find($input['nav_id']);
        $navs['nav_order']=$input['nav_order'];
        $re = $navs->update();
        if($re){
            $data = [
              'status' => 0,
              'msg' => '自定義導航排序更新成功!',
            ];
        }else{
            $data = [
              'status' => 1,
              'msg' => '自定義導航更新失敗,請稍後重試!',
            ];
        }
        return $data;
    }
    //get.admin/Navs/{Navs} 顯示單個自定義導
    public function show(){
        
    }
    //get.admin/Navs/create 添加自定義導
    public function create(){
        return view('admin.navs.add');
    }
    //post.admin/Navs 添加自定義導提交
    public function store(){
        $input = Input::except('_token');
        //dd($input);
        $rules=[
            'nav_name'=>'required',
            'nav_url'=>'required',
        ];
        $message=[
            'nav_name.required'=>'自定義導航名稱不能為空',
            'nav_url.required'=>'自定義導航網址不能為空',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re = Navs::create($input);
            if($re){
                return redirect('admin/navs');
            }else{
                return back()->with('errors','添加失敗');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    //get.admin/Navs/{Navs}/edit 編輯自定義導航
    public function edit($nav_id){
        $field = Navs::find($nav_id);
        return view('admin.navs.edit',compact('field'));
    }
    //put.admin/Navs/{Navs} 更新自定義導航
    public function update($nav_id){
        $input = Input::except('_token','_method');
        $re = Navs::where('nav_id',$nav_id)->update($input);
        if($re){
            return redirect('admin/navs');
        }else{
            return back()->with('errors','自定義導航信息修改失敗');
        }
    }
    //delete.admin/Navs/{Navs} 刪除單個自定義導航
    public function destroy($nav_id){
        $re = Navs::where('nav_id',$nav_id)->delete();
        if($re){
            $data = [
              'status' => 0,
              'msg' => '自定義導航刪除成功!',
            ];
        }else{
            $data = [
              'status' => 1,
              'msg' => '自定義導航刪除失敗!',
            ];
        }
        return $data;
    }
}
