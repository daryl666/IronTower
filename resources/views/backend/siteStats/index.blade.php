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
                <ul class="nav nav-tabs">
                    <li class="inactive">
                        <a href="{{url('backend/servBill')}}">账单管理</a>
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/servBill/irontowerBillImportPage')}}">铁塔详单导入</a>
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/servBill/billCheck')}}">账单稽查</a>
                    </li>
                    <li class="active">
                        <a href="{{url('backend/siteStats/')}}">铁塔详单统计</a>
                    </li>
                </ul>
                <ul class="breadcrumb" style="margin-bottom: 0;background-color: #F5F5F5">
                    当前位置：
                    <li>
                        <a href="{{url('backend/servBill')}}">账单管理</a>
                    </li>
                    <li class="active">
                        <a href="#">铁塔详单统计</a>
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
                        请选择地市、起止时间和共享类型（铁塔共享、机房共享等）查看站址统计信息：
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
                        &nbsp;&nbsp;地市：
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
                            </select>@endif

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
                        &nbsp;&nbsp;共享类型：
                        <select name="shareType">
                            <option @if(isset($filter['shareType']) && $filter['shareType'] == 'share_num_tower') selected="selected"
                                    @endif value="share_num_tower">铁塔共享
                            </option>
                            <option value="share_num_house"
                                    @if(isset($filter['shareType']) && $filter['shareType'] == 'share_num_house') selected="selected"@endif>
                                机房共享
                            </option>
                            <option value="share_num_support"
                                    @if(isset($filter['shareType']) && $filter['shareType'] == 'share_num_support') selected="selected"@endif>
                                配套共享
                            </option>
                            <option value="share_num_maintain"
                                    @if(isset($filter['shareType']) && $filter['shareType'] == 'share_num_maintain') selected="selected"@endif>
                                维护费共享
                            </option>
                            <option value="share_num_import"
                                    @if(isset($filter['shareType']) && $filter['shareType'] == 'share_num_import') selected="selected"@endif>
                                电力引入费共享
                            </option>
                            <option value="share_num_site"
                                    @if(isset($filter['shareType']) && $filter['shareType'] == 'share_num_site') selected="selected"@endif>
                                场地费共享
                            </option>
                        </select>
                    </td>


                    <td>
                        &nbsp;&nbsp;&nbsp;
                        <input type="button" id="viewBtn" class="formButton" value="查询" hidefocus onclick="doSearch()"/>
                    </td>
                    <td>
                        <input type="button" class="formButton" value="导出" onclick="doExport()"
                               @if(isset($siteStats)) style="display: inline;" @endif style="display: none;"/>
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
                    <th rowspan="3">
                        <a href="#" class="sort" name="" hidefocus>@if(isset($filter)){{$filter['year']}}@endif
                            年@if(isset($filter)){{$filter['endMonth']}}@endif月末新建塔累计到达数</a>
                    </th>
                    <th colspan="3">
                        <a href="#" class="sort" name="" hidefocus>季度累计新建塔（个）</a>
                    </th>
                    <th rowspan="3">
                        <a href="#" class="sort" name="" hidefocus>当年新建共享率</a>
                    </th>
                    <th colspan="4" rowspan="2">
                        <a href="#" class="sort" name="" hidefocus>@if(isset($filter)){{$filter['year']}}@endif
                            年初已交付新建塔</a>
                    </th>
                    <th rowspan="3">
                        <a href="#" class="sort" name="" hidefocus>累计新建共享率</a>
                    </th>
                    <th colspan="10">
                        <a href="#" class="sort" name="" hidefocus>新建单塔年均服务费（万元）</a>
                    </th>
                    <th colspan="5">
                        <a href="#" class="sort" name="" hidefocus>@if(isset($filter)){{$filter['year']}}@endif
                            年@if(isset($filter)){{$filter['beginMonth']}}@endif
                            月~@if(isset($filter)){{$filter['endMonth']}}@endif月累计运行费用（万元）</a>
                    </th>
                </tr>
                <tr>

                    <th colspan="2">
                        <a href="#" class="sort" name="" hidefocus>
                            新建共享</a>
                    </th>
                    <th rowspan="2">
                        <a href="#" class="sort" name="" hidefocus>新建独享</a>
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
                        <a href="#" class="sort" name="" hidefocus>其中：机房及配套费用</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>存量单塔年均服务费</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>单塔年均服务费</a>
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
                        <a href="#" class="sort" name="" hidefocus>存量合计</a>
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
                        <a href="#" class="sort" name="" hidefocus>年初交付合计</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>三共享</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>两共享</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>新建独享</a>
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
                @if(isset($siteStats))
                    <tr>
                        <th rowspan="11">
                            <a href="#" class="sort" name="" hidefocus>地面塔</a>
                        </th>
                        <th rowspan="5">
                            <a href="#" class="sort" name="" hidefocus>普通地面塔</a>
                        </th>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>H<30</a>
                        </th>
                        <td>{{$siteStats[0][0]}}</td>
                        <td>{{$siteStats[0][1]}}</td>
                        <td>{{$siteStats[0][2]}}</td>
                        <td>{{$siteStats[0][3]}}</td>
                        <td>{{formatNumber($siteStats[0][4]*100)}}%</td>
                        <td>{{$siteStats[0][5]}}</td>
                        <td>{{$siteStats[0][6]}}</td>
                        <td>{{$siteStats[0][7]}}</td>
                        <td>{{$siteStats[0][8]}}</td>
                        <td>{{formatNumber($siteStats[0][9]*100)}}%</td>
                        <td>{{$siteStats[0][10]}}</td>
                        <td>{{$siteStats[0][11]}}</td>
                        <td>{{$siteStats[0][12]}}</td>
                        <td>{{$siteStats[0][13]}}</td>
                        <td>{{formatNumber($siteStats[0][14]*100)}}%</td>
                        <td>{{formatNumber_wan($siteStats[0][15])}}</td>
                        <td>{{formatNumber_wan($siteStats[0][16])}}</td>
                        <td>{{formatNumber_wan($siteStats[0][17])}}</td>
                        <td>{{formatNumber_wan($siteStats[0][18])}}</td>
                        <td>{{formatNumber_wan($siteStats[0][19])}}</td>
                        <td>{{formatNumber_wan($siteStats[0][20])}}</td>
                        <td>{{formatNumber_wan($siteStats[0][21])}}</td>
                        <td>{{formatNumber_wan($siteStats[0][22])}}</td>
                        <td>{{formatNumber_wan($siteStats[0][23])}}</td>
                        <td>{{formatNumber_wan($siteStats[0][24])}}</td>
                        <td>{{formatNumber_wan($siteStats[0][25])}}</td>
                        <td>{{formatNumber_wan($siteStats[0][26])}}</td>
                        <td>{{formatNumber_wan($siteStats[0][27])}}</td>
                        <td>{{formatNumber_wan($siteStats[0][28])}}</td>
                        <td>{{formatNumber_wan($siteStats[0][29])}}</td>
                    </tr>
                    <tr>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>30≤H<35</a>
                        </th>
                        <td>{{$siteStats[1][0]}}</td>
                        <td>{{$siteStats[1][1]}}</td>
                        <td>{{$siteStats[1][2]}}</td>
                        <td>{{$siteStats[1][3]}}</td>
                        <td>{{formatNumber($siteStats[1][4]*100)}}%</td>
                        <td>{{$siteStats[1][5]}}</td>
                        <td>{{$siteStats[1][6]}}</td>
                        <td>{{$siteStats[1][7]}}</td>
                        <td>{{$siteStats[1][8]}}</td>
                        <td>{{formatNumber($siteStats[1][9]*100)}}%</td>
                        <td>{{$siteStats[1][10]}}</td>
                        <td>{{$siteStats[1][11]}}</td>
                        <td>{{$siteStats[1][12]}}</td>
                        <td>{{$siteStats[1][13]}}</td>
                        <td>{{formatNumber($siteStats[1][14]*100)}}%</td>
                        <td>{{formatNumber_wan($siteStats[1][15])}}</td>
                        <td>{{formatNumber_wan($siteStats[1][16])}}</td>
                        <td>{{formatNumber_wan($siteStats[1][17])}}</td>
                        <td>{{formatNumber_wan($siteStats[1][18])}}</td>
                        <td>{{formatNumber_wan($siteStats[1][19])}}</td>
                        <td>{{formatNumber_wan($siteStats[1][20])}}</td>
                        <td>{{formatNumber_wan($siteStats[1][21])}}</td>
                        <td>{{formatNumber_wan($siteStats[1][22])}}</td>
                        <td>{{formatNumber_wan($siteStats[1][23])}}</td>
                        <td>{{formatNumber_wan($siteStats[1][24])}}</td>
                        <td>{{formatNumber_wan($siteStats[1][25])}}</td>
                        <td>{{formatNumber_wan($siteStats[1][26])}}</td>
                        <td>{{formatNumber_wan($siteStats[1][27])}}</td>
                        <td>{{formatNumber_wan($siteStats[1][28])}}</td>
                        <td>{{formatNumber_wan($siteStats[1][29])}}</td>
                    </tr>
                    <tr>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>35≤H<40</a>
                        </th>
                        <td>{{$siteStats[2][0]}}</td>
                        <td>{{$siteStats[2][1]}}</td>
                        <td>{{$siteStats[2][2]}}</td>
                        <td>{{$siteStats[2][3]}}</td>
                        <td>{{formatNumber($siteStats[2][4])*100}}%</td>
                        <td>{{$siteStats[2][5]}}</td>
                        <td>{{$siteStats[2][6]}}</td>
                        <td>{{$siteStats[2][7]}}</td>
                        <td>{{$siteStats[2][8]}}</td>
                        <td>{{formatNumber($siteStats[2][9])*100}}%</td>
                        <td>{{$siteStats[2][10]}}</td>
                        <td>{{$siteStats[2][11]}}</td>
                        <td>{{$siteStats[2][12]}}</td>
                        <td>{{$siteStats[2][13]}}</td>
                        <td>{{formatNumber($siteStats[2][14])*100}}%</td>
                        <td>{{formatNumber_wan($siteStats[2][15])}}</td>
                        <td>{{formatNumber_wan($siteStats[2][16])}}</td>
                        <td>{{formatNumber_wan($siteStats[2][17])}}</td>
                        <td>{{formatNumber_wan($siteStats[2][18])}}</td>
                        <td>{{formatNumber_wan($siteStats[2][19])}}</td>
                        <td>{{formatNumber_wan($siteStats[2][20])}}</td>
                        <td>{{formatNumber_wan($siteStats[2][21])}}</td>
                        <td>{{formatNumber_wan($siteStats[2][22])}}</td>
                        <td>{{formatNumber_wan($siteStats[2][23])}}</td>
                        <td>{{formatNumber_wan($siteStats[2][24])}}</td>
                        <td>{{formatNumber_wan($siteStats[2][25])}}</td>
                        <td>{{formatNumber_wan($siteStats[2][26])}}</td>
                        <td>{{formatNumber_wan($siteStats[2][27])}}</td>
                        <td>{{formatNumber_wan($siteStats[2][28])}}</td>
                        <td>{{formatNumber_wan($siteStats[2][29])}}</td>
                    </tr>
                    <tr>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>40≤H<45</a>
                        </th>
                        <td>{{$siteStats[3][0]}}</td>
                        <td>{{$siteStats[3][1]}}</td>
                        <td>{{$siteStats[3][2]}}</td>
                        <td>{{$siteStats[3][3]}}</td>
                        <td>{{formatNumber($siteStats[3][4]*100)}}%</td>
                        <td>{{$siteStats[3][5]}}</td>
                        <td>{{$siteStats[3][6]}}</td>
                        <td>{{$siteStats[3][7]}}</td>
                        <td>{{$siteStats[3][8]}}</td>
                        <td>{{formatNumber($siteStats[3][9]*100)}}%</td>
                        <td>{{$siteStats[3][10]}}</td>
                        <td>{{$siteStats[3][11]}}</td>
                        <td>{{$siteStats[3][12]}}</td>
                        <td>{{$siteStats[3][13]}}</td>
                        <td>{{formatNumber($siteStats[3][14]*100)}}%</td>
                        <td>{{formatNumber_wan($siteStats[3][15])}}</td>
                        <td>{{formatNumber_wan($siteStats[3][16])}}</td>
                        <td>{{formatNumber_wan($siteStats[3][17])}}</td>
                        <td>{{formatNumber_wan($siteStats[3][18])}}</td>
                        <td>{{formatNumber_wan($siteStats[3][19])}}</td>
                        <td>{{formatNumber_wan($siteStats[3][20])}}</td>
                        <td>{{formatNumber_wan($siteStats[3][21])}}</td>
                        <td>{{formatNumber_wan($siteStats[3][22])}}</td>
                        <td>{{formatNumber_wan($siteStats[3][23])}}</td>
                        <td>{{formatNumber_wan($siteStats[3][24])}}</td>
                        <td>{{formatNumber_wan($siteStats[3][25])}}</td>
                        <td>{{formatNumber_wan($siteStats[3][26])}}</td>
                        <td>{{formatNumber_wan($siteStats[3][27])}}</td>
                        <td>{{formatNumber_wan($siteStats[3][28])}}</td>
                        <td>{{formatNumber_wan($siteStats[3][29])}}</td>
                    </tr>
                    <tr>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>45≤H≤50</a>
                        </th>
                        <td>{{$siteStats[4][0]}}</td>
                        <td>{{$siteStats[4][1]}}</td>
                        <td>{{$siteStats[4][2]}}</td>
                        <td>{{$siteStats[4][3]}}</td>
                        <td>{{formatNumber($siteStats[4][4]*100)}}%</td>
                        <td>{{$siteStats[4][5]}}</td>
                        <td>{{$siteStats[4][6]}}</td>
                        <td>{{$siteStats[4][7]}}</td>
                        <td>{{$siteStats[4][8]}}</td>
                        <td>{{formatNumber($siteStats[4][9]*100)}}%</td>
                        <td>{{$siteStats[4][10]}}</td>
                        <td>{{$siteStats[4][11]}}</td>
                        <td>{{$siteStats[4][12]}}</td>
                        <td>{{$siteStats[4][13]}}</td>
                        <td>{{formatNumber($siteStats[4][14]*100)}}%</td>
                        <td>{{formatNumber_wan($siteStats[4][15])}}</td>
                        <td>{{formatNumber_wan($siteStats[4][16])}}</td>
                        <td>{{formatNumber_wan($siteStats[4][17])}}</td>
                        <td>{{formatNumber_wan($siteStats[4][18])}}</td>
                        <td>{{formatNumber_wan($siteStats[4][19])}}</td>
                        <td>{{formatNumber_wan($siteStats[4][20])}}</td>
                        <td>{{formatNumber_wan($siteStats[4][21])}}</td>
                        <td>{{formatNumber_wan($siteStats[4][22])}}</td>
                        <td>{{formatNumber_wan($siteStats[4][23])}}</td>
                        <td>{{formatNumber_wan($siteStats[4][24])}}</td>
                        <td>{{formatNumber_wan($siteStats[4][25])}}</td>
                        <td>{{formatNumber_wan($siteStats[4][26])}}</td>
                        <td>{{formatNumber_wan($siteStats[4][27])}}</td>
                        <td>{{formatNumber_wan($siteStats[4][28])}}</td>
                        <td>{{formatNumber_wan($siteStats[4][29])}}</td>
                    </tr>
                    <tr>
                        <th rowspan="5">
                            <a href="#" class="sort" name="" hidefocus>灯杆景观塔</a>
                        </th>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>H<20</a>
                        </th>
                        <td>{{$siteStats[5][0]}}</td>
                        <td>{{$siteStats[5][1]}}</td>
                        <td>{{$siteStats[5][2]}}</td>
                        <td>{{$siteStats[5][3]}}</td>
                        <td>{{formatNumber($siteStats[5][4]*100)}}%</td>
                        <td>{{$siteStats[5][5]}}</td>
                        <td>{{$siteStats[5][6]}}</td>
                        <td>{{$siteStats[5][7]}}</td>
                        <td>{{$siteStats[5][8]}}</td>
                        <td>{{formatNumber($siteStats[5][9]*100)}}%</td>
                        <td>{{$siteStats[5][10]}}</td>
                        <td>{{$siteStats[5][11]}}</td>
                        <td>{{$siteStats[5][12]}}</td>
                        <td>{{$siteStats[5][13]}}</td>
                        <td>{{formatNumber($siteStats[5][14]*100)}}%</td>
                        <td>{{formatNumber_wan($siteStats[5][15])}}</td>
                        <td>{{formatNumber_wan($siteStats[5][16])}}</td>
                        <td>{{formatNumber_wan($siteStats[5][17])}}</td>
                        <td>{{formatNumber_wan($siteStats[5][18])}}</td>
                        <td>{{formatNumber_wan($siteStats[5][19])}}</td>
                        <td>{{formatNumber_wan($siteStats[5][20])}}</td>
                        <td>{{formatNumber_wan($siteStats[5][21])}}</td>
                        <td>{{formatNumber_wan($siteStats[5][22])}}</td>
                        <td>{{formatNumber_wan($siteStats[5][23])}}</td>
                        <td>{{formatNumber_wan($siteStats[5][24])}}</td>
                        <td>{{formatNumber_wan($siteStats[5][25])}}</td>
                        <td>{{formatNumber_wan($siteStats[5][26])}}</td>
                        <td>{{formatNumber_wan($siteStats[5][27])}}</td>
                        <td>{{formatNumber_wan($siteStats[5][28])}}</td>
                        <td>{{formatNumber_wan($siteStats[5][29])}}</td>
                    </tr>
                    <tr>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>20≤H<25</a>
                        </th>
                        <td>{{$siteStats[6][0]}}</td>
                        <td>{{$siteStats[6][1]}}</td>
                        <td>{{$siteStats[6][2]}}</td>
                        <td>{{$siteStats[6][3]}}</td>
                        <td>{{formatNumber($siteStats[6][4]*100)}}%</td>
                        <td>{{$siteStats[6][5]}}</td>
                        <td>{{$siteStats[6][6]}}</td>
                        <td>{{$siteStats[6][7]}}</td>
                        <td>{{$siteStats[6][8]}}</td>
                        <td>{{formatNumber($siteStats[6][9]*100)}}%</td>
                        <td>{{$siteStats[6][10]}}</td>
                        <td>{{$siteStats[6][11]}}</td>
                        <td>{{$siteStats[6][12]}}</td>
                        <td>{{$siteStats[6][13]}}</td>
                        <td>{{formatNumber($siteStats[6][14]*100)}}%</td>
                        <td>{{formatNumber_wan($siteStats[6][15])}}</td>
                        <td>{{formatNumber_wan($siteStats[6][16])}}</td>
                        <td>{{formatNumber_wan($siteStats[6][17])}}</td>
                        <td>{{formatNumber_wan($siteStats[6][18])}}</td>
                        <td>{{formatNumber_wan($siteStats[6][19])}}</td>
                        <td>{{formatNumber_wan($siteStats[6][20])}}</td>
                        <td>{{formatNumber_wan($siteStats[6][21])}}</td>
                        <td>{{formatNumber_wan($siteStats[6][22])}}</td>
                        <td>{{formatNumber_wan($siteStats[6][23])}}</td>
                        <td>{{formatNumber_wan($siteStats[6][24])}}</td>
                        <td>{{formatNumber_wan($siteStats[6][25])}}</td>
                        <td>{{formatNumber_wan($siteStats[6][26])}}</td>
                        <td>{{formatNumber_wan($siteStats[6][27])}}</td>
                        <td>{{formatNumber_wan($siteStats[6][28])}}</td>
                        <td>{{formatNumber_wan($siteStats[6][29])}}</td>
                    </tr>
                    <tr>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>25≤H<30</a>
                        </th>
                        <td>{{$siteStats[7][0]}}</td>
                        <td>{{$siteStats[7][1]}}</td>
                        <td>{{$siteStats[7][2]}}</td>
                        <td>{{$siteStats[7][3]}}</td>
                        <td>{{formatNumber($siteStats[7][4]*100)}}%</td>
                        <td>{{$siteStats[7][5]}}</td>
                        <td>{{$siteStats[7][6]}}</td>
                        <td>{{$siteStats[7][7]}}</td>
                        <td>{{$siteStats[7][8]}}</td>
                        <td>{{formatNumber($siteStats[7][9]*100)}}%</td>
                        <td>{{$siteStats[7][10]}}</td>
                        <td>{{$siteStats[7][11]}}</td>
                        <td>{{$siteStats[7][12]}}</td>
                        <td>{{$siteStats[7][13]}}</td>
                        <td>{{formatNumber($siteStats[7][14]*100)}}%</td>
                        <td>{{formatNumber_wan($siteStats[7][15])}}</td>
                        <td>{{formatNumber_wan($siteStats[7][16])}}</td>
                        <td>{{formatNumber_wan($siteStats[7][17])}}</td>
                        <td>{{formatNumber_wan($siteStats[7][18])}}</td>
                        <td>{{formatNumber_wan($siteStats[7][19])}}</td>
                        <td>{{formatNumber_wan($siteStats[7][20])}}</td>
                        <td>{{formatNumber_wan($siteStats[7][21])}}</td>
                        <td>{{formatNumber_wan($siteStats[7][22])}}</td>
                        <td>{{formatNumber_wan($siteStats[7][23])}}</td>
                        <td>{{formatNumber_wan($siteStats[7][24])}}</td>
                        <td>{{formatNumber_wan($siteStats[7][25])}}</td>
                        <td>{{formatNumber_wan($siteStats[7][26])}}</td>
                        <td>{{formatNumber_wan($siteStats[7][27])}}</td>
                        <td>{{formatNumber_wan($siteStats[7][28])}}</td>
                        <td>{{formatNumber_wan($siteStats[7][29])}}</td>
                    </tr>
                    <tr>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>30≤H<35</a>
                        </th>
                        <td>{{$siteStats[8][0]}}</td>
                        <td>{{$siteStats[8][1]}}</td>
                        <td>{{$siteStats[8][2]}}</td>
                        <td>{{$siteStats[8][3]}}</td>
                        <td>{{formatNumber($siteStats[8][4]*100)}}%</td>
                        <td>{{$siteStats[8][5]}}</td>
                        <td>{{$siteStats[8][6]}}</td>
                        <td>{{$siteStats[8][7]}}</td>
                        <td>{{$siteStats[8][8]}}</td>
                        <td>{{formatNumber($siteStats[8][9]*100)}}%</td>
                        <td>{{$siteStats[8][10]}}</td>
                        <td>{{$siteStats[8][11]}}</td>
                        <td>{{$siteStats[8][12]}}</td>
                        <td>{{$siteStats[8][13]}}</td>
                        <td>{{formatNumber($siteStats[8][14]*100)}}%</td>
                        <td>{{formatNumber_wan($siteStats[8][15])}}</td>
                        <td>{{formatNumber_wan($siteStats[8][16])}}</td>
                        <td>{{formatNumber_wan($siteStats[8][17])}}</td>
                        <td>{{formatNumber_wan($siteStats[8][18])}}</td>
                        <td>{{formatNumber_wan($siteStats[8][19])}}</td>
                        <td>{{formatNumber_wan($siteStats[8][20])}}</td>
                        <td>{{formatNumber_wan($siteStats[8][21])}}</td>
                        <td>{{formatNumber_wan($siteStats[8][22])}}</td>
                        <td>{{formatNumber_wan($siteStats[8][23])}}</td>
                        <td>{{formatNumber_wan($siteStats[8][24])}}</td>
                        <td>{{formatNumber_wan($siteStats[8][25])}}</td>
                        <td>{{formatNumber_wan($siteStats[8][26])}}</td>
                        <td>{{formatNumber_wan($siteStats[8][27])}}</td>
                        <td>{{formatNumber_wan($siteStats[8][28])}}</td>
                        <td>{{formatNumber_wan($siteStats[8][29])}}</td>
                    </tr>
                    <tr>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>35≤H≤40</a>
                        </th>
                        <td>{{$siteStats[9][0]}}</td>
                        <td>{{$siteStats[9][1]}}</td>
                        <td>{{$siteStats[9][2]}}</td>
                        <td>{{$siteStats[9][3]}}</td>
                        <td>{{formatNumber($siteStats[9][4]*100)}}%</td>
                        <td>{{$siteStats[9][5]}}</td>
                        <td>{{$siteStats[9][6]}}</td>
                        <td>{{$siteStats[9][7]}}</td>
                        <td>{{$siteStats[9][8]}}</td>
                        <td>{{formatNumber($siteStats[9][9]*100)}}%</td>
                        <td>{{$siteStats[9][10]}}</td>
                        <td>{{$siteStats[9][11]}}</td>
                        <td>{{$siteStats[9][12]}}</td>
                        <td>{{$siteStats[9][13]}}</td>
                        <td>{{formatNumber($siteStats[9][14]*100)}}%</td>
                        <td>{{formatNumber_wan($siteStats[9][15])}}</td>
                        <td>{{formatNumber_wan($siteStats[9][16])}}</td>
                        <td>{{formatNumber_wan($siteStats[9][17])}}</td>
                        <td>{{formatNumber_wan($siteStats[9][18])}}</td>
                        <td>{{formatNumber_wan($siteStats[9][19])}}</td>
                        <td>{{formatNumber_wan($siteStats[9][20])}}</td>
                        <td>{{formatNumber_wan($siteStats[9][21])}}</td>
                        <td>{{formatNumber_wan($siteStats[9][22])}}</td>
                        <td>{{formatNumber_wan($siteStats[9][23])}}</td>
                        <td>{{formatNumber_wan($siteStats[9][24])}}</td>
                        <td>{{formatNumber_wan($siteStats[9][25])}}</td>
                        <td>{{formatNumber_wan($siteStats[9][26])}}</td>
                        <td>{{formatNumber_wan($siteStats[9][27])}}</td>
                        <td>{{formatNumber_wan($siteStats[9][28])}}</td>
                        <td>{{formatNumber_wan($siteStats[9][29])}}</td>
                    </tr>
                    <tr>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>简易灯杆塔</a>
                        </th>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>H≤20</a>
                        </th>
                        <td>{{$siteStats[10][0]}}</td>
                        <td>{{$siteStats[10][1]}}</td>
                        <td>{{$siteStats[10][2]}}</td>
                        <td>{{$siteStats[10][3]}}</td>
                        <td>{{formatNumber($siteStats[10][4]*100)}}%</td>
                        <td>{{$siteStats[10][5]}}</td>
                        <td>{{$siteStats[10][6]}}</td>
                        <td>{{$siteStats[10][7]}}</td>
                        <td>{{$siteStats[10][8]}}</td>
                        <td>{{formatNumber($siteStats[10][9]*100)}}%</td>
                        <td>{{$siteStats[10][10]}}</td>
                        <td>{{$siteStats[10][11]}}</td>
                        <td>{{$siteStats[10][12]}}</td>
                        <td>{{$siteStats[10][13]}}</td>
                        <td>{{formatNumber($siteStats[10][14]*100)}}%</td>
                        <td>{{formatNumber_wan($siteStats[10][15])}}</td>
                        <td>{{formatNumber_wan($siteStats[10][16])}}</td>
                        <td>{{formatNumber_wan($siteStats[10][17])}}</td>
                        <td>{{formatNumber_wan($siteStats[10][18])}}</td>
                        <td>{{formatNumber_wan($siteStats[10][19])}}</td>
                        <td>{{formatNumber_wan($siteStats[10][20])}}</td>
                        <td>{{formatNumber_wan($siteStats[10][21])}}</td>
                        <td>{{formatNumber_wan($siteStats[10][22])}}</td>
                        <td>{{formatNumber_wan($siteStats[10][23])}}</td>
                        <td>{{formatNumber_wan($siteStats[10][24])}}</td>
                        <td>{{formatNumber_wan($siteStats[10][25])}}</td>
                        <td>{{formatNumber_wan($siteStats[10][26])}}</td>
                        <td>{{formatNumber_wan($siteStats[10][27])}}</td>
                        <td>{{formatNumber_wan($siteStats[10][28])}}</td>
                        <td>{{formatNumber_wan($siteStats[10][29])}}</td>
                    </tr>
                    <tr>
                        <th rowspan="2">
                            <a href="#" class="sort" name="" hidefocus>楼面塔</a>
                        </th>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>普通楼面塔</a>
                        </th>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>-</a>
                        </th>
                        <td>{{$siteStats[11][0]}}</td>
                        <td>{{$siteStats[11][1]}}</td>
                        <td>{{$siteStats[11][2]}}</td>
                        <td>{{$siteStats[11][3]}}</td>
                        <td>{{formatNumber($siteStats[11][4]*100)}}%</td>
                        <td>{{$siteStats[11][5]}}</td>
                        <td>{{$siteStats[11][6]}}</td>
                        <td>{{$siteStats[11][7]}}</td>
                        <td>{{$siteStats[11][8]}}</td>
                        <td>{{formatNumber($siteStats[11][9]*100)}}%</td>
                        <td>{{$siteStats[11][10]}}</td>
                        <td>{{$siteStats[11][11]}}</td>
                        <td>{{$siteStats[11][12]}}</td>
                        <td>{{$siteStats[11][13]}}</td>
                        <td>{{formatNumber($siteStats[11][14]*100)}}%</td>
                        <td>{{formatNumber_wan($siteStats[11][15])}}</td>
                        <td>{{formatNumber_wan($siteStats[11][16])}}</td>
                        <td>{{formatNumber_wan($siteStats[11][17])}}</td>
                        <td>{{formatNumber_wan($siteStats[11][18])}}</td>
                        <td>{{formatNumber_wan($siteStats[11][19])}}</td>
                        <td>{{formatNumber_wan($siteStats[11][20])}}</td>
                        <td>{{formatNumber_wan($siteStats[11][21])}}</td>
                        <td>{{formatNumber_wan($siteStats[11][22])}}</td>
                        <td>{{formatNumber_wan($siteStats[11][23])}}</td>
                        <td>{{formatNumber_wan($siteStats[11][24])}}</td>
                        <td>{{formatNumber_wan($siteStats[11][25])}}</td>
                        <td>{{formatNumber_wan($siteStats[11][26])}}</td>
                        <td>{{formatNumber_wan($siteStats[11][27])}}</td>
                        <td>{{formatNumber_wan($siteStats[11][28])}}</td>
                        <td>{{formatNumber_wan($siteStats[11][29])}}</td>
                    </tr>
                    <tr>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>楼面抱杆</a>
                        </th>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>-</a>
                        </th>
                        <td>{{$siteStats[12][0]}}</td>
                        <td>{{$siteStats[12][1]}}</td>
                        <td>{{$siteStats[12][2]}}</td>
                        <td>{{$siteStats[12][3]}}</td>
                        <td>{{formatNumber($siteStats[12][4]*100)}}%</td>
                        <td>{{$siteStats[12][5]}}</td>
                        <td>{{$siteStats[12][6]}}</td>
                        <td>{{$siteStats[12][7]}}</td>
                        <td>{{$siteStats[12][8]}}</td>
                        <td>{{formatNumber($siteStats[12][9]*100)}}%</td>
                        <td>{{$siteStats[12][10]}}</td>
                        <td>{{$siteStats[12][11]}}</td>
                        <td>{{$siteStats[12][12]}}</td>
                        <td>{{$siteStats[12][13]}}</td>
                        <td>{{formatNumber($siteStats[12][14]*100)}}%</td>
                        <td>{{formatNumber_wan($siteStats[12][15])}}</td>
                        <td>{{formatNumber_wan($siteStats[12][16])}}</td>
                        <td>{{formatNumber_wan($siteStats[12][17])}}</td>
                        <td>{{formatNumber_wan($siteStats[12][18])}}</td>
                        <td>{{formatNumber_wan($siteStats[12][19])}}</td>
                        <td>{{formatNumber_wan($siteStats[12][20])}}</td>
                        <td>{{formatNumber_wan($siteStats[12][21])}}</td>
                        <td>{{formatNumber_wan($siteStats[12][22])}}</td>
                        <td>{{formatNumber_wan($siteStats[12][23])}}</td>
                        <td>{{formatNumber_wan($siteStats[12][24])}}</td>
                        <td>{{formatNumber_wan($siteStats[12][25])}}</td>
                        <td>{{formatNumber_wan($siteStats[12][26])}}</td>
                        <td>{{formatNumber_wan($siteStats[12][27])}}</td>
                        <td>{{formatNumber_wan($siteStats[12][28])}}</td>
                        <td>{{formatNumber_wan($siteStats[12][29])}}</td>
                    </tr>
                    <tr>
                        <th colspan="3">
                            合计
                        </th>
                        <td>{{$siteStats[13][0]}}</td>
                        <td>{{$siteStats[13][1]}}</td>
                        <td>{{$siteStats[13][2]}}</td>
                        <td>{{$siteStats[13][3]}}</td>
                        <td>{{formatNumber($siteStats[13][4]*100)}}%</td>
                        <td>{{$siteStats[13][5]}}</td>
                        <td>{{$siteStats[13][6]}}</td>
                        <td>{{$siteStats[13][7]}}</td>
                        <td>{{$siteStats[13][8]}}</td>
                        <td>{{formatNumber($siteStats[13][9]*100)}}%</td>
                        <td>{{$siteStats[13][10]}}</td>
                        <td>{{$siteStats[13][11]}}</td>
                        <td>{{$siteStats[13][12]}}</td>
                        <td>{{$siteStats[13][13]}}</td>
                        <td>{{formatNumber($siteStats[13][14]*100)}}%</td>
                        <td>{{formatNumber_wan($siteStats[13][15])}}</td>
                        <td>{{formatNumber_wan($siteStats[13][16])}}</td>
                        <td>{{formatNumber_wan($siteStats[13][17])}}</td>
                        <td>{{formatNumber_wan($siteStats[13][18])}}</td>
                        <td>{{formatNumber_wan($siteStats[13][19])}}</td>
                        <td>{{formatNumber_wan($siteStats[13][20])}}</td>
                        <td>{{formatNumber_wan($siteStats[13][21])}}</td>
                        <td>{{formatNumber_wan($siteStats[13][22])}}</td>
                        <td>{{formatNumber_wan($siteStats[13][23])}}</td>
                        <td>{{formatNumber_wan($siteStats[13][24])}}</td>
                        <td>{{formatNumber_wan($siteStats[13][25])}}</td>
                        <td>{{formatNumber_wan($siteStats[13][26])}}</td>
                        <td>{{formatNumber_wan($siteStats[13][27])}}</td>
                        <td>{{formatNumber_wan($siteStats[13][28])}}</td>
                        <td>{{formatNumber_wan($siteStats[13][29])}}</td>
                        </td>
                    </tr>
                @endif


            </table>


        </div>


    </div>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {
            $('#menu_bill').addClass("current");
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
            listForm.action = "{{url('backend/siteStats/export')}}";
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