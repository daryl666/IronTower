@extends('layouts.app')

@section('header')
    <title>新增发电记录</title>
@endsection

@section('script_header')
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function (event) {
            var backBtn = document.getElementById("backBtn");
            backBtn.addEventListener('click', function () {
                var listForm = document.getElementById("listForm");
                listForm.action = "{{url('backend/gnrRec/back')}}";

            });
        });
    </script>
@endsection

@section('content')
    <div class="container" style="width:100% ">
        <div class="row clearfix">
            <div class="col-md-12 column" style="padding: 0">
                {{--<div class="collapse navbar-collapse" id="example-navbar-collapse" style="padding: 0">--}}
                <ul class="nav nav-tabs" style="font-size: 13px">
                    <li class="inactive">
                        <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">站址信息管理</a>
                    </li>
                    <li class="active">
                        <a href="{{url('backend/gnrRec?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">发电记录管理</a>
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">上站记录管理</a>
                    </li>
                    <li class="inactive">
                        @if(Auth::user()->area_level == '湖北省')                             <a href="{{url('backend/siteShield/checkShieldPage?region=').Auth::user()->area_level.'&checkStatus=2&reqType=0&beginDate=&endDate='}}">屏蔽记录管理</a>@endif                         @if(Auth::user()->area_level != '湖北省')                             <a href="{{url('backend/siteShield/addShieldPage')}}">屏蔽记录管理</a>@endif
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/osReasonFill?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">退服原因管理</a>
                    </li>
                    {{--<li class="dropdown inactiive">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                    {{--扣费记录填报 <b class="caret"></b>--}}
                    {{--</a>--}}
                    {{--<ul class="dropdown-menu" style="font-size: 12px;">--}}


                    {{--</ul>--}}
                    {{--</li>--}}
                </ul>
                {{--</div>--}}
                <ul class="nav-tabs-2">
                    <li class="inactive">
                        <a href="{{url('backend/gnrRec?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">发电记录查询</a>
                    </li>
                    <li class="active" style="float: none">
                        <a href="{{url('backend/gnrRec/addPage')}}">发电申请填报</a>
                    </li>

                </ul>
                <ul class="breadcrumb" style="margin-bottom: 0;background-color: #F5F5F5">
                    当前位置：
                    <li>
                        <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">业务管理</a>
                    </li>
                    <li>
                        <a href="{{url('backend/gnrRec?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">发电记录管理</a>
                    </li>
                    <li class="active">
                        <a href="#">发电申请填报</a>
                    </li>
                </ul>


            </div>
        </div>

    </div>

    <body class="input managerInfo">
    {{--<div class="list">--}}
        {{--<div>--}}
            {{--<div class="bar">--}}
                {{--<label style="">站址信息</label>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<table class="listTable" style="white-space:nowrap;">--}}
            {{--<tr>--}}
                {{--<th>--}}
                    {{--<a href="#" class="sort" name="" hidefocus>地市</a>--}}
                {{--</th>--}}
                {{--<th>--}}
                    {{--<a href="#" class="sort" name="" hidefocus>站址编码</a>--}}
                {{--</th>--}}
                {{--<th>--}}
                    {{--<a href="#" class="sort" name="" hidefocus>详细地址</a>--}}
                {{--</th>--}}
                {{--<th>--}}
                    {{--<a href="#" class="sort" name="" hidefocus>计价规则</a>--}}
                {{--</th>--}}
                {{--<th>--}}
                    {{--<a href="#" class="sort" name="" hidefocus>发电总时长</a>--}}
                {{--</th>--}}
                {{--<th>--}}
                    {{--<a href="#" class="sort" name="" hidefocus>发电次数</a>--}}
                {{--</th>--}}
                {{--<th>--}}
                    {{--<a href="#" class="sort" name="" hidefocus>发电总费用（元）（不含税）</a>--}}
                {{--</th>--}}
                {{--<th>--}}
                    {{--<a href="#" class="sort" name="" hidefocus>发电总费用（元）（含税）</a>--}}
                {{--</th>--}}
                {{--<th>--}}
                    {{--<a href="#" class="sort" name="" hidefocus>最近一次发电时间</a>--}}
                {{--</th>--}}

            {{--</tr>--}}
            {{--@if(isset($siteInfos))--}}
                {{--@foreach($siteInfos as $infoSite)--}}
                    {{--<tr>--}}
                        {{--<td>{{$infoSite->region_name}}</td>--}}
                        {{--<td>{{$infoSite->site_code}}</td>--}}
                        {{--<td>{{$infoSite->site_address}}</td>--}}
                        {{--<td>--}}
                            {{--@if($infoSite->land_form == '山区') 五小时以内收费270元，超出部分每小时20元 @endif--}}
                            {{--@if($infoSite->land_form == '平原') 五小时以内收费220元，超出部分每小时20元 @endif--}}
                        {{--</td>--}}
                        {{--<td>@if(isset($infoSite->gnr_total_len)) {{$infoSite->gnr_total_len}}@endif</td>--}}
                        {{--<td>@if(isset($infoSite->gnr_num)) {{$infoSite->gnr_num}}@endif</td>--}}
                        {{--<td>@if(isset($infoSite->gnr_total_fee)) {{$infoSite->gnr_total_fee}}@endif</td>--}}
                        {{--<td>@if(isset($infoSite->gnr_total_fee)) {{$infoSite->gnr_total_fee_taxed}}@endif</td>--}}
                        {{--<td>--}}
                            {{--@if(isset($infoSite->last_gnr_time)) {{$infoSite->last_gnr_time}} @endif--}}
                        {{--</td>--}}

                    {{--</tr>--}}
                {{--@endforeach--}}
            {{--@endif--}}
        {{--</table>--}}
    {{--</div>--}}
    <form id="listForm" method="post" action="{{url('backend/gnrRec/add')}}" enctype="multipart/form-data">
        {{--<input type="hidden" name="id" value="${id}"/>--}}
        {{--<input type="hidden" name="siteChoose" value="{{$sitechoose}}">--}}
        {{--<input type="hidden" name="siteCode" value="{{$siteInfos[0]->site_code}}">--}}
        {{--<input type="hidden" name="region" value="{{$siteInfos[0]->region_name}}">--}}
        {{--<input type="hidden" name="lastGnrTime" value="{{$siteInfos[0]->last_gnr_time}}">--}}
        {{--{!! csrf_field() !!}--}}
        {{--<div class="input managerInfo">--}}
        {{--<div class="bar">--}}
        {{--批量导入--}}
        {{--</div>--}}
        {{--<table class="inputTable tabContent">--}}
        {{--<tr>--}}

        {{--<td>--}}
        {{--<input type="file" name="gnrRecFile" style="width: 170px" id="gnrRecFile">--}}
        {{--<input type="button" class="formButton" value="导入" onclick="doImport()"/>--}}
        {{--</td>--}}
        {{--</tr>--}}
        {{--</table>--}}
        {{--</div>--}}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="body">
            <div class="bar">
                请输入发电申请信息
            </div>
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
                    <th>基站编号：</th>
                    <td>
                        <input type="text" name="stationCode" id="stationCode">
                    </td>
                </tr>
                <tr>
                    <th>
                        发电申请时间:
                    </th>
                    <td>

                        <input type="text" name="gnrReqTime" style="width:130px;padding-left:5px"
                               readonly="true" value="{{date('Y-m-d H:i:s', time())}}"
                               onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"/>


                    </td>
                </tr>
                <tr>
                    <th>
                        发电申请发起方:
                    </th>
                    <td>
                        <select name="gnrRaiseSide">
                            <option>铁塔</option>
                            <option>电信</option>
                        </select>
                    </td>
                </tr>


            </table>
            <input type="button" value="提交" class="formButton" onclick="doAdd()">
            <input type="button" value="返回" class="formButton" onclick="doBack()">


        </div>
    </form>
    </body>
@endsection

@section('script_footer')
    <script type="text/javascript" src="{{ URL::asset('common/datePicker/WdatePicker.js')}}"></script>
    <script type="text/javascript">
        $().ready(function () {
            var menu_business = document.getElementById('menu_business');
            menu_business.className = "current";
        });

        function doAdd() {
            var stationCode = $('#stationCode').val();
            if (stationCode == ''){
                alert('请输入基站编号！');
                return;
            }
            if (confirm('确认提交吗？')) {
                var listForm = document.getElementById("listForm");
                listForm.action = "{{url('backend/gnrRec/add')}}";
                listForm.submit();
            }


        }

        function doBack() {
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/gnrRec')}}";
            listForm.submit();
        }

        function doImport() {
            var gnrRecFile = document.getElementById('gnrRecFile');
            if (gnrRecFile.value == "") {
                alert('请选择需要导入的文件');
                return;
            }
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/gnrRec/import')}}";
            listForm.submit();
        }


    </script>
@endsection