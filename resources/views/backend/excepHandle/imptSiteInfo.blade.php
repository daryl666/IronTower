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
                        <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">站址信息查询</a>
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/siteInfo/addNewPage')}}">站址信息新增</a>
                    </li>
                    <li class="active" style="float: none">
                        <a href="{{url('backend/excepHandle/importSiteInfo')}}">导入异常处理</a>
                    </li>
                    <li class="inactive" style="float: none">
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
                        <a href="#">业务管理</a>
                    </li>
                    <li>
                        <a href="#">站址信息管理</a>
                    </li>
                    <li class="active">
                        <a href="#">导入异常处理</a>
                    </li>
                </ul>


            </div>
        </div>

    </div>




    <div class="list">
        <div class="body">
            <form id="listForm" method="post" action="{{url('backend/siteInfo/')}}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="listBar">
                    <td>
                        请选择地市来查看异常的站址信息：
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


                    <td>
                        &nbsp;&nbsp;&nbsp;
                        <input type="button" id="viewBtn" class="formButton" value="查询" hidefocus onclick="doSearch()"/>
                    </td>


                </div>
            </form>
        </div>
        <div id="siteInfo">
            <table class="listTable" style="white-space:nowrap;font-size:12px;">

                <tr>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>操作</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>记录类型</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>站址编码</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>服务起始日期</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>地市</a>
                    </th>
                    <th class="scanStopTime">
                        <a href="#" class="sort" name="" hidefocus>铁塔类型</a>
                    </th>
                    <th class="scanStopTime">
                        <a href="#" class="sort" name="" hidefocus>是否为新建站</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>产品配套类型</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>是否为竞合站点</a>
                    </th>
                    <th class="scanStopTime">
                        <a href="#" class="sort" name="" hidefocus>是否存在新增共享</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>用户类型</a>
                    </th>
                    <th class="gp">
                        <a href="#" class="sort" name="" hidefocus>覆盖场景</a>
                    </th>
                    <th class="scanStopTime">
                        <a href="#" class="sort" name="" hidefocus>系统数量</a>
                    </th>
                    {{--<th class="scanStopTime">--}}
                    {{--<a href="#" class="sort" name="" hidefocus>系统挂高(米)</a>--}}
                    {{--</th>--}}
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>铁塔共享类型</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>铁塔基准价格（元/月）（不含折扣）</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>铁塔基准价格（元/月）（含折扣）</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>机房共享类型</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>机房基准价格（元/月）（不含折扣）</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>机房基准价格（元/月）（含折扣）</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>配套共享类型</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>配套基准价格（元/月）（不含折扣）</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>配套基准价格（元/月）（含折扣）</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>维修共享类型</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>维修基准价格（元/月）（不含折扣）</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>维修基准价格（元/月）（含折扣）</a>
                    </th>
                    {{--<th class="freqMode">--}}
                    {{--<a href="#" class="sort" name="" hidefocus>站址所在地区类型</a>--}}
                    {{--</th>--}}
                    {{--<th class="freqMode">--}}
                    {{--<a href="#" class="sort" name="" hidefocus>是否RRU拉远</a>--}}
                    {{--</th>--}}
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>场地费共享类型</a>
                    </th>

                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>场地费（元/月）（不含折扣）</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>场地费（元/月）（含折扣）</a>
                    </th>
                    {{--<th class="freqMode">--}}
                    {{--<a href="#" class="sort" name="" hidefocus>引电类型</a>--}}
                    {{--</th>--}}
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>电力引入费共享类型</a>
                    </th>

                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>电力引入费（元/月）（不含折扣）</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="" hidefocus>电力引入费（元/月）（含折扣）</a>
                    </th>


                </tr>
                @if(isset($excepSiteInfos))
                    @foreach($excepSiteInfos as $excepSiteInfo)
                        <tr>
                            <td>
                                <button class="buttonNextStep" onclick="doUpdate({{$excepSiteInfo->id}})">替换</button>
                                <button class="buttonNextStep" onclick="doDeny({{$excepSiteInfo->id}})">放弃</button>
                            </td>
                            <td>
                                冲突记录
                            </td>
                            <td>{{$excepSiteInfo->site_code}}</td>
                            <td>{{$excepSiteInfo->established_time}}</td>
                            <td>{{$excepSiteInfo->region_name}}</td>
                            <td>{{$excepSiteInfo->tower_type}}</td>
                            <td>{{$excepSiteInfo->is_new_tower}}</td>
                            <td>{{$excepSiteInfo->product_type}}</td>
                            <td>{{$excepSiteInfo->is_co_opetition}}</td>
                            <td>{{$excepSiteInfo->is_newly_added}}</td>
                            <td>{{$excepSiteInfo->user_type}}</td>
                            <td>{{$excepSiteInfo->land_form}}</td>

                            <td>{{$excepSiteInfo->sys_num}}</td>
                            {{--<td>{{$excepSiteInfo->sys1_height}}</td>--}}
                            <td>{{$excepSiteInfo->share_num_tower}}</td>

                            <td>{{$excepSiteInfo->share_num_house}}</td>

                            <td>{{$excepSiteInfo->share_num_support}}</td>

                            <td>{{$excepSiteInfo->share_num_maintain}}</td>

                            {{--<td>{{$excepSiteInfo->site_district_type}}</td>--}}
                            {{--<td>{{$excepSiteInfo->is_rru_away}}</td>--}}
                            <td>{{$excepSiteInfo->share_num_site}}</td>
                            {{--<td>{{$excepSiteInfo->site_sha_dis}}</td>--}}

                            {{--<td>{{$excepSiteInfo->elec_introduced_type}}</td>--}}
                            <td>{{$excepSiteInfo->share_num_import}}</td>
                            {{--<td>{{$excepSiteInfo->import_sha_dis}}</td>--}}
                        </tr>
                        @foreach($origSiteInfos as $origSiteInfo)
                            @if($origSiteInfo->id == $excepSiteInfo->site_info_id)
                                <tr>
                                    <td></td>
                                    <td>原有记录</td>
                                    <td>{{$origSiteInfo->site_code}}</td>
                                    <td>{{$origSiteInfo->established_time}}</td>
                                    <td>{{$origSiteInfo->region_name}}</td>
                                    <td>{{$origSiteInfo->tower_type}}</td>
                                    <td>{{$origSiteInfo->is_new_tower}}</td>
                                    <td>{{$origSiteInfo->product_type}}</td>
                                    <td>{{$origSiteInfo->is_co_opetition}}</td>
                                    <td>{{$origSiteInfo->is_newly_added}}</td>
                                    <td>{{$origSiteInfo->user_type}}</td>
                                    <td>{{$origSiteInfo->land_form}}</td>

                                    <td>{{$origSiteInfo->sys_num}}</td>
                                    {{--<td>{$origSiteInfo->sys1_height}}</td>--}}
                                    <td>{{$origSiteInfo->share_num_tower}}</td>

                                    <td>{{$origSiteInfo->share_num_house}}</td>

                                    <td>{{$origSiteInfo->share_num_support}}</td>

                                    <td>{{$origSiteInfo->share_num_maintain}}</td>

                                    {{--<td>{$origSiteInfo->site_district_type}}</td>--}}
                                    {{--<td>{$origSiteInfo->is_rru_away}}</td>--}}
                                    <td>{{$origSiteInfo->share_num_site}}</td>
                                    {{--<td>{$origSiteInfo->site_sha_dis}}</td>--}}

                                    {{--<td>{$origSiteInfo->elec_introduced_type}}</td>--}}
                                    <td>{{$origSiteInfo->share_num_import}}</td>
                                    {{--<td>{$origSiteInfo->import_sha_dis}}</td>--}}
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                    {{--{!! $excepSiteInfos->render() !!}--}}
                @endif


            </table>


        </div>


    </div>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {
//            $('#menu_business').addClass("current");
            var menu_business = document.getElementById('menu_business');
            menu_business.className = "current";
        });

        function doSearch() {
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/excepHandle/importSiteInfo')}}";
            listForm.submit();
        }

        function doUpdate(id) {
            if (confirm('确认保留新站址吗？')) {
                var listForm = document.getElementById("listForm");
                var url = "{{url('backend/excepHandle/update')}}" + '/' + id;
                listForm.action = url;
                listForm.submit();
            }

        }

        function doDeny(id) {
            if (confirm('确认放弃新站址吗？')) {
                var listForm = document.getElementById("listForm");
                var url = "{{url('backend/excepHandle/deny')}}" + '/' + id;
                listForm.action = url;
                listForm.submit();
            }

        }


    </script>
@endsection