@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首頁</a> &raquo; 分類管理
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果頁面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>分類列表</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>新增分類</a>
                    <a href="{{url('admin/category')}}"><i class="fa fa-recycle"></i>全部分類</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>分類名稱</th>
                        <th>標題</th>
                        <th>查看次數</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc">
                                <input type="text" onchange='changeOrder(this,{{$v['cate_id']}})' value="{{$v['cate_order']}}">
                            </td>
                            <td class="tc">{{$v['cate_id']}}</td>
                            <td>
                                <a href="#">{{$v['cate_name']}}</a>
                            </td>
                            <td>{{$v['cate_title']}}</td>
                            <td>{{$v['cate_view']}}</td>
                            <td>
                                <a href="{{url('admin/category/'.$v['cate_id'].'/edit')}}">修改</a>
                                <a href="javascript:;" onclick="delCate({{$v['cate_id']}})">刪除</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
    <!--搜索结果頁面 列表 结束-->
</body>
<script>
    function changeOrder(obj,cate_id){
        var cate_order=$(obj).val();
        $.post("{{url('admin/cate/changeorder')}}",{'_token':'{{csrf_token()}}','cate_id':cate_id,'cate_order':cate_order},function(data){
            if(data.status==0){
                layer.msg(data.msg, {icon: 6});
            }else{
                layer.msg(data.msg, {icon: 5});
            }
            
        });
    };
    
    
    function delCate(cate_id){
        layer.confirm('您確定要刪除這個分類嗎？', {
            btn: ['確定','取消'] //按钮
        },
        function(){
            $.post("{{url('admin/category/')}}/"+cate_id,{'_method':'delete','_token':'{{csrf_token()}}'},function(data){
                if(data.status==0){
                    location.href=location.href;
                    layer.msg(data.msg, {icon: 6});
                }else{
                    layer.msg(data.msg, {icon: 5});
            }
            });
        });
    }
    

</script>
@endsection