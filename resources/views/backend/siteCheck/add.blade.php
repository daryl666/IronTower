@extends('layouts.app')

@section('header')
    <title>新增上站申请</title>
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
                    <li class="inactive">
                        <a href="{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">上站记录查询</a>
                    </li>
                    <li class="active" style="float: none">
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
                        <a href="#">上站申请填报</a>
                    </li>
                </ul>


            </div>
        </div>

    </div>

    <body class="input managerInfo">
    <div class="bar">
        <div style="float:left;">
            请填报上站申请
        </div>

    </div>
    <div id="validateErrorContainer" class="validateErrorContainer">

    </div>

    <form id="listForm" method="POST" action="{{url('backend/siteCheck/handle')}}" style="display: inline;">
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
                <th>站址编码(*必填项)：</th>
                <td>
                    <input type="text" name="siteCode" id="siteCode">
                </td>
            </tr>
            <tr>
                <th>上站申请时间(*必填项)：</th>
                <td><input type="text" name="checkReqTime" id="checkReqTime" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" readonly value="{{date('Y-m-d H:i:s', time())}}">
                </td>
            </tr>
            <tr>
                <th>上站类型(*必填项)：</th>
                <td>
                    <select name="checkType" id="checkType">
                        <option>紧急上站</option>
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
            {{--var listForm = document.getElementById('listForm');--}}
            {{--listForm.action = "{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}";--}}
            {{--listForm.submit();--}}
            window.history.back();
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

        function doAdd() {
            var siteCode = $('#siteCode').val();
            if (siteCode == ''){
                alert('请输入站址编码！');
                return;
            }
            if (confirm('确认提交吗？')){
                var listForm = document.getElementById("listForm");
                listForm.action = "{{url('backend/siteCheck/add')}}";
                listForm.submit();
            }


        }




    </script>
@endsection







