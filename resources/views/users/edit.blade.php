<!DOCTYPE html>
<html lang="utf-8">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="{{ asset('/common/css/jquery.waiting.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/admin/css/base.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/common/css/admin.css') }}"/>
    <script type="text/javascript" src="{{ asset('/common/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/common/js/jquery.waiting.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/js/base.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/js/admin.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/common/js/jquery.pager.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/common/datePicker/WdatePicker.js') }}"></script>
</head>
<body>
<div class="header">
    <table width="100%">
        <tr>
            <td width="165px">
                <div class="bodyLeft">
                    <div class="logo"></div>
                </div>
            </td>
            <td>
                <div class="bodyRight" style="width:100%">
                    <div class="link">
                        &nbsp;
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>

<div class="input managerInfo">
    {{-- <div class="bar">
        重置密码（如果忘记密码请重置，重置之后密码为：000000）
    </div>
    <form role="form" method="POST" action="{{ url('auth/reset') }}" id="formReset">
        {{ csrf_field() }}
        <table class="inputTable tabContent">
            <tr>
                <th>用户名</th>
                <td>
                    <input id="nameReset" type="text" class="form-control" name="name">
                </td>

            </tr>
        </table>
        <tr>
            <td>
                <button type="button" class="formButton" onclick="doReset()">
                    <i class="fa fa-btn fa-user"></i> 重置
                </button>
            </td>

        </tr>

    </form><br><br> --}}
    <div class="bar">
        个人信息
    </div>
    <table class="inputTable tabContent">
        <tr>
            <th><label for="name" class="col-md-4 control-label">用户名：</label></th>
            <td>{{$user->name}}</td>
        </tr>
        <tr>
            <th><label for="name" class="col-md-4 control-label">所属级别：</label></th>
            <td>{{$user->area_level}}</td>
        </tr>
        <tr>
            <th><label for="name" class="col-md-4 control-label">权限：</label></th>
            <td>
                <span style="font-weight: bold; margin-right: 6px">站址信息管理</span>
                <input type="checkbox" value="site_add"
                       @if($user->site_add == 1) checked="checked" @endif disabled="disabled">站址新增
                <input type="checkbox" value="site_view_basic"
                       @if($user->site_view_basic == 1) checked="checked" @endif disabled="disabled">查看站址基础信息
                <input type="checkbox" value="site_view_advance"
                       @if($user->site_view_advance == 1) checked="checked" @endif disabled="disabled">查看站址价格相关信息
                <input type="checkbox" value="site_modify"
                       @if($user->site_modify == 1) checked="checked" @endif disabled="disabled">站址属性修改
                <input type="checkbox" value="site_delete"
                       @if($user->site_delete == 1) checked="checked" @endif disabled="disabled">站址删除
                <input type="checkbox" value="site_batch_import"
                       @if($user->site_batch_import == 1) checked="checked" @endif disabled="disabled">站址批量导入
                <input type="checkbox" value="site_batch_export"
                       @if($user->site_batch_export == 1) checked="checked" @endif disabled="disabled">站址批量导出
                <span style="font-weight: bold; margin-right: 6px; margin-left: 10px">账单管理</span>
                <input type="checkbox" value="bill_view"
                       @if($user->bill_view == 1) checked="checked" @endif disabled="disabled">查看账单
                <input type="checkbox" value="bill_out"
                       @if($user->bill_out == 1) checked="checked" @endif disabled="disabled">出账
                <span style="font-weight: bold; margin-right: 6px; margin-left: 10px">维护</span>
                <input type="checkbox" value="gnr_manage"
                       @if($user->gnr_manage == 1) checked="checked" @endif disabled="disabled">发电记录管理
                <input type="checkbox" value="site_check_manage"
                       @if($user->site_check_manage == 1) checked="checked" @endif disabled="disabled">上站记录管理
                <input type="checkbox" value="site_shield_manage"
                       @if($user->site_shield_manage == 1) checked="checked" @endif disabled="disabled">屏蔽记录管理
                <input type="checkbox" value="os_reason_manage"
                       @if($user->os_reason_manage == 1) checked="checked" @endif disabled="disabled">退服原因管理
            </td>
        </tr>

    </table>
    <div class="bar">
        修改密码
    </div>

    <form role="form" method="POST" action="{{ url('auth/update') }}" id="formUpdate">
        {{--@if($errors->first())--}}
            {{--<div class="alert alert-danger display-hide" style="display: block;">--}}
                {{--<button class="close" data-close="alert"></button>--}}
                {{--<span>   </span>--}}
            {{--</div>--}}
        {{--@endif--}}
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        <table class="inputTable tabContent">
            <tr>
                <div class="form-group{{ $errors->has('oldpassword') ? ' has-error' : '' }}">
                    <th><label for="oldpassword" class="col-md-4 control-label">原始密码</label></th>
                    <td>
                        <div class="col-md-6">
                            <input id="oldpassword" type="password" class="form-control" name="oldpassword">

                            @if ($errors->has('oldpassword'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('oldpassword') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </td>
                </div>
            </tr>
            <tr>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <th><label for="password" class="col-md-4 control-label">新密码</label></th>
                    <td>
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </td>
                </div>
            </tr>
            <tr>
                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <th>
                        <label for="password-confirm" class="col-md-4 control-label">确认密码</label>
                    </th>
                    <td>
                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation">

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </td>
                </div>
            </tr>

            <tr>
                <td>
                    <div class="form-group" style="float: left;margin-right: 8px">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="button" class="formButton" onclick="doUpdate({{$user->id}})">
                                <i class="fa fa-btn fa-user"></i> 确认
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="button" class="formButton" onclick="history.back()">
                                <i class="fa fa-btn fa-user"></i> 返回
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

    </form>

</div>

</body>
</html>

<script type="text/javascript">
    function doReset() {
        var name = document.getElementById('nameReset');
        var form = document.getElementById('formReset');
        if (name.value == '') {
            alert('请输入用户名！');
            return;
        }
        form.submit();
    }

    function doUpdate(id) {
        var form = document.getElementById('formUpdate');
        var url = "{{url('users')}}" + '/' + id;
//        alert(url);
        form.action = url;
        form.submit();
    }


</script>
