@extends('layouts.app')

@section('header')
    <title>服务账单明细</title>
@endsection

@section('script_header')

@endsection

@section('content')
    <div class="container" style="width:100% ">
        <div class="row clearfix">
            <div class="col-md-12 column" style="padding: 0">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="{{url('backend/servBill')}}">账单管理</a>
                    </li>
                </ul>
                <ul class="breadcrumb" style="margin-bottom: 0;background-color: #F5F5F5">
                    当前位置：
                    <li>
                        <a href="{{url('backend/servBill')}}">账单管理</a>
                    </li>
                    <li class="active">
                        <a href="#">扣费1明细</a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
    <div class="list">
        <div class="body">
            <form id="listForm" method="post" target="_self">
                <div class="listBar">
                    <label>【地市】: </label>
                    <input type="text" id="region" disabled="disabled" value="{{$bill->region_name}}">
                    <label>【账单月份】: </label>
                    <input type="text" id="region" disabled="disabled"
                           value="{{$bill->month}}">
                    <input type="button" class="formButton" onclick="history.back()" value="返回" style="float: right">
                    {{--<a href="{{URL('backend/servBill/')}}?out_status={{$bill->is_out}}&region={{$region}}&beginDate={{$bill->start_day}}&endDate={{$bill->end_day}}" class="buttonNextStep" style="float:right">返回</a>--}}
                </div>
            </form>
        </div>
        <table class="listTable" style="white-space:nowrap;">
            <tr>
                <th>
                    <a href="#" class="sort" name="userlabel" hidefocus>序号</a>
                </th>
                <th>
                    <a href="#" class="sort" name="userlabel" hidefocus>站址编码</a>
                </th>
                <th>
                    <a href="#" class="sort" name="intId" hidefocus>退服次数</a>
                </th>
                <th>
                    <a href="#" class="sort" name="intId" hidefocus>总退服时长（分钟）</a>
                </th>
                <th>
                    <a href="#" class="sort" name="intId" hidefocus>扣费（元）</a>
                </th>

            </tr>
            @for ($i = 0; $i < count($deduction1); $i++)
                <tr>
                    <td>{{($i + 1)}}</td>
                    <td>{{$deduction1[$i]->site_code}}</td>
                    <td>{{$deduction1[$i]->os_num}}</td>
                    <td>{{$deduction1[$i]->os_total_time}}</td>
                    <td>{{$deduction1[$i]->fine}}</td>

                </tr>
            @endfor
        </table>
    </div>
@endsection


@section('script_footer')
    <script type="text/javascript" src="{{ URL::asset('common/datePicker/WdatePicker.js')}}"></script>
    <script type="text/javascript">
        $().ready(function () {
            var child2 = document.getElementById('child2');
            var servBill = document.getElementById('servBill');
            child2.style.display = '';
            servBill.style.color = '#FF6D10';
//            $('#menu_bill').addClass("current");
        });

    </script>
@endsection
