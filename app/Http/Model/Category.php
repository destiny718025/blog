<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='category';
    protected $primaryKey='cate_id';
    public $timestamps=false;
    protected $guarded=[];
    
    public function tree(){
        $categorys = $this->orderBy('cate_order','asc')->get();
        return $this->getTree($categorys,'cate_id','cate_pid','cate_name');
    }
    public function getTree($data,$fild_id='id',$fild_pid='pid',$fild_name='name',$pid=0){
        $arr=array();
        foreach($data as $k=>$v){
            if($v[$fild_pid]==$pid){
                $arr[]=$data[$k];
                foreach($data as $m=>$n){
                    if($n[$fild_pid]==$v[$fild_id]){
                        $data[$m][$fild_name]='└─ '.$data[$m][$fild_name];
                        $arr[]=$data[$m];
                    }
                }
            }
        }
        return $arr;
    }
}
