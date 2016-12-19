@extends('layouts.home')
@section('info')
  <title>{{$field['cate_name']}} - {{Config::get('web.web_title')}}</title>
  <meta name="keywords" content="{{$field['cate_keywords']}}" />
  <meta name="description" content="{{$field['cate_description']}}" />
@endsection
@section('content')
<article class="blogs">
<h1 class="t_nav"><span>{{$field['cate_title']}}</span><a href="{{url('/')}}" class="n1">網站首頁</a><a href="{{url('cate/'.$field['cate_id'])}}" class="n2">{{$field['cate_name']}}</a></h1>
<div class="newblog left">
    @foreach($data as $d)
   <h2>{{$d['art_title']}}</h2>
   <p class="dateview"><span>{{date('Y:m:d',$d['art_time'])}}</span><span>編輯: {{$d['art_editor']}}</span><span>分類：[<a href="{{url('cate/'.$field['cate_id'])}}">{{$field['cate_name']}}</a>]</span></p>
    <figure><img src="{{url('$d["art_thumb"]')}}"></figure>
    <ul class="nlist">
      <p>{{$d['art_description']}}</p>
      <a title="{{$d['art_title']}}" href="{{url('a/').$d['art_id']}}" target="_blank" class="readmore">閱讀全文>></a>
    </ul>
    @endforeach
    <div class="page">
        {{$data->links()}}
    </div>
</div>
<aside class="right">
    @if($submenu->all())
   <div class="rnav">
      <ul>
       @foreach($submenu as $k=>$s)  
           <li class="rnav{{$k+1}}"><a href="{{url('cate/'.$s['cate_id'])}}" target="_blank">{{$s['cate_name']}}</a></li>
       @endforeach
     </ul>      
    </div>
    @endif
    <div class="news">
        @parent
    </div>
</aside>
</article>
@endsection