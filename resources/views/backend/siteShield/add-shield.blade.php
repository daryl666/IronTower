@extends('layouts.app')

@section('header')
    <title>填报屏蔽申请</title>
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
                        <li class="active">
                            <a href="{{url('backend/siteShield/checkShieldPage?region=').Auth::user()->area_level.'&checkStatus=1&reqType=0&beginDate=&endDate='}}">屏蔽审核</a>
                        </li>
                    @endif
                    @if(Auth::user()->area_level != '湖北省')
                        <li class="active">
                            <a href="{{url('backend/siteShield/addShieldPage?region=').Auth::user()->area_level.'&checkStatus=1&reqType=0&beginDate=&endDate='}}">屏蔽申请</a>
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
                    <li class="inactive">
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
                        <a href="#">屏蔽申请</a>
                    </li>
                </ul>


            </div>
        </div>

    </div>

    <body class="input managerInfo">
    <div class="bar">
        <div style="float:left;">
            请填报屏蔽申请
        </div>

    </div>
    <div id="validateErrorContainer" class="validateErrorContainer">

    </div>

    <form id="listForm" method="POST" action="{{url('backend/siteCheck/handle')}}" enctype="multipart/form-data"  style="display: inline;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <table class="inputTable tabContent">
            <tr>
                <th>地市(*必填项)：</th>
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
                <th>基站编号(*必填项)：</th>
                <td>
                    <input type="text" name="stationCode" id="stationCode">
                </td>
            </tr>
            <tr>
                <th>基站名称(*必填项)：</th>
                <td>
                    <input type="text" name="stationName" id="stationName">
                </td>
            </tr>
            <tr>
                <th>基站等级(*必填项)：</th>
                <td>
                    <select name="stationLevel" id="stationLevel">
                        <option>A</option>
                        <option>B</option>
                        <option>C</option>
                        <option>D</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>屏蔽开始时间(*必填项)：</th>
                <td>
                    <input type="text" name="shieldStartTime" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"
                           readonly value="{{date('Y-m-d H:i:s', time())}}">
                </td>
            </tr>
            <tr>
                <th>屏蔽申请理由(*必填项)：</th>
                <td>
                    <select name="shieldReason" onchange="doChangeReason(this)">
                        <option>故障</option>
                        <option>拆迁</option>
                        <option>拆迁还建</option>
                    </select>
                </td>
            </tr>
            <tr name="demTr" style="display: none;">
                <th>拆迁原因(*必填项)：</th>
                <td>
                    <select name="demReason" id="demReason" disabled="disabled">
                        <option>物业纠纷</option>
                        <option>市政建设</option>
                        <option>自然灾害</option>
                    </select>
                </td>
            </tr>
            <tr name="demTr" style="display: none;">
                <th>拆迁开始时间(*必填项)：</th>
                <td>
                    <input type="text" name="demStartTime" id="demStartTime" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:00:00'})" readonly
                           value="{{date('Y-m-d H:00:00', time())}}" disabled="disabled">
                </td>
            </tr>
            <tr name="demTr" style="display: none;">
                <th>预计拆迁结束时间(*必填项)：</th>
                <td>
                    <input type="text" name="estDemEndTime" id="estDemEndTime" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:00:00'})" readonly
                           value="{{date('Y-m-d H:00:00', time())}}" disabled="disabled">
                </td>
            </tr>
            <tr>
                <th>附件(*必填项)：</th>
                <td>
                    <input id="siteShieldAttachment" name="siteShieldAttachment" style="width: 170px" type="file">
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
            $('#menu_business').addClass("current");
        });

        function doBack() {
            var listForm = document.getElementById('listForm');
            listForm.action = "{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}";
            listForm.submit();
        }

        function doChangeReason(osel) {
            if (osel.value != '故障') {
                var demReason = document.getElementById('demReason');
                var demStartTime = document.getElementById('demStartTime');
                var estDemEndTime = document.getElementById('estDemEndTime');
                demReason.disabled = '';
                demStartTime.disabled = '';
                estDemEndTime.disabled = '';
                var demTr = document.getElementsByName('demTr');
                for (var i = 0; i < demTr.length; i++) {
                    demTr[i].style.display = 'table-row';
                }
            }else {
                var demReason = document.getElementById('demReason');
                var demStartTime = document.getElementById('demStartTime');
                var estDemEndTime = document.getElementById('estDemEndTime');
                demReason.disabled = 'disabled';
                demStartTime.disabled = 'disabled';
                estDemEndTime.disabled = 'disabled';
                var demTr = document.getElementsByName('demTr');
                for (var i = 0; i < demTr.length; i++) {
                    demTr[i].style.display = 'none';
                }
            }
        }

        function doAdd() {
            var stationCode = $('#stationCode').val();
            var stationName = $('#stationName').val();
            if (stationCode == ''){
                alert('请输入基站编号！');
                return;
            }
            if (stationName == ''){
                alert('请输入基站名称！');
                return;
            }
            var listForm = document.getElementById('listForm');
            listForm.action = "{{url('backend/siteShield/addShield')}}";
            listForm.submit();

        }


    </script>
@endsection







