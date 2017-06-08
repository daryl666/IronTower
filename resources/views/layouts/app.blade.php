<!DOCTYPE html>
<html lang="utf-8">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('title')
    <link rel="stylesheet" type="text/css" href="{{ asset('/common/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/common/css/jquery.waiting.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/admin/css/base.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/common/css/admin.css') }}"/>
    <script src="{{ asset('/common/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/common/js/bootstrap.min.js') }}"></script>
    {{--<script src="{{ asset('/common/js/jquery.fixedheadertable.min.js') }}"></script>--}}
    {{--<script src="{{ asset('/common/js/jquery.fixedheadertable.js') }}"></script>--}}
    <script type="text/javascript" src="{{ asset('/common/js/jquery.waiting.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/js/base.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/js/admin.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/common/js/jquery.pager.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/common/datePicker/WdatePicker.js') }}"></script>
    <script type="text/javascript">
    $().ready(function () {
            // 显示时间
            showTime();
        })

    function showTime() {
            var date = new Date(); //日期对象
            var now = "";
            now = date.getFullYear() + "/";
            now = now + (date.getMonth() + 1) + "/";
            now = now + date.getDate() + "  ";
            now = now + date.getHours() + ":";
            now = now + date.getMinutes() + ":";
            now = now + date.getSeconds();
            var nowTime = document.getElementById('nowTime');
            nowTime.innerHTML = now;
//            $("#nowTime").html(now);
setTimeout("showTime()", 1000);
}
</script>

@yield('script_header')
</head>
<body>
    @if (session('status_update'))
    <div class="alert alert-success" style="">
        <script language=javascript>
        alert('修改成功！');
        <?php ?>
    </script>

</div>
@endif


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
                    <table width="100%" style="white-space:nowrap;">
                        <tr>
                            <td>
                                <div id="menu" class="menu">
                                    <ul style="margin-left:10px">
                                        <li class="menuItem" id="menu_index">
                                            <a href="{{url('backend/')}}">首页</a>
                                        </li>
                                        <li class="menuItem" id="menu_business">
                                            <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">业务管理</a>
                                        </li>

                                        <li class="menuItem" id="menu_bill">
                                            <a href="{{url('backend/servBill')}}">账单管理</a>
                                        </li>
                                        @if(Auth::user()->area_level == '湖北省')
                                        <li class="menuItem" id="menu_sys">
                                            <a href="{{url('backend/userManage')}}">系统管理</a>
                                        </li>@endif
                                        {{--<li class="menuItem" id="menu_exce">--}}
                                        {{--<a href="{{url('backend/excepHandle')}}">异常处理</a>--}}
                                        {{--</li>--}}
                                    </ul>
                                </div>
                            </td>
                            <td style="text-align:right">
                                <div class="info" style="margin-right:10px;font-size: 12px">
                                    <span class="welcome" style="color:#CD3700">
                                        账号:&nbsp;<a href="{{url('users') . '/' .Auth::user()->id . '/edit'}}">{{ Auth::user()->name }}</a>&nbsp;
                                        地区:&nbsp;{{Auth::user()->area_level}}&nbsp;
                                        时间:&nbsp;<span id="nowTime"></span>
                                    </span>
                                    <a class="logout" href="{{ url('logout') }}" target="_top">退出</a>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</div>


{{--<div style="float: left;">--}}
{{--<div id="main1" onClick="document.all.child1.style.display=(document.all.child1.style.display =='none')?'':'none'">--}}
{{--+--}}
{{--业务管理--}}
{{--</div>--}}
{{--<div id="child1" style="display:none">--}}
{{--<ul>--}}
{{--<li><a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}" id="siteInfo">站址信息维护</a></li>--}}
{{--<li><a href="{{url('backend/servCost')}}" id="servCost">服务费用填报</a></li>--}}
{{--<li><a href="{{url('backend/gnrRec')}}" id="gnrRec">发电记录填报</a></li>--}}
{{--<li><a href="{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}" id="dedRec">扣费记录填报</a></li>--}}
{{--<li><a href="{{url('backend/otherCost')}}" id="otherCost">其他费用填报</a></li>--}}
{{--</ul>--}}
{{--</div>--}}
{{--<div id="main2" onClick="document.all.child2.style.display=(document.all.child2.style.display =='none')?'':'none'">--}}
{{--+--}}
{{--账单管理--}}
{{--</div>--}}
{{--<div id="child2" style="display:none">--}}
{{--<ul>--}}
{{--<li><a href="{{url('backend/servBill')}}" id="servBill">服务账单管理</a></li>--}}
{{--</ul>--}}
{{--</div>--}}
{{--<div id="main3" onClick="document.all.child3.style.display=(document.all.child3.style.display =='none')?'':'none'">--}}
{{--+--}}
{{--系统管理--}}
{{--</div>--}}
{{--<div id="child3" style="display:none">--}}
{{--<ul>--}}
{{--<li><a href="{{url('backend/rentStd')}}" id="rentStd">月租标准管理</a></li>--}}
{{--@if(Auth::user()->area_level == 'admin')--}}
{{--<li><a href="{{url('backend/userManage')}}" id="userManege">用户管理</a></li>--}}
{{--@endif--}}

{{--</ul>--}}
{{--</div>--}}
{{--</div>--}}

<div style="float: left;width: 100%">
    @yield('content')
</div>

@yield('script_footer')
</body>
</html>