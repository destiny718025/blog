<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Model\Links;
use App\Http\Model\Category;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
class LinksController extends CommonController
{
    //get.admin/links 全部友情連結  desc為倒序 asc為正序
    public function index(){
        $data = Links::orderBy('link_order','asc')->get();
        return view('admin.links.index',compact('data'));
    }
    public function changeOrder(){
        $input = Input::all();
        $links = Links::find($input['link_id']);
        $links['link_order']=$input['link_order'];
        $re = $links->update();
        if($re){
            $data = [
              'status' => 0,
              'msg' => '友情連結排序更新成功!',
            ];
        }else{
            $data = [
              'status' => 1,
              'msg' => '友情連結更新失敗,請稍後重試!',
            ];
        }
        return $data;
    }
    //get.admin/links/{links} 顯示單個友情連結
    public function show(){
        
    }
    //get.admin/links/create 添加友情連結
    public function create(){
        return view('admin.links.add');
    }
    //post.admin/links 添加友情連結提交
    public function store(){
        $input = Input::except('_token');
        //dd($input);
        $rules=[
            'link_name'=>'required',
            'link_url'=>'required',
        ];
        $message=[
            'link_name.required'=>'友情連結名稱不能為空',
            'link_url.required'=>'友情連結網址不能為空',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re = Links::create($input);
            if($re){
                return redirect('admin/links');
            }else{
                return back()->with('errors','添加失敗');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    //get.admin/links/{links}/edit 編輯友情連結
    public function edit($link_id){
        $field = Links::find($link_id);
        return view('admin.links.edit',compact('field'));
    }
    //put.admin/links/{links} 更新友情連結
    public function update($link_id){
        $input = Input::except('_token','_method');
        $re = Links::where('link_id',$link_id)->update($input);
        if($re){
            return redirect('admin/links');
        }else{
            return back()->with('errors','友情連結信息修改失敗');
        }
    }
    //delete.admin/links/{links} 刪除單個友情連結
    public function destroy($link_id){
        $re = Links::where('link_id',$link_id)->delete();
        if($re){
            $data = [
              'status' => 0,
              'msg' => '友情連結刪除成功!',
            ];
        }else{
            $data = [
              'status' => 1,
              'msg' => '友情連結刪除失敗!',
            ];
        }
        return $data;
    }
}
