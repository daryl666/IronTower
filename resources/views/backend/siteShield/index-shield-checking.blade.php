@extends('layouts.app')

@section('header')
    <title>屏蔽记录查询</title>
@endsection

@section('script_header')

@endsection


@section('content')

    <div class="container" style="width:100% ">
        <div class="row clearfix">
            <div class="col-md-12 column" style="padding: 0">
                <ul class="nav nav-tabs" style="font-size: 13px">
                    <li class="inactive">
                        <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">站址信息管理</a>
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/gnrRec?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">发电记录管理</a>
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">上站记录管理</a>
                    </li>
                    <li class="active">
                        @if(Auth::user()->area_level == '湖北省')
                            <a href="{{url('backend/siteShield/checkShieldPage?region=').Auth::user()->area_level.'&checkStatus=2&reqType=0&beginDate=&endDate='}}">屏蔽记录管理</a>@endif
                        @if(Auth::user()->area_level != '湖北省')
                            <a href="{{url('backend/siteShield/addShieldPage')}}">屏蔽记录管理</a>@endif
                    </li>

                    <li class="inactive">
                        <a href="{{url('backend/osReasonFill?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">退服原因管理</a>
                    </li>
                </ul>
                <ul class="nav-tabs-2">
                    @if(Auth::user()->area_level == '湖北省')
                        <li class="inactive">
                            <a href="{{url('backend/siteShield/checkShieldPage?region=').Auth::user()->area_level.'&checkStatus=1&reqType=0&beginDate=&endDate='}}">屏蔽审核</a>
                        </li>
                    @endif
                    @if(Auth::user()->area_level != '湖北省')
                        <li class="inactive">
                            <a href="{{url('backend/siteShield/addShieldPage')}}">屏蔽申请</a>
                        </li>
                    @endif
                    @if(Auth::user()->area_level == '湖北省')
                        <li class="inactive">
                            <a href="{{url('backend/siteShield/checkUnshieldPage?region=').Auth::user()->area_level.'&checkStatus=1&reqType=1&beginDate=&endDate='}}">解屏蔽审核</a>
                        </li>
                    @endif
                    @if(Auth::user()->area_level != '湖北省')
                        <li class="inactive">
                            <a href="{{url('backend/siteShield/shieldCheckingPage?region=').Auth::user()->area_level.'&checkStatus=2&reqType=0&beginDate=&endDate='}}">解屏蔽申请</a>
                        </li>
                    @endif
                    <li class="active">
                        <a href="{{url('backend/siteShield/shieldPage?region=').Auth::user()->area_level.'&checkStatus=1&reqType=0&beginDate=&endDate='}}">屏蔽记录查询</a>
                    </li>
                    <li class="inactive" style="float: none">
                        <a href="{{url('backend/siteShield/unshieldPage?region=').Auth::user()->area_level.'&checkStatus=1&reqType=1&beginDate=&endDate='}}">解屏蔽记录查询</a>
                    </li>

                </ul>
                <ul class="breadcrumb" style="margin-bottom: 0;background-color: #F5F5F5">
                    当前位置：
                    <li>
                        <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">业务管理</a>
                    </li>
                    <li>
                        @if(Auth::user()->area_level == '湖北省')                             <a href="{{url('backend/siteShield/checkShieldPage?region=').Auth::user()->area_level.'&checkStatus=2&reqType=0&beginDate=&endDate='}}">屏蔽记录管理</a>@endif                         @if(Auth::user()->area_level != '湖北省')                             <a href="{{url('backend/siteShield/addShieldPage')}}">屏蔽记录管理</a>@endif
                    </li>
                    <li class="active">
                        <a href="#">屏蔽记录查询</a>
                    </li>
                </ul>


            </div>
        </div>

    </div>

    <div class="list">
        <div class="body">
            <form id="listForm" method="post" action="{{url('backend/siteShield')}}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="listBar">
                    <label style="margin-bottom:10px">选择起止月份和地市来查屏蔽记录：</label><br>

                    <td>
                        统计起始时间:
                        <input type="text" id="beginDate" name="beginDate" style="width:130px;padding-left:5px"
                               readonly="true"
                               @if(isset($filter['beginDate'])) value="{{$filter['beginDate']}}" @endif
                               onclick="WdatePicker({dateFmt:'yyyy-MM'})"/>
                        ~
                        统计结束时间:
                        <input type="text" id="endDate" name="endDate" style="width:130px;padding-left:5px"
                               readonly="true"
                               @if(isset($filter['endDate'])) value="{{$filter['endDate']}}" @endif
                               onclick="WdatePicker({dateFmt:'yyyy-MM'})"/>
                    </td>
                    <td>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        地市：
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
                        &nbsp;&nbsp;&nbsp;&nbsp;审核状态：
                        <input type="radio" name="checkStatus" value="1" checked="checked"/>待审核
                        <input type="radio" name="checkStatus" value="2"/>审核通过
                        <input type="radio" name="checkStatus" value="3"/>审核不通过
                    </td>
                    {{--<td>--}}
                        {{--&nbsp;&nbsp;&nbsp;&nbsp;记录类型：--}}
                        {{--<input type="radio" name="reqType" value="0" checked="checked"/>屏蔽记录--}}
                        {{--<input type="radio" name="reqType" value="1"/>解屏蔽记录--}}
                    {{--</td>--}}
                    <td>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" id="searchBtn" class="formButton" value="搜 索"
                               onclick="doSearch()"/>
                    </td>
                    {{--<td style="float:right;margin-right:30px;">--}}
                        {{--<input type="button" class="formButton" value="新增记录" id="addBtn" style="float: right;"--}}
                               {{--onclick="doAddShieldPage()"/>--}}
                    {{--</td>--}}


                    {{--<td>--}}
                    {{--<input type="button" class="formButton" value="导出" onclick="doExport()" @if(isset($infoSites)) style="display: inline;" @endif style="display: none;"/>--}}
                    {{--</td>--}}

                </div>
            </form>
        </div>
        <div id="siteCheck">
            <table class="listTable" style="white-space:nowrap;font-size:12px;">

                <tr>
                    @if(Auth::user()->area_level != '湖北省')
                    <th>
                        <a href="#" class="sort" name="" hidefocus>操作</a>
                    </th>@endif
                    <th>
                        <a href="#" class="sort" name="" hidefocus>地市</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>基站编号</a>
                    </th>

                    <th>
                        <a href="#" class="sort" name="" hidefocus>基站名称</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>基站等级</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>屏蔽开始时间</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>屏蔽申请理由</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>拆迁原因</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>拆迁开始时间</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>预计拆迁结束时间</a>
                    </th>


                </tr>
                @if(isset($siteShields))
                    @foreach($siteShields as $siteShield)
                        <tr>
                            @if(Auth::user()->area_level != '湖北省')
                            <td>
                                <button class="buttonNextStep" onclick="doWithdraw({{$siteShield->id}})">撤回申请</button>
                                {{--@if(Auth::user()->area_level == '湖北省')--}}
                                    {{--<a href="javascript:void(0)" onclick="doApprove({{$siteShield->id}})">通过</a>&nbsp;&nbsp;&nbsp;--}}
                                    {{--<a href="javascript:void(0)" onclick="doDeny({{$siteShield->id}})">驳回</a>--}}
                                {{--@endif--}}
                            </td>@endif
                            <td>{{$siteShield->region_name}}</td>
                            <td>{{$siteShield->station_code}}</td>
                            <td>{{$siteShield->station_name}}</td>
                            <td>{{transStationLevel($siteShield->station_level)}}</td>
                            <td>{{$siteShield->shield_start_time}}</td>
                            <td>{{transShieldReason($siteShield->shield_reason)}}</td>
                            <td>
                                @if($siteShield->demolition_reason != null) {{transDemReason($siteShield->demolition_reason)}} @endif
                            </td>
                            <td>
                                @if($siteShield->demolition_start_time != null) {{$siteShield->demolition_start_time}} @endif
                            </td>
                            <td>
                                @if($siteShield->est_demolition_end_time != null) {{$siteShield->est_demolition_end_time}} @endif
                            </td>
                        </tr>
                    @endforeach
                        @if(isset($filter)){!! $siteShields->appends(['region' => $filter['region'],
                        'beginDate' => $filter['beginDate'],
                        'endDate' => $filter['endDate'],
                        'checkStatus' => $filter['checkStatus']])->links() !!}@endif
                @endif


            </table>


        </div>


    </div>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {

            $('#menu_business').addClass("current");
        });

        function doSearch() {
            var listForm = document.getElementById("listForm");
            var region = document.getElementById('region');
            var beginDate = document.getElementById('beginDate');
            var endDate = document.getElementById('endDate');
            var checkStatus = $('input[name="checkStatus"]:checked').val();
            var url = "{{url('backend/siteShield/shieldPage?region=')}}" + region + '&beginDate=' + beginDate + '&endDate=' + endDate + '&checkStatus=' + checkStatus;
            listForm.method = "GET";
            listForm.action = url;
            listForm.submit();
        }


        function doAddShieldPage() {
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/siteShield/addShieldPage')}}";
            listForm.submit();

        }

        function doSiteCheckPage() {
            var listForm = document.getElementById("listForm");
            listForm.method = 'get';
            listForm.action = "{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}";
            listForm.submit();
        }

        function doShieldPage() {
            var listForm = document.getElementById("listForm");
            listForm.method = 'get';
            listForm.action = "{{url('backend/siteShield')}}";
            listForm.submit();
        }

        function doTysysPage() {
            var listForm = document.getElementById("listForm");
            listForm.method = 'get';
            listForm.action = "{{url('backend/backend/osReasonFill')}}";
            listForm.submit();
        }
        
        function doWithdraw(id) {
            var listForm = document.getElementById("listForm");
            var url = "{{url('backend/siteShield/withdrawShield')}}" + '/' + id;
            listForm.action = url;
            listForm.submit();
        }

        function doApprove(id) {
            var listForm = document.getElementById("listForm");
            var url = "{{url('backend/siteShield/approveShield')}}" + '/' + id;
            listForm.action = url;
            listForm.submit();
        }

        function doDeny(id) {
            var listForm = document.getElementById("listForm");
            var url = "{{url('backend/siteShield/denyShield')}}" + '/' + id;
            listForm.action = url;
            listForm.submit();
        }

        function doExport() {
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/siteInfo/export')}}";
            listForm.submit();
        }

        function doImport() {
            var siteInfoFile = document.getElementById('siteInfoFile');
            if (siteInfoFile.value == "") {
                alert('请选择需要导入的文件');
                return;
            }
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/siteInfo/import')}}";
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