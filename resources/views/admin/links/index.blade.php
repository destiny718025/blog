@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首頁</a> &raquo; 友情連結管理
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果頁面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>友情連接列表</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>新增友情連接</a>
                    <a href="{{url('admin/links')}}"><i class="fa fa-recycle"></i>全部友情連接</a>
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
                        <th>友情連結名稱</th>
                        <th>友情連結標題</th>
                        <th>友情連結網址</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc">
                                <input type="text" onchange='changeOrder(this,{{$v['link_id']}})' value="{{$v['link_order']}}">
                            </td>
                            <td class="tc">{{$v['link_id']}}</td>
                            <td>
                                <a href="#">{{$v['link_name']}}</a>
                            </td>
                            <td>{{$v['link_title']}}</td>
                            <td>{{$v['link_url']}}</td>
                            <td>
                                <a href="{{url('admin/links/'.$v['link_id'].'/edit')}}">修改</a>
                                <a href="javascript:;" onclick="delLink({{$v['link_id']}})">刪除</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
    <!--搜索结果頁面 列表 结束-->
</body>
<script>
    function changeOrder(obj,link_id){
        var link_order=$(obj).val();
        $.post("{{url('admin/links/changeorder')}}",{'_token':'{{csrf_token()}}','link_id':link_id,'link_order':link_order},function(data){
            if(data.status==0){
                layer.msg(data.msg, {icon: 6});
            }else{
                layer.msg(data.msg, {icon: 5});
            }
            
        });
    };
    
    
    function delLink(link_id){
        layer.confirm('您確定要刪除這個分類嗎？', {
            btn: ['確定','取消'] //按钮
        },
        function(){
            $.post("{{url('admin/links')}}/"+link_id,{'_method':'delete','_token':'{{csrf_token()}}'},function(data){
                if(data.status==0){
                    location.href=location.href;
                    layer.msg(data.msg, {icon: 6});
                }else{
                    layer.msg(data.msg, {icon: 5});
            }
            });
        },
        function(){
            
        });
    }
    

</script>
@endsection