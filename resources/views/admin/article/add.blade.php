@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首頁</a> &raquo; 文章管理
    </div>
    <!--面包屑导航 结束-->

	<!--结果集標題与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>添加文章</h3>
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
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
                <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>全部文章</a>
            </div>
        </div>
    </div>
    <!--结果集標題与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/article')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120">分類：</th>
                        <td>
                            <select name="cate_id">
                                @foreach($data as $d)
                                    <option value="{{$d['cate_id']}}">{{$d['cate_name']}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章標題：</th>
                        <td>
                            <input type="text" class="lg" name="art_title">
                        </td>
                    </tr>
                    <tr>
                        <th>編輯：</th>
                        <td>
                            <input type="text" class="sm" name="art_editor">
                        </td>
                    </tr>
                    <tr>
                        <th>縮略圖：</th>
                        <td>
                            <input type="text" size=50 name="art_thumb">
                            <input id="file_upload" name="file_upload" type="file" multiple="true">
                            <script src="{{asset('resources/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
                            <link rel="stylesheet" type="text/css" href="{{asset('resources/org/uploadify/uploadify.css')}}">
                            <script type="text/javascript">
		                        <?php $timestamp = time();?>
		                        $(function() {
			                        $('#file_upload').uploadify({
				                        'formData'     : {
					                        'timestamp' : '<?php echo $timestamp;?>',
					                        '_token'     : "{{csrf_token()}}"
				                        },
				                        'swf'      : "{{asset('resources/org/uploadify/uploadify.swf')}}",
				                        'uploader' : "{{url('admin/upload')}}"
			                        });
		                        });
	                        </script>
                        </td>
                    </tr>
                    <tr>
                        <th>關鍵詞：</th>
                        <td>
                            <input type="text" class="lg" name="art_tag">
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea name="art_description"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章內容：</th>
                        <td>
                            <script type="text/javascript" charset="utf-8" src="{{secure_asset('resources/org/ueditor/ueditor.config.js')}}"></script>
                            <script type="text/javascript" charset="utf-8" src="{{secure_asset('resources/org/ueditor/ueditor.all.min.js')}}"> </script>
                            <script type="text/javascript" charset="utf-8" src="{{secure_asset('resources/org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
                            <script id="editor" name="art_content" type="text/plain" style="width:860px;height:500px;"></script>
                            <script type="text/javascript">
                            var ue = UE.getEditor('editor');
                            </script>
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
@ensection