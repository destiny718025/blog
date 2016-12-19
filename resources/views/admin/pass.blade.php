@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{secure_url('admin/info')}}">首頁</a> &raquo; 修改密碼
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>修改密碼</h3>
		@if(count($errors)>0)
            <div class="mark">
                @if(is_object($errors))
                    @foreach($errors->all() as $error)
                        <p>{{$error}}</p>
                    @endforeach
                @else
                    <p>{{$errors}}</p>
                @endif
            </div>
        @endif
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form method="post" action="">
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>
            <tr>
                <th width="120"><i class="require">*</i>原密碼：</th>
                <td>
                    <input type="password" name="password_o"> </i>請輸入原始密碼</span>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>新密碼：</th>
                <td>
                    <input type="password" name="password"> </i>新密碼6-20位</span>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>確認密碼：</th>
                <td>
                    <input type="password" name="password_confirmation"> </i>再次輸入密碼</span>
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input type="submit" value="提交">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
</body>
@endsection