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
        function doEditPage(id) {
            var listForm = document.getElementById("listForm");
            var url = "{{url('backend/servBill/billCheck/orders/editPage')}}" + '/' + id;
            listForm.action = url;
            listForm.submit();
        }
    </script>
@endsection


@section('content')
    <div class="container" style="width:100% ">
        <div class="row clearfix">
            <div class="col-md-12 column" style="padding: 0">
                {{--<div class="collapse navbar-collapse" id="example-navbar-collapse" style="padding: 0">--}}
                <ul class="nav nav-tabs">
                    <li class="inactive">
                        <a href="{{url('backend/servBill')}}">账单管理</a>
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/servBill/irontowerBillImportPage')}}">铁塔详单导入</a>
                    </li>
                    <li class="active">
                        <a href="{{url('backend/servBill/billCheck')}}">账单稽查</a>
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/siteStats/')}}">铁塔详单统计</a>
                    </li>
                </ul>
                <ul class="breadcrumb" style="margin-bottom: 0;background-color: #F5F5F5">
                    当前位置：
                    <li>
                        <a href="{{url('backend/servBill/billCheck')}}">账单稽查</a>
                    </li>
                    <li class="active">
                        <a href="#">订单查询</a>
                    </li>
                </ul>
            </div>
        </div>

    </div>




    <div class="list">
        <div class="listBar">
        {{--<label>【地市】: </label>--}}
        {{--<input type="text" id="region" disabled="disabled"--}}
        {{--@if (isset($telecomOrders[0])) value="{{transRegion($telecomOrders[0]->region_id)}}"@endif>--}}
        {{--<label>【账单月份】: </label>--}}
        {{--<input type="text" id="region" disabled="disabled"--}}
        {{--@if (isset($telecomOrders[0])) value="{{$telecomOrders[0]->start_day}}"@endif>--}}
        <input type="button" class="formButton" onclick="history.back()" value="返回" style="float: right">
        </div>
        <form id="listForm" method="post" action="{{URL('backend/servBill/')}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div id="siteInfo">
                <table class="listTable" style="white-space:nowrap;font-size:12px;">

                    <tr>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>操作</a>
                        </th>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>产品业务确认单编号</a>
                        </th>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>需求确认单编号</a>
                        </th>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>站址编码</a>
                        </th>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>站址名称</a>
                        </th>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>服务起始日期</a>
                        </th>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>地市</a>
                        </th>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>铁塔类型</a>
                        </th>
                        <th class="scanStopTime">
                            <a href="#" class="sort" name="" hidefocus>是否为新建站</a>
                        </th>
                        <th>
                            <a href="#" class="sort" name="" hidefocus>产品配套类型</a>
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
                        <th class="freqMode">
                            <a href="#" class="sort" name="" hidefocus>铁塔共享类型</a>
                        </th>
                        <th class="freqMode">
                            <a href="#" class="sort" name="" hidefocus>机房共享类型</a>
                        </th>
                        <th class="freqMode">
                            <a href="#" class="sort" name="" hidefocus>配套共享类型</a>
                        </th>
                        <th class="freqMode">
                            <a href="#" class="sort" name="" hidefocus>维护费共享类型</a>
                        </th>
                        <th class="freqMode">
                            <a href="#" class="sort" name="" hidefocus>场地费共享类型</a>
                        </th>
                        <th class="freqMode">
                            <a href="#" class="sort" name="" hidefocus>电力引入费共享类型</a>
                        </th>
                    </tr>
                    @if (isset($telecomOrders))
                        @foreach ($telecomOrders as $telecomOrder)
                            <tr>
                                <td>
                                    <button class="buttonNextStep" onclick="doEditPage({{$telecomOrder->id}})">编辑
                                    </button>
                                </td>
                                <td>{{$telecomOrder->business_code}}</td>
                                <td>{{$telecomOrder->req_code}}</td>
                                <td>{{$telecomOrder->site_code}}</td>
                                <td>{{$telecomOrder->site_name}}</td>
                                <td>{{$telecomOrder->established_time}}</td>
                                <td>{{transRegion($telecomOrder->region_id)}}</td>
                                <td>{{transTowerType($telecomOrder->tower_type)}}</td>
                                <td>{{transIsNewTower($telecomOrder->is_new_tower)}}</td>
                                <td>{{transProductType($telecomOrder->product_type)}}</td>
                                <td>{{transIsNewlyAdded($telecomOrder->is_newly_added)}}</td>
                                <td>{{transUserType($telecomOrder->user_type)}}</td>
                                <td>{{transShareType($telecomOrder->share_num_tower)}}</td>
                                <td>{{transShareType($telecomOrder->share_num_house)}}</td>
                                <td>{{transShareType($telecomOrder->share_num_support)}}</td>
                                <td>{{transShareType($telecomOrder->share_num_maintain)}}</td>
                                <td>{{transShareType($telecomOrder->share_num_site)}}</td>
                                <td>{{transShareType($telecomOrder->share_num_import)}}</td>
                            </tr>
                        @endforeach
                    @endif

                </table>


            </div>
        </form>


    </div>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {
            var menu_business = document.getElementById('menu_bill');
            menu_business.className = "current";
        });

        {{--function doEditPage(id) {--}}
            {{--var listForm = document.getElementById("listForm");--}}
            {{--var url = "{{url('backend/servBill/billCheck/orders/editPage')}}" + '/' + id;--}}
            {{--listForm.action = url;--}}
            {{--listForm.submit();--}}
        {{--}--}}


    </script>
@endsection