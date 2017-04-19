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
                </ul>
                <ul class="nav-tabs-2">
                    <li class="active">
                        <a href="{{url('backend/gnrRec?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">发电记录查询</a>
                    </li>
                    <li class="inactive" style="float: none">
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
                        <a href="#">发电结果填报</a>
                    </li>
                </ul>


            </div>
        </div>

    </div>

    <body class="input managerInfo">

    <form id="listForm" method="post" action="{{url('backend/gnrRec/add')}}" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <input type="hidden" name="region" value="{{$filter['region']}}">
        <input type="hidden" name="beginDate" value="{{$filter['beginDate']}}">
        <input type="hidden" name="endDate" value="{{$filter['endDate']}}">
        <input type="hidden" name="checkStatus" value="{{$filter['checkStatus']}}">
        <div class="body">
            <div class="bar">
                请输入发电结果
            </div>
            <table class="inputTable tabContent">
                <tr>
                    <th>
                        发电申请时间:
                    </th>
                    <td>
                        <input type="text" value="{{$gnrRecs[0]->gnr_req_time}}" readonly>
                    </td>
                </tr>
                <tr>
                    <th>
                        发电申请发起方:
                    </th>
                    <td>
                        <input type="text" value="{{transGnrRaiseSide($gnrRecs[0]->gnr_raise_side) }}" readonly>
                    </td>
                </tr>
                <tr>
                    <th>
                        发电结果:
                    </th>
                    <td>
                        <select name="gnrResult">
                            <option>成功</option>
                            <option>失败</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        发电起始时间:
                    </th>
                    <td>
                        <input type="text" name="gnrStartTime" style="width:130px;padding-left:5px"
                               readonly="true" value="{{$gnrRecs[0]->gnr_req_time}}"
                               onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"/>
                    </td>
                </tr>
                <tr>
                    <th>
                        发电终止时间:
                    </th>
                    <td>
                        <input type="text" name="gnrEndTime" style="width:130px;padding-left:5px"
                               readonly="true" value="{{date('Y-m-d H:i:s', time())}}"
                               onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"/>
                    </td>
                </tr>


            </table>
            <input type="button" value="提交" class="formButton" onclick="doHandle({{$id}})">
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
            if (confirm('确认提交吗？')) {
                var form = $('#listForm');
                form.submit();
            }


        }

        function doHandle(id) {
            if (confirm('确认提交吗？')) {
                var listForm = document.getElementById("listForm");
                var url = "{{url('backend/gnrRec/handleGnr')}}" + '/' + id;
                listForm.action = url;
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