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
            注册
        </div>
                    <form role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}
                        <table class="inputTable tabContent">
                            <tr>

                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <th><label for="name" class="col-md-4 control-label">用户名</label></th>
                                    <td>
                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

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
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <th><label for="password" class="col-md-4 control-label">密码</label></th>
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
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

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
                                <div>
                                    <th>
                                        <label for="password-confirm" class="col-md-4 control-label">所属级别</label>
                                    </th>
                                    <td>
                                        <div>
                                            <select name="area_level">
                                                <option>湖北省</option>
                                                <option>武汉</option>
                                                <option>黄石</option>
                                                <option>十堰</option>
                                                <option>宜昌</option>
                                                <option>襄阳</option>
                                                <option>鄂州</option>
                                                <option>荆门</option>
                                                <option>孝感</option>
                                                <option>荆州</option>
                                                <option>黄冈</option>
                                                <option>咸宁</option>
                                                <option>随州</option>
                                                <option>恩施</option>
                                                <option>仙桃</option>
                                                <option>潜江</option>
                                                <option>天门</option>
                                                <option>林区</option>
                                            </select>

                                        </div>
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <th>
                                    <label for="password-confirm" class="col-md-4 control-label">权限</label>
                                </th>
                                <td>
                                    <input type="checkbox" name="permission[]" value="view">查看
                                    <input type="checkbox" name="permission[]" value="delete">删除
                                    <input type="checkbox" name="permission[]" value="bulk_import">批量导入
                                    <input type="checkbox" name="permission[]" value="bulk_export">批量导出
                                    <input type="checkbox" name="permission[]" value="bulk_update">批量修改
                                    <input type="checkbox" name="permission[]" value="single_update">逐个修改
                                    <input type="checkbox" name="permission[]" value="account_out">出账
                                </td>
                            </tr>
                            <tr>
                                <td><div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="formButton">
                                                <i class="fa fa-btn fa-user"></i> 注册
                                            </button>
                                        </div>
                                    </div></td>
                            </tr>

                    </form>

    </div>

</body>
</html>
