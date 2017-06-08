<!DOCTYPE html>
<html lang="utf-8">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>铁塔综合服务管理平台</title>
    <link href="{{ asset('/admin/css/login.css') }}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ asset('/common/js/jquery.js') }}"></script>
    <script type="text/javascript">
        $().ready(function () {

            var $loginForm = $("#loginForm");
            var $username = $("#username");
            var $password = $("#password");

            // 提交表单验证,记住登录用户名
            $loginForm.submit(function () {
                if ($username.val() == "") {
                    alert("请输入您的用户名!");
                    return false;
                }
                if ($password.val() == "") {
                    alert("请输入您的密码!");
                    return false;
                }
            });

            $("#submitBtn").click(function () {
                $loginForm.submit();
            });

            // 回车即提交
            document.onkeydown = function (e) {
                var theEvent = window.event || e;
                var code = theEvent.keyCode || theEvent.which;
                if (code == 13) {
                    $("#submitBtn").click();
                }
            };


        });

    </script>
</head>
<body>
<script type="text/javascript">

    // 登录页面若在框架内，则跳出框架
    if (self != top) {
        top.location = self.location;
    };

</script>
<form id="loginForm" action="{{ url('login') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <img class="bgimg" src="{{ asset('/admin/images/bg.jpg') }}" width="100%"/>
    <div class="logincontent animation" id="logincontent">
        <div class="top">
            <div style="color: white; font-size: 25px; padding-top: 25px; margin-left: auto; margin-right: auto; width: 300px; text-align: center">
                铁塔综合服务管理平台
            </div>
        </div>
        <div class="con">
            <span class="font">用户名：</span>
            <span class="input"><input id="name" name="name" placeholder="请输入用户名" type="text"
                                       value="{{ old('name') }}"/></span><br/>
            <span class="font">密&nbsp;&nbsp;&nbsp;&nbsp;码：</span>
            <span class="input"><input id="password" name="password" placeholder="请输入密码" type="password"/></span><br/>
            <span class="font">记&nbsp;&nbsp;&nbsp;&nbsp;住</span>
            <span class="input"><input type="checkbox" name="remember"></span>
            <br/>
            <span class="font">
                @if ($errors->has('name'))
                    <strong>{{ $errors->first('name') }}</strong>
                @endif
                @if ($errors->has('password'))
                    <strong>{{ $errors->first('password') }}</strong>
                @endif
            </span>
        </div>
        <div class="bottombtn">
            <div class="brnlogin" id="submitBtn">登录</div>
            <br>
            <div class="brnlogin" id="registerBtn" onclick="doRegister()">注册</div>
            {{--<br>--}}
            {{--<div class="brnlogin" id="registerBtn" onclick="doReset()">修改密码</div>--}}
        </div>
    </div>
    <div class="copy">© 铁塔综合服务管理平台  版权所有</div>
</form>
</body>

<script type="text/javascript">
    function doRegister() {
        var listForm = document.getElementById('loginForm');
        {{--listForm.action = "{{url('auth/register')}}";--}}
        listForm.action = "{{url('users/create')}}";
        listForm.method = "get";
        listForm.submit();
    }
    function doReset() {
        var listForm = document.getElementById('loginForm');
        listForm.action = "{{url('auth/reset')}}";
        listForm.method = "get";
        listForm.submit();
    }
</script>

</html>
