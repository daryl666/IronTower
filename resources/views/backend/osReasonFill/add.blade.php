@extends('layouts.app')

@section('header')
    <title>填报退服信息</title>
@endsection

@section('content')
    <div class="container" style="width:100% ">
        <div class="row clearfix">
            <div class="col-md-12 column" style="padding: 0">
                <div class="collapse navbar-collapse" id="example-navbar-collapse">
                    <ul class="nav nav-tabs">
                        <li class="inactive">
                            <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">站址信息维护</a>
                        </li>
                        {{--<li class="inactive">--}}
                        {{--<a href="{{url('backend/servCost')}}">服务费用填报</a>--}}
                        {{--</li>--}}
                        <li class="inactive">
                            <a href="{{url('backend/gnrRec')}}">发电记录填报</a>
                        </li>
                        {{--<li class="inactive">--}}
                        {{--<a href="{{url('backend/otherCost')}}">其他费用填报</a>--}}
                        {{--</li>--}}
                        <li class="dropdown active">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                扣费记录填报 <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">上站记录填报</a></li>
                                <li class="divider"></li>
                                <li><a href="{{url('backend/siteShield')}}">屏蔽记录填报</a></li>
                                <li class="divider"></li>
                                <li><a href="{{url('backend/osReasonFill?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">退服原因填报</a></li>

                            </ul>
                        </li>
                    </ul>
                </div>
                <ul class="breadcrumb" style="margin-bottom: 0;background-color: #F5F5F5">
                    <li>
                        <a href="#">Home</a>
                    </li>
                    <li>
                        <a href="#">Library</a>
                    </li>
                    <li class="active">
                        Data
                    </li>
                </ul>
            </div>
        </div>

    </div>

    <body class="input managerInfo">
    <div class="bar">
        <div style="float:left;">
            请填报退服详细信息
        </div>

    </div>
    <div id="validateErrorContainer" class="validateErrorContainer">

    </div>

    <form id="listForm" method="POST" action="{{url('backend/siteCheck/handle')}}" style="display: inline;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <table class="inputTable tabContent">
            <tr>
                <th>地市</th>
                <td>
                    @if(Auth::user()->area_level == '湖北省' || Auth::user()->area_level == 'admin')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='武汉') selected="selected"
                                    @endif value="武汉">武汉
                            </option>
                            <option @if(isset($filter['region']) && $filter['region']=='黄石') selected="selected"
                                    @endif value="黄石">黄石
                            </option>
                            <option @if(isset($filter['region']) && $filter['region']=='十堰') selected="selected"
                                    @endif value="十堰">十堰
                            </option>
                            <option @if(isset($filter['region']) && $filter['region']=='宜昌') selected="selected"
                                    @endif value="宜昌">宜昌
                            </option>
                            <option @if(isset($filter['region']) && $filter['region']=='襄阳') selected="selected"
                                    @endif value="襄阳">襄阳
                            </option>
                            <option @if(isset($filter['region']) && $filter['region']=='鄂州') selected="selected"
                                    @endif value="鄂州">鄂州
                            </option>
                            <option @if(isset($filter['region']) && $filter['region']=='荆门') selected="selected"
                                    @endif value="荆门">荆门
                            </option>
                            <option @if(isset($filter['region']) && $filter['region']=='孝感') selected="selected"
                                    @endif value="孝感">孝感
                            </option>
                            <option @if(isset($filter['region']) && $filter['region']=='荆州') selected="selected"
                                    @endif value="荆州">荆州
                            </option>
                            <option @if(isset($filter['region']) && $filter['region']=='黄冈') selected="selected"
                                    @endif value="黄冈">黄冈
                            </option>
                            <option @if(isset($filter['region']) && $filter['region']=='咸宁') selected="selected"
                                    @endif value="咸宁">咸宁
                            </option>
                            <option @if(isset($filter['region']) && $filter['region']=='随州') selected="selected"
                                    @endif value="随州">随州
                            </option>
                            <option @if(isset($filter['region']) && $filter['region']=='恩施') selected="selected"
                                    @endif value="恩施">恩施
                            </option>
                            <option @if(isset($filter['region']) && $filter['region']=='仙桃') selected="selected"
                                    @endif value="仙桃">仙桃
                            </option>
                            <option @if(isset($filter['region']) && $filter['region']=='潜江') selected="selected"
                                    @endif value="潜江">潜江
                            </option>
                            <option @if(isset($filter['region']) && $filter['region']=='天门') selected="selected"
                                    @endif value="天门">天门
                            </option>
                            <option @if(isset($filter['region']) && $filter['region']=='林区') selected="selected"
                                    @endif value="林区">林区
                            </option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '武汉')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='武汉') selected="selected"
                                    @endif value="武汉">武汉
                            </option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '黄石')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='黄石') selected="selected"
                                    @endif value="黄石">黄石
                            </option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '十堰')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='十堰') selected="selected"
                                    @endif value="十堰">十堰
                            </option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '宜昌')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='宜昌') selected="selected"
                                    @endif value="宜昌">宜昌
                            </option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '襄阳')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='襄阳') selected="selected"
                                    @endif value="襄阳">襄阳
                            </option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '鄂州')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='鄂州') selected="selected"
                                    @endif value="鄂州">鄂州
                            </option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '荆门')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='荆门') selected="selected"
                                    @endif value="荆门">荆门
                            </option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '孝感')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='孝感') selected="selected"
                                    @endif value="孝感">孝感
                            </option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '荆州')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='荆州') selected="selected"
                                    @endif value="荆州">荆州
                            </option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '黄冈')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='黄冈') selected="selected"
                                    @endif value="黄冈">黄冈
                            </option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '咸宁')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='咸宁') selected="selected"
                                    @endif value="咸宁">咸宁
                            </option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '随州')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='随州') selected="selected"
                                    @endif value="随州">随州
                            </option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '恩施')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='恩施') selected="selected"
                                    @endif value="恩施">恩施
                            </option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '仙桃')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='仙桃') selected="selected"
                                    @endif value="仙桃">仙桃
                            </option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '潜江')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='潜江') selected="selected"
                                    @endif value="潜江">潜江
                            </option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '天门')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='天门') selected="selected"
                                    @endif value="天门">天门
                            </option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '林区')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='林区') selected="selected"
                                    @endif value="林区">林区
                            </option>
                        </select>
                    @endif
                </td>
            </tr>
            <tr>
                <th>基站编号</th>
                <td>
                    <input type="text" name="stationCode" value="s1" readonly>
                </td>
            </tr>
            <tr>
                <th>基站名称</th>
                <td>
                    <input type="text" name="stationName" value="XXX" readonly>
                </td>
            </tr>
            <tr>
                <th>基站等级</th>
                <td>
                    <input type="text" name="stationLevel" value="A" readonly>
                </td>
            </tr>
            <tr>
                <th>原始退服发生时间</th>
                <td>
                    <input type="text" name="oriOutofservStartTime" value="2016-11-1 12:20:36" readonly>
                </td>
            </tr>
            <tr>
                <th>原始退服消除时间</th>
                <td>
                    <input type="text" name="oriOutofservEndTime" value="2016-11-1 16:20:36" readonly>
                </td>
            </tr>
            <tr>
                <th>集团处理后退服发生时间</th>
                <td>
                    <input type="text" name="procOutofservStartTime" value="2016-11-1 12:20:36" readonly>
                </td>
            </tr>
            <tr>
                <th>集团处理后退服消除时间</th>
                <td>
                    <input type="text" name="procOutofservEndTime" value="2016-11-1 16:20:36" readonly>
                </td>
            </tr>
            <tr>
                <th>本次退服时间（分）</th>
                <td>
                    <input type="text" name="outofservTime" value="240" readonly>
                </td>
            </tr>
            <tr>
                <th>退服原因</th>
                <td>
                    <select name="outofservReason">
                        <option>停电</option>
                        <option>电源设备</option>
                        <option>传输线路</option>
                        <option>传输设备</option>
                        <option>物业</option>
                        <option>核心网</option>
                        <option>高温</option>
                        <option>其它</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>退服详情</th>
                <td>
                    <input type="text" name="outofservDetail">
                </td>
            </tr>
            <tr>
                <th>责任单位</th>
                <td>
                    <select name="respUnit">
                        <option>铁塔</option>
                        <option>电信</option>

                    </select>
                </td>
            </tr>

        </table>
        <input class="formButton" type="button" value="提交" onclick="doAdd()">
    </form>
    {{--<form action="" method="get" style="display:inline;"--}}
    {{--id="delForm">--}}
    {{--{{ method_field('DELETE') }}--}}
    {{--{{ csrf_field() }}--}}
    {{--<input type="hidden" value="{{$region}}" name="region">--}}
    {{--<input type="button" class="formButton" value="删除" onclick="doDel()">--}}
    {{--</form>--}}
    <input type="button" class="formButton" value="返回" onclick="doBack()">
    </body>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {
            var menu_business = document.getElementById('menu_business');
            menu_business.className = "current";
        });

        function doBack() {
            var listForm = document.getElementById('listForm');
            listForm.action = "{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}";
            listForm.submit();
        }

        function doSiteCheckPage() {
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}";
            listForm.submit();
        }

        function doShieldPage() {
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/siteShield')}}";
            listForm.submit();
        }

        function doTysysPage() {
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/osReasonFill?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}";
            listForm.submit();
        }




    </script>
@endsection







