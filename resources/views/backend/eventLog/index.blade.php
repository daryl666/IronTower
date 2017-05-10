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
                {{-- <div class="collapse navbar-collapse" id="example-navbar-collapse"> --}}                    <ul class="nav nav-tabs">
                        <li class="inactive">
                            <a href="{{url('backend/userManage')}}">用户管理</a>
                        </li>
                        <li class="active">
                            <a href="{{url('backend/eventLog?region=').Auth::user()->area_level.'&beginDate=&endDate='}}">日志管理</a>
                        </li>
                        <li class="inactive">
                            <a href="{{url('backend/rentStd')}}">计费标准管理</a>
                        </li>

                    </ul>
                    <ul class="breadcrumb" style="margin-bottom: 0;background-color: #F5F5F5">
                        当前位置：
                        <li>
                            <a href="{{url('backend/userManage')}}">系统管理</a>
                        </li>
                        <li class="active">
                            <a href="#">日志管理</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

    </div>




    <div class="list">
        <div class="body">
            <form id="listForm" method="post" action="{{url('backend/siteInfo/')}}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="listBar">
                    <td>
                        请选择地市和起始时间来查看日志信息：
                    </td>
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
                        <a href="#" class="sort" name="" hidefocus>时间</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>用户</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>操作</a>
                    </th>
                </tr>
                @if(isset($eventLogs))
                    @foreach($eventLogs as $eventLog)
                        <tr>
                            <td>{{$eventLog->created_at}}</td>
                            <td>{{$eventLog->operator}}</td>
                            <td>{{$eventLog->operation}}</td>

                        </tr>
                    @endforeach
                        @if(isset($filter))
                            {!! $eventLogs
                            ->appends(['region' => $filter['region'],
                            'beginDate' => $filter['beginDate'],
                            'endDate' => $filter['endDate']])
                            ->links() !!}@endif
                @endif


            </table>


        </div>


    </div>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {
            var menu_sys = document.getElementById('menu_sys');
            menu_sys.className = "current";
        });

        function doSearch() {
            var listForm = document.getElementById("listForm");
            var region = $('#region').val();
            var beginDate = $('#beginDate').val();
            var endDate = $('#endDate').val();
            var url = "{{url('backend/eventLog?region=')}}" + region + '&beginDate=' + beginDate + '&endDate=' + endDate;
            listForm.action = url;
            listForm.method = 'GET';
            listForm.submit();
        }

    </script>
@endsection