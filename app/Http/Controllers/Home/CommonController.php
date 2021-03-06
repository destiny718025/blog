<?php

namespace App\Http\Controllers\Home;
use App\Http\Model\Article;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Model\Navs;
use Illuminate\Support\Facades\View;
class CommonController extends Controller
{
    public function __construct(){
        $navs = Navs::all();
        //點擊量最高的5篇文章
        $hot = Article::orderBy('art_view','desc')->take(5)->get();
        
        //最新文章8條
        $new = Article::orderBy('art_time','desc')->take(8)->get();
        
        View::share('navs',$navs);
        View::share('hot',$hot);
        View::share('new',$new);
    }
}
