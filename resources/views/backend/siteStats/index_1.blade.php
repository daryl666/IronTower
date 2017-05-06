@extends('layouts.app')

@section('header')
    <title>站址信息列表</title>
@endsection

@section('script_header')
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function (event) {
            var addBtn = document.getElementById("addBtn");
            var region = $('#region').val();
            addBtn.addEventListener('click', function () {
                var listForm = document.getElementById("listForm");
                var url = "{{url('backend/siteInfo/addNewPage')}}" + '/' + region;
                listForm.action = url;

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
                    <li class="active">
                        <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">站址信息管理</a>
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/gnrRec?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">发电记录管理</a>
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">上站记录管理</a>
                    </li>
                    <li class="inactive">
                        @if(Auth::user()->area_level == '湖北省')                             <a
                                href="{{url('backend/siteShield/checkShieldPage?region=').Auth::user()->area_level.'&checkStatus=2&reqType=0&beginDate=&endDate='}}">屏蔽记录管理</a>@endif                         @if(Auth::user()->area_level != '湖北省')
                            <a href="{{url('backend/siteShield/addShieldPage')}}">屏蔽记录管理</a>@endif
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
                        <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">站址信息查询</a>
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/siteInfo/addNewPage')}}">站址信息新增</a>
                    </li>
                    <li class="inactive" style="float: none">
                        <a href="{{url('backend/excepHandle/importSiteInfo')}}">导入异常处理</a>
                    </li>
                    <li class="active" style="float: none">
                        <a href="{{url('backend/siteStats/')}}">站址统计</a>
                    </li>
                    {{--<li class="dropdown inactiive">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                    {{--扣费记录填报 <b class="caret"></b>--}}
                    {{--</a>--}}
                    {{--<ul class="dropdown-menu" style="font-size: 12px;">--}}


                    {{--</ul>--}}
                    {{--</li>--}}
                </ul>
                <ul class="breadcrumb" style="margin-bottom: 0;background-color: #F5F5F5">
                    当前位置：
                    <li>
                        <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">业务管理</a>
                    </li>
                    <li>
                        <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">站址信息管理</a>
                    </li>
                    <li class="active">
                        <a href="#">站址统计</a>
                    </li>
                </ul>


            </div>
        </div>

    </div>




    <div class="list">
        <div class="body">
            <form id="listForm" method="post" action="{{url('backend/siteInfo/')}}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="siteStats" @if(isset($filter)) value="1" @endif>
                <div class="listBar">
                    <td>
                        导入铁塔详单
                    </td>
                    <td>
                        <input id="billDetailFile" name="billDetailFile" style="width: 170px" type="file">
                        <input class="formButton" onclick="doImport()" type="button" value="导入">
                    </td>
                    <td>
                        请选择地市和起止时间查看站址统计信息：
                    </td>
                    <td>
                        起始月份
                        <input type="text" id="beginDate" name="beginDate" style="width:100px;padding-left:5px"
                               readonly="true"
                               @if(isset($filter['beginDate'])) value="{{$filter['beginDate']}}" @endif
                               onclick="WdatePicker({dateFmt:'yyyy-MM'})"/>
                    </td>
                    <td>
                        终止月份
                        <input type="text" id="endDate" name="endDate" style="width:100px;padding-left:5px"
                               readonly="true"
                               @if(isset($filter['endDate'])) value="{{$filter['endDate']}}" @endif
                               onclick="WdatePicker({dateFmt:'yyyy-MM'})"/>
                    </td>
                    <td>
                        @if(Auth::user()->area_level == '湖北省' || Auth::user()->area_level == 'admin')
                            <select name="region" id="region">
                                <option @if(isset($filter['region']) && $filter['region']=='湖北省') selected="selected"
                                        @endif value="湖北省">湖北省
                                </option>
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
                                <option @if(isset($filter['region']) && $filter['region'] =='鄂州') selected="selected"
                                        @endif value="鄂州">鄂州
                                </option>
                                <option @if(isset($filter['region']) && $filter['region'] =='荆门') selected="selected"
                                        @endif value="荆门">荆门
                                </option>
                                <option @if(isset($filter['region']) && $filter['region'] =='孝感') selected="selected"
                                        @endif value="孝感">孝感
                                </option>
                                <option @if(isset($filter['region']) && $filter['region'] =='荆州') selected="selected"
                                        @endif value="荆州">荆州
                                </option>
                                <option @if(isset($filter['region']) && $filter['region'] =='黄冈') selected="selected"
                                        @endif value="黄冈">黄冈
                                </option>
                                <option @if(isset($filter['region']) && $filter['region'] =='咸宁') selected="selected"
                                        @endif value="咸宁">咸宁
                                </option>
                                <option @if(isset($filter['region']) && $filter['region'] =='随州') selected="selected"
                                        @endif value="随州">随州
                                </option>
                                <option @if(isset($filter['region']) && $filter['region'] =='恩施') selected="selected"
                                        @endif value="恩施">恩施
                                </option>
                                <option @if(isset($filter['region']) && $filter['region'] =='仙桃') selected="selected"
                                        @endif value="仙桃">仙桃
                                </option>
                                <option @if(isset($filter['region']) && $filter['region'] =='潜江') selected="selected"
                                        @endif value="潜江">潜江
                                </option>
                                <option @if(isset($filter['region']) && $filter['region'] =='天门') selected="selected"
                                        @endif value="天门">天门
                                </option>
                                <option @if(isset($filter['region']) && $filter['region'] =='林区') selected="selected"
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


                    <td>
                        &nbsp;&nbsp;&nbsp;
                        <input type="button" id="viewBtn" class="formButton" value="查询" hidefocus onclick="doSearch()"/>
                    </td>

                    {{--<td style="float:left;margin-right:30px;">--}}
                    {{--<input type="submit" class="formButton" value="新增站址" id="addBtn" style="float: right;"/>--}}
                    {{--</td>--}}

                    <td>
                        <input type="button" class="formButton" value="导出" onclick="doExport()"
                               @if(isset($infoSites)) style="display: inline;" @endif style="display: none;"/>
                    </td>

                </div>
            </form>
        </div>
        <div id="siteInfo">
            <table class="statsTable" style="white-space:nowrap;font-size:12px;" id="siteStatsTable">

                <tr>
                    <th rowspan="3" colspan="2">
                        <a href="#" class="sort" name="" hidefocus>铁塔类型</a>
                    </th>
                    <th rowspan="3">
                        <a href="#" class="sort" name="" hidefocus>挂高（m）</a>
                    </th>
                    <th rowspan="2" colspan="5">
                        <a href="#" class="sort" name="" hidefocus>存量塔（个）</a>
                    </th>
                    <th colspan="6">
                        <a href="#" class="sort" name="" hidefocus>新建塔（个）</a>
                    </th>
                    <th colspan="10">
                        <a href="#" class="sort" name="" hidefocus>单塔年均服务费（万元）</a>
                    </th>
                    <th colspan="5">
                        <a href="#" class="sort" name="" hidefocus>年实际运行费用（万元）</a>
                    </th>
                    <th rowspan="3">
                        <a href="#" class="sort" name="" hidefocus>逻辑校验</a>
                    </th>
                </tr>
                <tr>

                    <th rowspan="2">
                        <a href="#" class="sort" name="" hidefocus>@if(isset($filter)){{$filter['year']}}@endif
                            年末新建到达数</a>
                    </th>
                    <th colspan="2">
                        <a href="#" class="sort" name="" hidefocus>新建共享</a>
                    </th>
                    <th rowspan="2">
                        <a href="#" class="sort" name="" hidefocus>新建独享</a>
                    </th>
                    <th rowspan="2">
                        <a href="#" class="sort" name=""
                           hidefocus>其中：年初已交付新建塔@if(isset($filter)){{'('.$filter['year'].'年10月31日-12月31日)'}}@endif</a>
                    </th>
                    <th rowspan="2">
                        <a href="#" class="sort" name="" hidefocus>共享率</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>独享单塔平均服务费</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>其中：平均塔租</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>其中：单塔平均场地费</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>其中：单塔平均电力引入费</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>其中：单塔平均维护费</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>其中：发电服务费</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>存量单塔年均服务费</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>新建单塔年均服务费</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>三共享单塔年均服务费</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>两共享单塔年均服务费</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>铁塔服务年成本</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>站址服务费</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>转供电费用</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>发电服务费</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>其他</a>
                    </th>
                </tr>
                <tr>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>@if(isset($filter)){{$filter['year']}}@endif
                            年末存量合计</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>三共享</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>两共享</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>存量独享</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>共享率</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>三共享</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>两共享</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>1</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>1-1</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>1-2</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>1-3</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>1-4</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>1-5</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>2</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>3</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>4</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>5</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>6=7+8+9+10</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>7</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>8</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>9</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>0</a>
                    </th>

                </tr>
                <tr>
                    <th rowspan="11">
                        <a href="#" class="sort" name="" hidefocus>地面塔</a>
                    </th>
                    <th rowspan="5">
                        <a href="#" class="sort" name="" hidefocus>普通地面塔</a>
                    </th>
                    <th>H<30</th>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 1 && $old_site_num_stat->sys1_height == 2)
                                    {{$old_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 1 && $old_site_share_num_stat->sys1_height == 2&&
                            $old_site_share_num_stat->share_num_site == 3)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 1 && $old_site_share_num_stat->sys1_height == 2&&
                                $old_site_share_num_stat->share_num_site == 2)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 1 && $old_site_share_num_stat->sys1_height == 2&&$old_site_share_num_stat->share_num_site == 1)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 1 && $old_site_num_stat->sys1_height == 2)
                                    {{$old_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif
                    </td>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 1 && $new_site_num_stat->sys1_height == 2)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 1 && $new_site_share_num_stat->sys1_height == 2&&$new_site_share_num_stat->share_num_site == 3)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 1 && $new_site_share_num_stat->sys1_height == 2&&$new_site_share_num_stat->share_num_site == 2)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 1 && $new_site_share_num_stat->sys1_height == 2&&$new_site_share_num_stat->share_num_site == 1)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 1 && $new_site_num_stat->sys1_height == 2)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 1 && $new_site_num_stat->sys1_height == 2)
                                    {{$new_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 2&&$site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 2&&$site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_tower*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>


                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 2&&
                                    $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_site*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 2&&$site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_import*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 2&&$site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 2&&$site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_fee_stats))
                            @foreach($old_site_fee_stats as $old_site_fee_stat)
                                @if($old_site_fee_stat->tower_type == 1 && $old_site_fee_stat->sys1_height == 2)
                                    {{formatNumber_wan($old_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_fee_stats))
                            @foreach($new_site_fee_stats as $new_site_fee_stat)
                                @if($new_site_fee_stat->tower_type == 1 && $new_site_fee_stat->sys1_height == 2)
                                    {{formatNumber_wan($new_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 2&&$site_fee_stat->share_num_site == 3)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 2&&$site_fee_stat->share_num_site == 2)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 1 && $total_site_fee_stat->sys1_height == 2)
                                    {{formatNumber_wan($total_site_fee_stat->fee_total*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 1 && $total_site_fee_stat->sys1_height == 2)
                                    {{formatNumber_wan($total_site_fee_stat->site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td></td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 1 && $total_site_fee_stat->sys1_height == 2)
                                    {{formatNumber_wan($total_site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td></td>
                </tr>

                <tr>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>30≤H<35</a>
                    </th>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 1 && $old_site_num_stat->sys1_height == 5)
                                    {{$old_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 1 && $old_site_share_num_stat->sys1_height == 5&&$old_site_share_num_stat->share_num_site == 3)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 1 && $old_site_share_num_stat->sys1_height == 5&&$old_site_share_num_stat->share_num_site == 2)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 1 && $old_site_share_num_stat->sys1_height == 5&&$old_site_share_num_stat->share_num_site == 1)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 1 && $old_site_num_stat->sys1_height == 5)
                                    {{$old_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 1 && $new_site_num_stat->sys1_height == 5)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 1 && $new_site_share_num_stat->sys1_height == 5&&$new_site_share_num_stat->share_num_site == 3)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 1 && $new_site_share_num_stat->sys1_height == 5&&$new_site_share_num_stat->share_num_site == 2)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 1 && $new_site_share_num_stat->sys1_height == 5&&
                                                            $new_site_share_num_stat->share_num_site == 1)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 1 && $new_site_num_stat->sys1_height == 5)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 1 && $new_site_num_stat->sys1_height == 5)
                                    {{$new_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 5&&
                                                                $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 5&&
                                                                    $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_tower*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 5&&
                                                                        $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_site*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 5&&
                                                                            $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_import*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 5&&
                                                                                $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 5&&
                                                                                    $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_fee_stats))
                            @foreach($old_site_fee_stats as $old_site_fee_stat)
                                @if($old_site_fee_stat->tower_type == 1 && $old_site_fee_stat->sys1_height == 5)
                                    {{formatNumber_wan($old_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_fee_stats))
                            @foreach($new_site_fee_stats as $new_site_fee_stat)
                                @if($new_site_fee_stat->tower_type == 1 && $new_site_fee_stat->sys1_height == 5)
                                    {{formatNumber_wan($new_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 5&&
                                                                                        $site_fee_stat->share_num_site == 3)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 5&&
                                                                                            $site_fee_stat->share_num_site == 2)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 1 && $total_site_fee_stat->sys1_height == 5)
                                    {{formatNumber_wan($total_site_fee_stat->fee_total*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 1 && $total_site_fee_stat->sys1_height == 5)
                                    {{formatNumber_wan($total_site_fee_stat->site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td></td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 1 && $total_site_fee_stat->sys1_height == 5)
                                    {{formatNumber_wan($total_site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td></td>
                </tr>

                <tr>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>35≤H<40</a>
                    </th>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 1 && $old_site_num_stat->sys1_height == 6)
                                    {{$old_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 1 && $old_site_share_num_stat->sys1_height == 6&&
                                                                                                $old_site_share_num_stat->share_num_site == 3)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 1 && $old_site_share_num_stat->sys1_height == 6&&
                                                                                                    $old_site_share_num_stat->share_num_site == 2)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 1 && $old_site_share_num_stat->sys1_height == 6&&
                                                                                                        $old_site_share_num_stat->share_num_site == 1)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 1 && $old_site_num_stat->sys1_height == 6)
                                    {{$old_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 1 && $new_site_num_stat->sys1_height == 6)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 1 && $new_site_share_num_stat->sys1_height == 6&&
                                                                                                            $new_site_share_num_stat->share_num_site == 3)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 1 && $new_site_share_num_stat->sys1_height == 6&&
                                                                                                                $new_site_share_num_stat->share_num_site == 2)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 1 && $new_site_share_num_stat->sys1_height == 6&&
                                                                                                                    $new_site_share_num_stat->share_num_site == 1)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 1 && $new_site_num_stat->sys1_height == 6)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 1 && $new_site_num_stat->sys1_height == 6)
                                    {{$new_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 6&&
                                                                                                                        $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 6&&
                                                                                                                            $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_tower*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 6&&
                                                                                                                                $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_site*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 6&&
                                                                                                                                    $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_import*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 6&&
                                                                                                                                        $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 6&&
                                                                                                                                            $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_fee_stats))
                            @foreach($old_site_fee_stats as $old_site_fee_stat)
                                @if($old_site_fee_stat->tower_type == 1 && $old_site_fee_stat->sys1_height == 6)
                                    {{formatNumber_wan($old_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_fee_stats))
                            @foreach($new_site_fee_stats as $new_site_fee_stat)
                                @if($new_site_fee_stat->tower_type == 1 && $new_site_fee_stat->sys1_height == 6)
                                    {{formatNumber_wan($new_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 6&&
                                                                                                                                                $site_fee_stat->share_num_site == 3)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 6&&
                                                                                                                                                    $site_fee_stat->share_num_site == 2)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 1 && $total_site_fee_stat->sys1_height == 6)
                                    {{formatNumber_wan($total_site_fee_stat->fee_total*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 1 && $total_site_fee_stat->sys1_height == 6)
                                    {{formatNumber_wan($total_site_fee_stat->site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td></td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 1 && $total_site_fee_stat->sys1_height == 6)
                                    {{formatNumber_wan($total_site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td></td>
                </tr>

                <tr>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>40≤H<45</a>
                    </th>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 1 && $old_site_num_stat->sys1_height == 7)
                                    {{$old_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 1 && $old_site_share_num_stat->sys1_height == 7&&
                                                                                                                                                        $old_site_share_num_stat->share_num_site == 3)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 1 && $old_site_share_num_stat->sys1_height == 7&&
                                                                                                                                                            $old_site_share_num_stat->share_num_site == 2)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 1 && $old_site_share_num_stat->sys1_height == 7&&
                                                                                                                                                                $old_site_share_num_stat->share_num_site == 1)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 1 && $old_site_num_stat->sys1_height == 7)
                                    {{$old_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 1 && $new_site_num_stat->sys1_height == 7)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 1 && $new_site_share_num_stat->sys1_height == 7&&
                                                                                                                                                                    $new_site_share_num_stat->share_num_site == 3)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 1 && $new_site_share_num_stat->sys1_height == 7&&
                                                                                                                                                                        $new_site_share_num_stat->share_num_site == 2)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 1 && $new_site_share_num_stat->sys1_height == 7&&
                                                                                                                                                                            $new_site_share_num_stat->share_num_site == 1)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 1 && $new_site_num_stat->sys1_height == 7)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 1 && $new_site_num_stat->sys1_height == 7)
                                    {{$new_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 7&&
                                                                                                                                                                                $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 7&&
                                                                                                                                                                                    $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_tower*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 7&&
                                                                                                                                                                                        $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_site*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 7&&
                                                                                                                                                                                            $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_import*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 7&&
                                                                                                                                                                                                $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 7&&
                                                                                                                                                                                                    $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_fee_stats))
                            @foreach($old_site_fee_stats as $old_site_fee_stat)
                                @if($old_site_fee_stat->tower_type == 1 && $old_site_fee_stat->sys1_height == 7)
                                    {{formatNumber_wan($old_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_fee_stats))
                            @foreach($new_site_fee_stats as $new_site_fee_stat)
                                @if($new_site_fee_stat->tower_type == 1 && $new_site_fee_stat->sys1_height == 7)
                                    {{formatNumber_wan($new_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 7&&
                                                                                                                                                                                                        $site_fee_stat->share_num_site == 3)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 7&&
                                                                                                                                                                                                            $site_fee_stat->share_num_site == 2)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 1 && $total_site_fee_stat->sys1_height == 7)
                                    {{formatNumber_wan($total_site_fee_stat->fee_total*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 1 && $total_site_fee_stat->sys1_height == 7)
                                    {{formatNumber_wan($total_site_fee_stat->site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td></td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 1 && $total_site_fee_stat->sys1_height == 7)
                                    {{formatNumber_wan($total_site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td></td>
                </tr>

                <tr>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>45≤H≤50</a>
                    </th>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 1 && $old_site_num_stat->sys1_height == 8)
                                    {{$old_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 1 && $old_site_share_num_stat->sys1_height == 8&&
                                                                                                                                                                                                                $old_site_share_num_stat->share_num_site == 3)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 1 && $old_site_share_num_stat->sys1_height == 8&&
                                                                                                                                                                                                                    $old_site_share_num_stat->share_num_site == 2)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 1 && $old_site_share_num_stat->sys1_height == 8&&
                                                                                                                                                                                                                        $old_site_share_num_stat->share_num_site == 1)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 1 && $old_site_num_stat->sys1_height == 8)
                                    {{$old_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 1 && $new_site_num_stat->sys1_height == 8)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 1 && $new_site_share_num_stat->sys1_height == 8&&
                                                                                                                                                                                                                            $new_site_share_num_stat->share_num_site == 3)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 1 && $new_site_share_num_stat->sys1_height == 8&&
                                                                                                                                                                                                                                $new_site_share_num_stat->share_num_site == 2)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 1 && $new_site_share_num_stat->sys1_height == 8&&
                                                                                                                                                                                                                                    $new_site_share_num_stat->share_num_site == 1)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 1 && $new_site_num_stat->sys1_height == 8)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 1 && $new_site_num_stat->sys1_height == 8)
                                    {{$new_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 8&&
                                                                                                                                                                                                                                        $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 8&&
                                                                                                                                                                                                                                            $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_tower*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 8&&
                                                                                                                                                                                                                                                $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_site*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 8&&
                                                                                                                                                                                                                                                    $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_import*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 8&&
                                                                                                                                                                                                                                                        $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 8&&
                                                                                                                                                                                                                                                           $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_fee_stats))
                            @foreach($old_site_fee_stats as $old_site_fee_stat)
                                @if($old_site_fee_stat->tower_type == 1 && $old_site_fee_stat->sys1_height == 8)
                                    {{formatNumber_wan($old_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_fee_stats))
                            @foreach($new_site_fee_stats as $new_site_fee_stat)
                                @if($new_site_fee_stat->tower_type == 1 && $new_site_fee_stat->sys1_height == 8)
                                    {{formatNumber_wan($new_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 8&&
                                                                                                                                                                                                                                                            $site_fee_stat->share_num_site == 3)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 1 && $site_fee_stat->sys1_height == 8&&
                                                                                                                                                                                                                                                                $site_fee_stat->share_num_site == 2)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 1 && $total_site_fee_stat->sys1_height == 8)
                                    {{formatNumber_wan($total_site_fee_stat->fee_total*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 1 && $total_site_fee_stat->sys1_height == 8)
                                    {{formatNumber_wan($total_site_fee_stat->site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td></td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 1 && $total_site_fee_stat->sys1_height == 8)
                                    {{formatNumber_wan($total_site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td></td>
                </tr>


                <tr>

                    <th rowspan="5">
                        <a href="#" class="sort" name="" hidefocus>灯杆景观塔</a>
                    </th>
                    <th>H<20</th>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 2 && $old_site_num_stat->sys1_height == 1)
                                    {{$old_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 2 && $old_site_share_num_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                    $old_site_share_num_stat->share_num_site == 3)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 2 && $old_site_share_num_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                        $old_site_share_num_stat->share_num_site == 2)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 2 && $old_site_share_num_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                            $old_site_share_num_stat->share_num_site == 1)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 2 && $old_site_num_stat->sys1_height == 1)
                                    {{$old_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 2 && $new_site_num_stat->sys1_height == 1)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 2 && $new_site_share_num_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                $new_site_share_num_stat->share_num_site == 3)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 2 && $new_site_share_num_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                    $new_site_share_num_stat->share_num_site == 2)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 2 && $new_site_share_num_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                        $new_site_share_num_stat->share_num_site == 1)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 2 && $new_site_num_stat->sys1_height == 1)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 2 && $new_site_num_stat->sys1_height == 1)
                                    {{$new_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                            $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                                $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_tower*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                                    $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_site*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                                        $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_import*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                                            $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                                                $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_fee_stats))
                            @foreach($old_site_fee_stats as $old_site_fee_stat)
                                @if($old_site_fee_stat->tower_type == 2 && $old_site_fee_stat->sys1_height == 1)
                                    {{formatNumber_wan($old_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_fee_stats))
                            @foreach($new_site_fee_stats as $new_site_fee_stat)
                                @if($new_site_fee_stat->tower_type == 2 && $new_site_fee_stat->sys1_height == 1)
                                    {{formatNumber_wan($new_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                                                    $site_fee_stat->share_num_site == 3)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                                                        $site_fee_stat->share_num_site == 2)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 2 && $total_site_fee_stat->sys1_height == 1)
                                    {{formatNumber_wan($total_site_fee_stat->fee_total*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 2 && $total_site_fee_stat->sys1_height == 1)
                                    {{formatNumber_wan($total_site_fee_stat->site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td></td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 2 && $total_site_fee_stat->sys1_height == 1)
                                    {{formatNumber_wan($total_site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td></td>
                </tr>

                <tr>


                    <th>20≤H<25</th>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 2 && $old_site_num_stat->sys1_height == 3)
                                    {{$old_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 2 && $old_site_share_num_stat->sys1_height == 3&&
                                                                                                                                                                                                                                                                                                                            $old_site_share_num_stat->share_num_site == 3)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 2 && $old_site_share_num_stat->sys1_height == 3&&
                                                                                                                                                                                                                                                                                                                                $old_site_share_num_stat->share_num_site == 2)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 2 && $old_site_share_num_stat->sys1_height == 3&&
                                                                                                                                                                                                                                                                                                                                    $old_site_share_num_stat->share_num_site == 1)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 2 && $old_site_num_stat->sys1_height == 3)
                                    {{$old_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 2 && $new_site_num_stat->sys1_height == 3)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 2 && $new_site_share_num_stat->sys1_height == 3&&
                                                                                                                                                                                                                                                                                                                                        $new_site_share_num_stat->share_num_site == 3)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 2 && $new_site_share_num_stat->sys1_height == 3&&
                                                                                                                                                                                                                                                                                                                                            $new_site_share_num_stat->share_num_site == 2)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 2 && $new_site_share_num_stat->sys1_height == 3&&
                                                                                                                                                                                                                                                                                                                                                $new_site_share_num_stat->share_num_site == 1)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 2 && $new_site_num_stat->sys1_height == 3)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 2 && $new_site_num_stat->sys1_height == 3)
                                    {{$new_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 3&&
                                                                                                                                                                                                                                                                                                                                                    $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 3&&
                                                                                                                                                                                                                                                                                                                                                        $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_tower*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 3&&
                                                                                                                                                                                                                                                                                                                                                            $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_site*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 3&&
                                                                                                                                                                                                                                                                                                                                                                $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_import*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 3&&
                                                                                                                                                                                                                                                                                                                                                                    $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 3&&
                                                                                                                                                                                                                                                                                                                                                                        $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_fee_stats))
                            @foreach($old_site_fee_stats as $old_site_fee_stat)
                                @if($old_site_fee_stat->tower_type == 2 && $old_site_fee_stat->sys1_height == 3)
                                    {{formatNumber_wan($old_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_fee_stats))
                            @foreach($new_site_fee_stats as $new_site_fee_stat)
                                @if($new_site_fee_stat->tower_type == 2 && $new_site_fee_stat->sys1_height == 3)
                                    {{formatNumber_wan($new_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 3&&
                                                                                                                                                                                                                                                                                                                                                                            $site_fee_stat->share_num_site == 3)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 3&&
                                                                                                                                                                                                                                                                                                                                                                                $site_fee_stat->share_num_site == 2)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 2 && $total_site_fee_stat->sys1_height == 3)
                                    {{formatNumber_wan($total_site_fee_stat->fee_total*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 2 && $total_site_fee_stat->sys1_height == 3)
                                    {{formatNumber_wan($total_site_fee_stat->site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td></td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 2 && $total_site_fee_stat->sys1_height == 3)
                                    {{formatNumber_wan($total_site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td></td>
                </tr>

                <tr>


                    <th>25≤H<30</th>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 2 && $old_site_num_stat->sys1_height == 4)
                                    {{$old_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 2 && $old_site_share_num_stat->sys1_height == 4&&
                                                                                                                                                                                                                                                                                                                                                                                    $old_site_share_num_stat->share_num_site == 3)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 2 && $old_site_share_num_stat->sys1_height == 4&&
                                                                                                                                                                                                                                                                                                                                                                                        $old_site_share_num_stat->share_num_site == 2)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 2 && $old_site_share_num_stat->sys1_height == 4&&
                                                                                                                                                                                                                                                                                                                                                                                            $old_site_share_num_stat->share_num_site == 1)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 2 && $old_site_num_stat->sys1_height == 4)
                                    {{$old_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 2 && $new_site_num_stat->sys1_height == 4)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 2 && $new_site_share_num_stat->sys1_height == 4&&
                                                                                                                                                                                                                                                                                                                                                                                                $new_site_share_num_stat->share_num_site == 3)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 2 && $new_site_share_num_stat->sys1_height == 4&&
                                                                                                                                                                                                                                                                                                                                                                                                    $new_site_share_num_stat->share_num_site == 2)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 2 && $new_site_share_num_stat->sys1_height == 4&&
                                                                                                                                                                                                                                                                                                                                                                                                        $new_site_share_num_stat->share_num_site == 1)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach

                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 2 && $new_site_num_stat->sys1_height == 4)
                                    {{$new_site_num_stat->count}}

                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 2 && $new_site_num_stat->sys1_height == 4)
                                    {{$new_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 4&&
                                                                                                                                                                                                                                                                                                                                                                                                            $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 4&&
                                                                                                                                                                                                                                                                                                                                                                                                                $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_tower*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 4&&
                                                                                                                                                                                                                                                                                                                                                                                                                    $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_site*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 4&&
                                                                                                                                                                                                                                                                                                                                                                                                                        $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_import*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 4&&
                                                                                                                                                                                                                                                                                                                                                                                                                            $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 4&&
                                                                                                                                                                                                                                                                                                                                                                                                                                $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_fee_stats))
                            @foreach($old_site_fee_stats as $old_site_fee_stat)
                                @if($old_site_fee_stat->tower_type == 2 && $old_site_fee_stat->sys1_height == 4)
                                    {{formatNumber_wan($old_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_fee_stats))
                            @foreach($new_site_fee_stats as $new_site_fee_stat)
                                @if($new_site_fee_stat->tower_type == 2 && $new_site_fee_stat->sys1_height == 4)
                                    {{formatNumber_wan($new_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 4&&
                                                                                                                                                                                                                                                                                                                                                                                                                                    $site_fee_stat->share_num_site == 3)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 4&&
                                                                                                                                                                                                                                                                                                                                                                                                                                        $site_fee_stat->share_num_site == 2)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 2 && $total_site_fee_stat->sys1_height == 4)
                                    {{formatNumber_wan($total_site_fee_stat->fee_total*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 2 && $total_site_fee_stat->sys1_height == 4)
                                    {{formatNumber_wan($total_site_fee_stat->site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td></td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 2 && $total_site_fee_stat->sys1_height == 4)
                                    {{formatNumber_wan($total_site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td></td>
                </tr>

                <tr>


                    <th>30≤H<35</th>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 2 && $old_site_num_stat->sys1_height == 5)
                                    {{$old_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 2 && $old_site_share_num_stat->sys1_height == 5&&
                                                                                                                                                                                                                                                                                                                                                                                                                                            $old_site_share_num_stat->share_num_site == 3)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 2 && $old_site_share_num_stat->sys1_height == 5&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                $old_site_share_num_stat->share_num_site == 2)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 2 && $old_site_share_num_stat->sys1_height == 5&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                    $old_site_share_num_stat->share_num_site == 1)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 2 && $old_site_num_stat->sys1_height == 5)
                                    {{$old_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 2 && $new_site_num_stat->sys1_height == 5)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 2 && $new_site_share_num_stat->sys1_height == 5&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                        $new_site_share_num_stat->share_num_site == 3)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 2 && $new_site_share_num_stat->sys1_height == 5&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                            $new_site_share_num_stat->share_num_site == 2)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 2 && $new_site_share_num_stat->sys1_height == 5&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                $new_site_share_num_stat->share_num_site == 1)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 2 && $new_site_num_stat->sys1_height == 5)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 2 && $new_site_num_stat->sys1_height == 5)
                                    {{$new_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 5&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 5&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_tower*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 5&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_site*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 5&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_import*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 5&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 5&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_fee_stats))
                            @foreach($old_site_fee_stats as $old_site_fee_stat)
                                @if($old_site_fee_stat->tower_type == 2 && $old_site_fee_stat->sys1_height == 5)
                                    {{formatNumber_wan($old_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_fee_stats))
                            @foreach($new_site_fee_stats as $new_site_fee_stat)
                                @if($new_site_fee_stat->tower_type == 2 && $new_site_fee_stat->sys1_height == 5)
                                    {{formatNumber_wan($new_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 5&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $site_fee_stat->share_num_site == 3)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 5&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $site_fee_stat->share_num_site == 2)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 2 && $total_site_fee_stat->sys1_height == 5)
                                    {{formatNumber_wan($total_site_fee_stat->fee_total*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 2 && $total_site_fee_stat->sys1_height == 5)
                                    {{formatNumber_wan($total_site_fee_stat->site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td></td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 2 && $total_site_fee_stat->sys1_height == 5)
                                    {{formatNumber_wan($total_site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td></td>
                </tr>

                <tr>

                    <th>35≤H≤40</th>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 2 && $old_site_num_stat->sys1_height == 6)
                                    {{$old_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 2 && $old_site_share_num_stat->sys1_height == 6&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $old_site_share_num_stat->share_num_site == 3)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 2 && $old_site_share_num_stat->sys1_height == 6&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $old_site_share_num_stat->share_num_site == 2)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 2 && $old_site_share_num_stat->sys1_height == 6&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $old_site_share_num_stat->share_num_site == 1)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 2 && $old_site_num_stat->sys1_height == 6)
                                    {{$old_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 2 && $new_site_num_stat->sys1_height == 6)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 2 && $new_site_share_num_stat->sys1_height == 6&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $new_site_share_num_stat->share_num_site == 3)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 2 && $new_site_share_num_stat->sys1_height == 6&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $new_site_share_num_stat->share_num_site == 2)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 2 && $new_site_share_num_stat->sys1_height == 6&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $new_site_share_num_stat->share_num_site == 1)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 2 && $new_site_num_stat->sys1_height == 6)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 2 && $new_site_num_stat->sys1_height == 6)
                                    {{$new_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 6&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 6&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_tower*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 6&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_site*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 6&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_import*12)}}
                                @endif
                            @endforeach




                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))

                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 6&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 6&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_fee_stats))
                            @foreach($old_site_fee_stats as $old_site_fee_stat)
                                @if($old_site_fee_stat->tower_type == 2 && $old_site_fee_stat->sys1_height == 6)
                                    {{formatNumber_wan($old_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_fee_stats))
                            @foreach($new_site_fee_stats as $new_site_fee_stat)
                                @if($new_site_fee_stat->tower_type == 2 && $new_site_fee_stat->sys1_height == 6)
                                    {{formatNumber_wan($new_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 6&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $site_fee_stat->share_num_site == 3)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 2 && $site_fee_stat->sys1_height == 6&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $site_fee_stat->share_num_site == 2)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 2 && $total_site_fee_stat->sys1_height == 6)
                                    {{formatNumber_wan($total_site_fee_stat->fee_total*12)}}
                                @endif
                            @endforeach
                        @endif


                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 2 && $total_site_fee_stat->sys1_height == 6)
                                    {{formatNumber_wan($total_site_fee_stat->site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td></td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 2 && $total_site_fee_stat->sys1_height == 6)
                                    {{formatNumber_wan($total_site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td></td>
                </tr>

                <tr>

                    <th>
                        <a href="#" class="sort" name="" hidefocus>简易灯杆塔</a>
                    </th>
                    <th>H≤20</th>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 3 && $old_site_num_stat->sys1_height == 1)
                                    {{$old_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 3 && $old_site_share_num_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $old_site_share_num_stat->share_num_site == 3)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 3 && $old_site_share_num_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $old_site_share_num_stat->share_num_site == 2)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 3 && $old_site_share_num_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $old_site_share_num_stat->share_num_site == 1)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 3 && $old_site_num_stat->sys1_height == 1)
                                    {{$old_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 3 && $new_site_num_stat->sys1_height == 1)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 3 && $new_site_share_num_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $new_site_share_num_stat->share_num_site == 3)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 3 && $new_site_share_num_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $new_site_share_num_stat->share_num_site == 2)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 3 && $new_site_share_num_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $new_site_share_num_stat->share_num_site == 1)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 3 && $new_site_num_stat->sys1_height == 1)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 3 && $new_site_num_stat->sys1_height == 1)
                                    {{$new_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 3 && $site_fee_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 3 && $site_fee_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_tower*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 3 && $site_fee_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_site*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 3 && $site_fee_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_import*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 3 && $site_fee_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 3 && $site_fee_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_fee_stats))
                            @foreach($old_site_fee_stats as $old_site_fee_stat)
                                @if($old_site_fee_stat->tower_type == 3 && $old_site_fee_stat->sys1_height == 1)
                                    {{formatNumber_wan($old_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_fee_stats))
                            @foreach($new_site_fee_stats as $new_site_fee_stat)
                                @if($new_site_fee_stat->tower_type == 3 && $new_site_fee_stat->sys1_height == 1)
                                    {{formatNumber_wan($new_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 3 && $site_fee_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $site_fee_stat->share_num_site == 3)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 3 && $site_fee_stat->sys1_height == 1&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $site_fee_stat->share_num_site == 2)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 3 && $total_site_fee_stat->sys1_height == 1)
                                    {{formatNumber_wan($total_site_fee_stat->fee_total*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 3 && $total_site_fee_stat->sys1_height == 1)
                                    {{formatNumber_wan($total_site_fee_stat->site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td></td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 3 && $total_site_fee_stat->sys1_height == 1)
                                    {{formatNumber_wan($total_site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif


                    </td>

                    <td></td>
                </tr>
                <tr>

                    <th rowspan="2">
                        <a href="#" class="sort" name="" hidefocus>楼面塔</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>普通楼面塔</a>
                    </th>
                    <th>-</th>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 4 && $old_site_num_stat->sys1_height == 9)
                                    {{$old_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 4 && $old_site_share_num_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $old_site_share_num_stat->share_num_site == 3)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 4 && $old_site_share_num_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $old_site_share_num_stat->share_num_site == 2)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 4 && $old_site_share_num_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $old_site_share_num_stat->share_num_site == 1)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 4 && $old_site_num_stat->sys1_height == 9)
                                    {{$old_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 4 && $new_site_num_stat->sys1_height == 9)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 4 && $new_site_share_num_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $new_site_share_num_stat->share_num_site == 3)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 4 && $new_site_share_num_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $new_site_share_num_stat->share_num_site == 2)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 4 && $new_site_share_num_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $new_site_share_num_stat->share_num_site == 1)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 4 && $new_site_num_stat->sys1_height == 9)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 4 && $new_site_num_stat->sys1_height == 9)
                                    {{$new_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 4 && $site_fee_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 4 && $site_fee_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_tower*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 4 && $site_fee_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_site*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 4 && $site_fee_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_import*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 4 && $site_fee_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 4 && $site_fee_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_fee_stats))
                            @foreach($old_site_fee_stats as $old_site_fee_stat)
                                @if($old_site_fee_stat->tower_type == 4 && $old_site_fee_stat->sys1_height == 9)
                                    {{formatNumber_wan($old_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_fee_stats))
                            @foreach($new_site_fee_stats as $new_site_fee_stat)
                                @if($new_site_fee_stat->tower_type == 4 && $new_site_fee_stat->sys1_height == 9)
                                    {{formatNumber_wan($new_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 4 && $site_fee_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $site_fee_stat->share_num_site == 3)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 4 && $site_fee_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $site_fee_stat->share_num_site == 2)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 4 && $total_site_fee_stat->sys1_height == 9)
                                    {{formatNumber_wan($total_site_fee_stat->fee_total*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 4 && $total_site_fee_stat->sys1_height == 9)
                                    {{formatNumber_wan($total_site_fee_stat->site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td></td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 4 && $total_site_fee_stat->sys1_height == 9)
                                    {{formatNumber_wan($total_site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td></td>
                </tr>

                <tr>

                    <th>
                        <a href="#" class="sort" name="" hidefocus>楼面抱杆</a>
                    </th>
                    <th>-</th>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 5 && $old_site_num_stat->sys1_height == 9)
                                    {{$old_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 5 && $old_site_share_num_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $old_site_share_num_stat->share_num_site == 3)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 5 && $old_site_share_num_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $old_site_share_num_stat->share_num_site == 2)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_share_num_stats))
                            @foreach($old_site_share_num_stats as $old_site_share_num_stat)
                                @if($old_site_share_num_stat->tower_type == 5 && $old_site_share_num_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $old_site_share_num_stat->share_num_site == 1)
                                    {{$old_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($old_site_num_stats as $old_site_num_stat)
                                @if($old_site_num_stat->tower_type == 5 && $old_site_num_stat->sys1_height == 9)
                                    {{$old_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td>
                        @if(isset($old_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 5 && $new_site_num_stat->sys1_height == 9)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 5 && $new_site_share_num_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $new_site_share_num_stat->share_num_site == 3)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 5 && $new_site_share_num_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $new_site_share_num_stat->share_num_site == 2)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_share_num_stats))
                            @foreach($new_site_share_num_stats as $new_site_share_num_stat)
                                @if($new_site_share_num_stat->tower_type == 5 && $new_site_share_num_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $new_site_share_num_stat->share_num_site == 1)
                                    {{$new_site_share_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 5 && $new_site_num_stat->sys1_height == 9)
                                    {{$new_site_num_stat->count}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_num_stats))
                            @foreach($new_site_num_stats as $new_site_num_stat)
                                @if($new_site_num_stat->tower_type == 5 && $new_site_num_stat->sys1_height == 9)
                                    {{$new_site_num_stat->share_rate}}%
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 5 && $site_fee_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 5 && $site_fee_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_tower*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 5 && $site_fee_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_site*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 5 && $site_fee_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_import*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>


                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 5 && $site_fee_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 5 && $site_fee_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $site_fee_stat->share_num_site == 1)
                                    {{formatNumber_wan($site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($old_site_fee_stats))
                            @foreach($old_site_fee_stats as $old_site_fee_stat)
                                @if($old_site_fee_stat->tower_type == 5 && $old_site_fee_stat->sys1_height == 9)
                                    {{formatNumber_wan($old_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($new_site_fee_stats))
                            @foreach($new_site_fee_stats as $new_site_fee_stat)
                                @if($new_site_fee_stat->tower_type == 5 && $new_site_fee_stat->sys1_height == 9)
                                    {{formatNumber_wan($new_site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 5 && $site_fee_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $site_fee_stat->share_num_site == 3)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($site_fee_stats))
                            @foreach($site_fee_stats as $site_fee_stat)
                                @if($site_fee_stat->tower_type == 5 && $site_fee_stat->sys1_height == 9&&
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $site_fee_stat->share_num_site == 2)
                                    {{formatNumber_wan($site_fee_stat->avg_fee_maintain*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 5 && $total_site_fee_stat->sys1_height == 9)
                                    {{formatNumber_wan($total_site_fee_stat->fee_total*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 5 && $total_site_fee_stat->sys1_height == 9)
                                    {{formatNumber_wan($total_site_fee_stat->site_fee*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td></td>
                    <td>
                        @if(isset($total_site_fee_stats))
                            @foreach($total_site_fee_stats as $total_site_fee_stat)
                                @if($total_site_fee_stat->tower_type == 5 && $total_site_fee_stat->sys1_height == 9)
                                    {{formatNumber_wan($total_site_fee_stat->fee_gnr_allincharge*12)}}
                                @endif
                            @endforeach
                        @endif

                    </td>

                    <td></td>
                </tr>


            </table>


        </div>


    </div>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {
            $('#menu_business').addClass("current");
            if ($('#siteStats').val() == '1') {
                $("#siteStatsTable").find("tr").each(function () {
                    var tdArr = $(this).children();
                    for (var i = 0; i < tdArr.length; i++) {
                        if ($.trim(tdArr.eq(i).text()) == '') {
                            tdArr.eq(i).html('0');
                        }
                    }
                });
            }

        });

        function doSearch() {
            var listForm = document.getElementById("listForm");
            var region = document.getElementById('region');
            listForm.action = "{{url('backend/siteStats')}}";
            listForm.submit();
        }

        function doExport() {
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/siteInfo/export')}}";
            listForm.submit();
        }

        function doImport() {
            var billDetailFile = document.getElementById('billDetailFile');
            if (billDetailFile.value == "") {
                alert('请选择需要导入的文件');
                return;
            }
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/siteStats/import')}}";
            listForm.submit();
        }

        function doEditPage(id) {
            var region = $('#region').val();
            var listForm = document.getElementById('listForm');
            url = "{{url('backend/siteInfo/editPage')}}" + '/' + id + '/' + region;
            listForm.action = url;
            listForm.submit();
        }


    </script>
@endsection
