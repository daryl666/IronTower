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
    <div class="bar">
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

    </form><br><br>
    <div class="bar">
        修改密码
    </div>

    <form role="form" method="POST" action="{{ url('auth/update') }}" id="formUpdate">
        @if($errors->first())
            <div class="alert alert-danger display-hide" style="display: block;">
                <button class="close" data-close="alert"></button>
                <span>   </span>
            </div>
        @endif
        {{ csrf_field() }}
        <table class="inputTable tabContent">
            <tr>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <th><label for="name" class="col-md-4 control-label">用户名</label></th>
                    <td>
                        <div class="col-md-6">
                            <input id="nameUpdate" type="text" class="form-control" name="name" value="{{ old('name') }}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </td>


                </div>
            </tr>
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
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="button" class="formButton" onclick="doUpdate()">
                                <i class="fa fa-btn fa-user"></i> 确认
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
    function doReset(){
        var name = document.getElementById('nameReset');
        var form = document.getElementById('formReset');
        if(name.value == ''){
            alert('请输入用户名！');
            return;
        }
        form.submit();
    }

    function doUpdate(){
        var name = document.getElementById('nameUpdate');
        var form = document.getElementById('formUpdate');
        if(name.value == ''){
            alert('请输入用户名！');
            return;
        }
        form.submit();
    }


</script>
