@extends('layouts.app')

@section('header')
    <title>退服记录查询</title>
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
                    <li class="inactive">
                        @if(Auth::user()->area_level == '湖北省')
                            <a href="{{url('backend/siteShield/checkShieldPage?region=').Auth::user()->area_level.'&checkStatus=2&reqType=0&beginDate=&endDate='}}">屏蔽记录管理</a>@endif
                        @if(Auth::user()->area_level != '湖北省')
                            <a href="{{url('backend/siteShield/addShieldPage')}}">屏蔽记录管理</a>@endif
                    </li>

                    <li class="active">
                        <a href="{{url('backend/osReasonFill?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">退服原因管理</a>
                    </li>
                </ul>
                <ul class="nav-tabs-2">
                    <li class="active" style="float: none">
                        <a href="{{url('backend/osReasonFill?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">退服原因填报</a>
                    </li>

                </ul>
                <ul class="breadcrumb" style="margin-bottom: 0;background-color: #F5F5F5">
                    当前位置：
                    <li>
                        <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">业务管理</a>
                    </li>
                    <li>
                        <a href="{{url('backend/osReasonFill?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">退服原因管理</a>
                    </li>
                    <li class="active">
                        <a href="#">退服原因查询</a>
                    </li>
                </ul>


            </div>
        </div>

    </div>
    {{--<div class="bar" style="font-weight:bold;">--}}

        {{--<td style="padding-right: 100px">--}}
            {{--<input type="button" value="上站记录填报" onclick="doSiteCheckPage()" >--}}
            {{--<input type="button" value="屏蔽记录填报" onclick="doShieldPage()" >--}}
            {{--<input type="button" value="短时退服填报" onclick="doTysysPage()" >--}}
        {{--</td>--}}
    {{--</div>--}}

    <div class="list">
        <div class="body">
            <form id="listForm" method="post" action="{{url('osReason')}}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="listBar">
                    <label style="margin-bottom:10px">选择起止月份和地市来查看退服记录：</label><br>

                    <td>
                        统计起始时间:
                        <input type="text" id="beginDate" name="beginDate" style="width:130px;padding-left:5px"
                               readonly="true"
                               @if(isset($filter['beginDate'])) value="{{$filter['beginDate']}}" @endif
                               onclick="WdatePicker({dateFmt:'<yyy></yyy>y-MM'})"/>
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
                        &nbsp;&nbsp;&nbsp;&nbsp;处理状态：
                        <input type="radio" name="checkStatus" value="0"/>未处理
                        <input type="radio" name="checkStatus" value="1" checked="checked"/>已处理
                    </td>
                    <td>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" id="searchBtn" class="formButton" value="搜 索"
                               onclick="doSearch()"/>
                    </td>
                    <td>
                        <input type="button" class="formButton" value="导出" onclick="doExport()"
                        @if(isset($osReasons)) style="display: inline;" @endif style="display: none;"/>
                    </td>



                    {{--<td>--}}
                    {{--<input type="button" class="formButton" value="导出" onclick="doExport()" @if(isset($infoSites)) style="display: inline;" @endif style="display: none;"/>--}}
                    {{--</td>--}}

                </div>
            </form>
        </div>
        <div id="siteCheck">
            <table class="listTable" style="white-space:nowrap;font-size:12px;">

                <tr>

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
                        <a href="#" class="sort" name="" hidefocus>原始退服发生时间</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>原始退服消除时间</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>集团处理后退服发生时间</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>集团处理后退服消除时间</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>本次退服时间（分）</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>退服原因</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>退服详情</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>责任单位</a>
                    </th>

                </tr>
                @if(isset($osReasons))
                    @foreach($osReasons as $osReason)
                        <tr>
                            <td>{{$osReason->region_name}}</td>
                            <td>{{$osReason->station_code}}</td>
                            <td>{{$osReason->station_name}}</td>
                            <td>{{$osReason->station_level}}</td>
                            <td>{{$osReason->orig_os_start_time}}</td>
                            <td>{{$osReason->orig_os_end_time}}</td>
                            <td>{{$osReason->proc_os_start_time}}</td>
                            <td>{{$osReason->proc_os_end_time}}</td>
                            <td>{{$osReason->os_time}}</td>
                            <td>{{transOsReason($osReason->os_reason) }}</td>
                            <td>{{$osReason->os_detail}}</td>
                            <td>{{transRespUnit($osReason->response_unit) }}</td>
                        </tr>
                    @endforeach
                        @if(isset($filter))
                            {!! $osReasons
                            ->appends(['region' => $filter['region'],
                            'beginDate' => $filter['beginDate'],
                            'endDate' => $filter['endDate'],
                            'checkStatus' => $filter['checkStatus']])
                            ->links() !!}@endif
                @endif


            </table>


        </div>


    </div>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {

            var menu_business = document.getElementById('menu_business');
            menu_business.className = "current";
        });

        function doSearch() {
            var listForm = document.getElementById("listForm");
            var region = document.getElementById('region');
            var beginDate = document.getElementById('beginDate');
            var endDate = document.getElementById('endDate');
            var checkStatus = $('input[name="checkStatus"]:checked').val();
            var url = "{{url('backend/osReasonFill?region=')}}" + region + '&beginDate=' + beginDate + '&endDate=' + endDate + '&checkStatus=' + checkStatus;
            listForm.method = "GET";
            listForm.action = url;
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

        function doHandlePage() {
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/siteCheck/handlePage')}}";
            listForm.submit();

        }

        function doAddPage() {
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/siteCheck/addPage')}}";
            listForm.submit();

        }

        function doExport() {
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/osReasonFill/export')}}";
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
