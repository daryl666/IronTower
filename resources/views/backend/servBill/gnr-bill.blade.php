@extends('layouts.app')

@section('header')
    <title>未出服务账单明细</title>
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
                        <a href="#">发电费明细</a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
    <div class="list">
        <div class="body">
            <div class="listBar">
                <label>【地市】: </label>
                <input type="text" id="region" disabled="disabled" value="{{$bill->region_name}}">
                <label>【账单月份】: </label>
                <input type="text" id="region" disabled="disabled" value="{{$bill->month}}">
                <button onclick="history.back()" class="buttonNextStep" style="float:right">返回</button>
            </div>
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
                    <a href="#" class="sort" name="userlabel" hidefocus>地市</a>
                </th>
                <th>
                    <a href="#" class="sort" name="userlabel" hidefocus>提交时间</a>
                </th>
                <th>
                    <a href="#" class="sort" name="userlabel" hidefocus>发电起始时间</a>
                </th>
                <th>
                    <a href="#" class="sort" name="userlabel" hidefocus>发电终止时间</a>
                </th>
                <th>
                    <a href="#" class="sort" name="userlabel" hidefocus>发电时长（时:分）</a>
                </th>
                <th>
                    <a href="#" class="sort" name="intId" hidefocus>发电费（元）</a>
                </th>
                {{--<th>--}}
                    {{--<a href="#" class="sort" name="intId" hidefocus>出账情况</a>--}}
                {{--</th>--}}
            </tr>
            @for ($i = 0; $i < count($gnrs); $i++)
                <tr>
                    <td>{{($i + 1)}}</td>
                    <td>{{$gnrs[$i]->site_code}}</td>
                    <td>{{$gnrs[$i]->region_name}}</td>
                    <td>{{$gnrs[$i]->created_at}}</td>
                    <td>{{$gnrs[$i]->gnr_start_time}}</td>
                    <td>{{$gnrs[$i]->gnr_stop_time}}</td>
                    <td>{{$gnrs[$i]->gnr_len}}</td>
                    <td>{{($gnrs[$i]->gnr_fee)}}</td>
{{--                    <td>{{transFeeOutStatus($gnrs[$i]->is_out)}}</td>--}}
                </tr>
            @endfor

        </table>
    </div>
@endsection


@section('script_footer')
    <script type="text/javascript" src="{{ URL::asset('common/datePicker/WdatePicker.js')}}"></script>
    <script type="text/javascript">
        $().ready(function() {

            $('#menu_bill').addClass("current");
        });

        function doBack(){
            var url = '{{URL('backend/servBill/')}}' + '?out_status={{$bill->is_out}}&region={{$bill->region_name}}&beginDate={{$bill->start_day}}&endDate={{$bill->end_day}}';
            self.location.href = url;
        }


    </script>
@endsection
