<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\Config;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ConfigController extends CommonController
{
    //get.admin/config 全部配置項  desc為倒序 asc為正序
    public function index(){
        $data = Config::orderBy('conf_order','asc')->get();
        foreach($data as $k=>$v){
            switch($v['field_type']){
                case 'input':
                    $data[$k]->_html='<input type="text" class="lg" name="conf_content[]" value="'.$v['conf_content'].'">';
                    break;
                case 'textarea':
                    $data[$k]->_html='<textarea class="lg" name="conf_content[]">'.$v['conf_content'].'</textarea>';
                    break;
                case 'radio':
                    $arr = explode(',',$v['field_value']);
                    $str = '';
                    foreach($arr as $m=>$n){
                        $r = explode(':',$n);
                        $c = $v['conf_content']==$r[0]?'checked':'';
                        $str .= '<input type="radio" '.$c.' name="conf_content[]" value="'.$r[0].'">'.$r[1].'　';
                    }
                    $data[$k]->_html = $str;
                    break;
            }
        }
        return view('admin.config.index',compact('data'));
    }
    public function changeOrder(){
        $input = Input::all();
        $conf = Config::find($input['conf_id']);
        $conf['conf_order']=$input['conf_order'];
        $re = $conf->update();
        if($re){
            $data = [
              'status' => 0,
              'msg' => '配置項排序更新成功!',
            ];
        }else{
            $data = [
              'status' => 1,
              'msg' => '配置項更新失敗,請稍後重試!',
            ];
        }
        return $data;
    }
    public function changeContent(){
        $input=Input::all();
        foreach($input['conf_id'] as $k=>$v){
            Config::where('conf_id',$v)->update(['conf_content'=>$input['conf_content'][$k]]);
        }
        $this->putFile();
        return back()->with('errors','配置項更新成功');
    }
    public function putFile(){
        $config=Config::pluck('conf_content','conf_name')->all();
        $path = base_path().'/config/web.php';
        $str = '<?php return '.var_export($config,true).';';
        file_put_contents($path,$str);
    }
    //get.admin/config/{config} 顯示單個自定義導
    public function show(){
        
    }
    //get.admin/config/create 添加自定義導
    public function create(){
        return view('admin.config.add');
    }
    //post.admin/config 添加自定義導提交
    public function store(){
        $input = Input::except('_token');
        //dd($input);
        $rules=[
            'conf_name'=>'required',
            'conf_title'=>'required',
        ];
        $message=[
            'conf_name.required'=>'配置項名稱不能為空',
            'conf_title.required'=>'配置項標題不能為空',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re = Config::create($input);
            if($re){
                return redirect('admin/config');
            }else{
                return back()->with('errors','添加失敗');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    //get.admin/config/{config}/edit 編輯配置項
    public function edit($conf_id){
        $field = Config::find($conf_id);
        return view('admin.config.edit',compact('field'));
    }
    //put.admin/config/{config} 更新配置項
    public function update($conf_id){
        $input = Input::except('_token','_method');
        $re = Config::where('conf_id',$conf_id)->update($input);
        if($re){
            $this->putFile();
            return redirect('admin/config');
        }else{
            return back()->with('errors','配置項信息修改失敗');
        }
    }
    //delete.admin/config/{config} 刪除單個配置項
    public function destroy($conf_id){
        $re = Config::where('conf_id',$conf_id)->delete();
        if($re){
            $this->putFile();
            $data = [
              'status' => 0,
              'msg' => '配置項刪除成功!',
            ];
        }else{
            $data = [
              'status' => 1,
              'msg' => '配置項刪除失敗!',
            ];
        }
        return $data;
    }
}
