@extends('layouts.app')

@section('header')
    <title>上站记录查询</title>
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
                    <li class="active">
                        <a href="{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">上站记录管理</a>
                    </li>
                    <li class="inactive">
                        @if(Auth::user()->area_level == '湖北省')                             <a href="{{url('backend/siteShield/checkShieldPage?region=').Auth::user()->area_level.'&checkStatus=2&reqType=0&beginDate=&endDate='}}">屏蔽记录管理</a>@endif                         @if(Auth::user()->area_level != '湖北省')                             <a href="{{url('backend/siteShield/addShieldPage')}}">屏蔽记录管理</a>@endif
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/osReasonFill?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">退服原因管理</a>
                    </li>
                </ul>
                <ul class="nav-tabs-2">
                    <li class="active">
                        <a href="{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">上站记录查询</a>
                    </li>
                    <li class="inactive" style="float: none">
                        <a href="{{url('backend/siteCheck/addPage')}}">上站申请填报</a>
                    </li>

                </ul>
                <ul class="breadcrumb" style="margin-bottom: 0;background-color: #F5F5F5">
                    当前位置：
                    <li>
                        <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">业务管理</a>
                    </li>
                    <li>
                        <a href="{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">上站记录管理</a>
                    </li>
                    <li class="active">
                        <a href="#">上站记录查询</a>
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
            <form id="listForm" method="post" action="{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="listBar">
                    <label style="margin-bottom:10px">选择起止月份和地市来查上站记录：</label><br>

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
                        &nbsp;&nbsp;&nbsp;&nbsp;处理状态：
                        <input type="radio" name="checkStatus" value="0"/>未处理
                        <input type="radio" name="checkStatus" value="1" checked="checked"/>已处理
                    </td>
                    <td>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" id="searchBtn" class="formButton" value="搜 索"
                               onclick="doSearch()"/>
                    </td>


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
                        <a href="#" class="sort" name="" hidefocus>站址编码</a>
                    </th>

                    <th>
                        <a href="#" class="sort" name="" hidefocus>上站申请时间</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>上站类型</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>上站结果</a>
                    </th>


                </tr>
                @if(isset($siteChecks))
                    @foreach($siteChecks as $siteCheck)
                        <tr>
                            <td>{{$siteCheck->region_name}}</td>
                            <td>{{$siteCheck->site_code}}</td>
                            <td>{{$siteCheck->check_req_time}}</td>
                            <td>{{$siteCheck->check_type}}</td>
                            <td>{{transSiteCheckResult($siteCheck->check_result)}}</td>
                        </tr>
                    @endforeach
                @endif
                @if(isset($filter))
                    {!! $siteChecks
                    ->appends(['region' => $filter['region'],
                    'beginDate' => $filter['beginDate'],
                    'endDate' => $filter['endDate'],
                    'checkStatus' => $filter['checkStatus']])
                    ->links() !!}@endif


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
            var url = "{{url('backend/siteCheck?region=')}}" + region + '&beginDate=' + beginDate + '&endDate=' + endDate + '&checkStatus=' + checkStatus;
            listForm.method = "GET";
            listForm.action = url;
            listForm.submit();
        }

        function doAddPage() {
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/siteCheck/addPage')}}";
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