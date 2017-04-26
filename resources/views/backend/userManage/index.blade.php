@extends('layouts.app')

@section('header')
    <title>用户管理</title>
@endsection

@section('content')
    <div class="container" style="width:100% ">
        <div class="row clearfix">
            <div class="col-md-12 column" style="padding: 0">
                <div class="collapse navbar-collapse" id="example-navbar-collapse">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="{{url('backend/userManage')}}">用户管理</a>
                        </li>
                        <li class="inactive">
                            <a href="{{url('backend/eventLog')}}">日志管理</a>
                        </li>
                        <li class="inactive">
                            <a href="{{url('backend/rentStd')}}">计费标准管理</a>
                        </li>

                    </ul>
                    <ul class="breadcrumb" style="margin-bottom: 0;background-color: #F5F5F5">
                        当前位置：
                        <li>
                            <a href="{{url('backend/userManage')}}">系统管理</a>
                        </li>
                        <li class="active">
                            <a href="#">用户管理</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

    </div>
    <div class="list">
        <div class="body">
            <form id="listForm" method="post" action="{{url('backend/userManage/update')}}"
                  enctype="multipart/form-data">
                {!! csrf_field() !!}
                <table class="listTable" style="white-space:nowrap;font-size:12px;">
                    <tr>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>用户级别</a>
                        </th>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>用户名</a>
                        </th>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>权限</a>
                        </th>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>状态</a>
                        </th>
                        <th class="scanStopTime">
                            <a href="#" class="sort" name="" hidefocus>操作</a>
                        </th>
                    </tr>
                    @if(isset($users))
                        @foreach($users as $user)
                            @if($user->area_level != 'admin')
                                <tr>
                                    <td>{{$user->area_level}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>
                                       <input type="checkbox" name="permission_{{$user->id}}[]" value="view_basic"
                                               @if($user->view_basic == 1) checked="checked"@endif>查看基础信息
                                               <input type="checkbox" name="permission_{{$user->id}}[]" value="view_advance"
                                               @if($user->view_advance == 1) checked="checked"@endif>查看价格相关信息

                                        <input type="checkbox" name="permission_{{$user->id}}[]" value="single_update"
                                               @if($user->single_update == 1) checked="checked"@endif>逐个修改
                                        <input type="checkbox" name="permission_{{$user->id}}[]" value="delete"
                                               @if($user->delete == 1) checked="checked"@endif>删除
                                        <input type="checkbox" name="permission_{{$user->id}}[]" value="bulk_import"
                                               @if($user->bulk_import == 1) checked="checked"@endif>批量导入
                                        <input type="checkbox" name="permission_{{$user->id}}[]" value="bulk_export"
                                               @if($user->bulk_export == 1) checked="checked"@endif>批量导出
                                        <input type="checkbox" name="permission_{{$user->id}}[]" value="bulk_update"
                                               @if($user->bulk_update == 1) checked="checked"@endif>批量修改
                                        <input type="checkbox" name="permission_{{$user->id}}[]" value="account_out"
                                               @if($user->account_out == 1) checked="checked"@endif>出账
                                    </td>
                                    <td>
                                        @if($user->is_verified == 1)已审核@endif
                                        @if($user->is_verified == 0)待审核@endif
                                    </td>
                                    <td>
                                        @if($user->is_verified == 1)
                                            <button class="buttonNextStep" onclick="doUpdate({{$user->id}})">修改权限
                                            </button>
                                        @endif
                                        @if($user->is_verified == 0)
                                            <button class="buttonNextStep" onclick="doVerify({{$user->id}})">审核通过
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif


                </table>
            </form>
        </div>
    </div>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {

            $('#menu_sys').addClass("current");
        });

        function doVerify(id) {
            var listForm = document.getElementById('listForm');
            var url = "{{url('backend/userManage/verify')}}" + '/' + id;
            listForm.action = url;
            listForm.submit();
        }
        function doUpdate(id) {
            var listForm = document.getElementById('listForm');
            var url = "{{url('backend/userManage/update')}}" + '/' + id;
            listForm.action = url;
            listForm.submit();
        }

    </script>
@endsection







