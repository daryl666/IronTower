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
                        <a href="#">月服务费明细</a>
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
                    <input type="text" id="region" disabled="disabled" value="{{transRegion($bill->region_id)}}">
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
                    <a href="#" class="sort" name="userlabel" hidefocus>产品业务确认单编号</a>
                </th>
                <th>
                    <a href="#" class="sort" name="userlabel" hidefocus>需求确认单编号</a>
                </th>
                {{--<th>--}}
                    {{--<a href="#" class="sort" name="userlabel" hidefocus>站址编码</a>--}}
                {{--</th>--}}
                <th>
                    <a href="#" class="sort" name="intId" hidefocus>铁塔基准价格（元）</a>
                </th>
                <th>
                    <a href="#" class="sort" name="intId" hidefocus>机房基准价格（元）</a>
                </th>
                <th>
                    <a href="#" class="sort" name="intId" hidefocus>配套基准价格（元）</a>
                </th>
                <th>
                    <a href="#" class="sort" name="intId" hidefocus>维护费基准价格（元）</a>
                </th>
                <th>
                    <a href="#" class="sort" name="objectRdn" hidefocus>场地费（元）</a>
                </th>
                <th>
                    <a href="" class="sort">电力引入费（元）</a>
                </th>
                <th>
                    <a href="" class="sort">WLAN费用（元）</a>
                </th>
                <th>
                    <a href="" class="sort">微波费用（元）</a>
                </th>
                <th>
                    <a href="" class="sort">超过10%高等级服务站址额外维护服务费（元）</a>
                </th>
                <th>
                    <a href="" class="sort">蓄电池额外保障费（元）</a>
                </th>
                <th>
                    <a href="" class="sort">bbu安装在铁塔机房费（元）</a>
                </th>
                <th>
                    <a href="" class="sort">月服务费（元）</a>
                </th>

            </tr>
            @for ($i = 0; $i < count($sites); $i++)
                <tr>
                    <td>{{$sites[$i]->business_code}}</td>
                    <td>{{$sites[$i]->req_code}}</td>
                    {{--<td>{{$sites[$i]->site_code}}</td>--}}
                    <td>{{($sites[$i]->fee_tower)}}</td>
                    <td>{{($sites[$i]->fee_house)}}</td>
                    <td>{{($sites[$i]->fee_support)}}</td>
                    <td>{{($sites[$i]->fee_maintain)}}</td>
                    <td>{{($sites[$i]->fee_site)}}</td>
                    <td>{{($sites[$i]->fee_import)}}</td>
                    <td>{{($sites[$i]->fee_wlan)}}</td>
                    <td>{{($sites[$i]->fee_microwave)}}</td>
                    <td>{{($sites[$i]->fee_add)}}</td>
                    <td>{{($sites[$i]->fee_battery)}}</td>
                    <td>{{($sites[$i]->fee_bbu)}}</td>
                    <td>{{($sites[$i]->fee_service)}}</td>
                </tr>
            @endfor
            @if(isset($bill))
                {!! $sites
                ->appends(['out_id' => $bill->id])
                ->links() !!}@endif
        </table>
    </div>
@endsection


@section('script_footer')
    <script type="text/javascript" src="{{ URL::asset('common/datePicker/WdatePicker.js')}}"></script>
    <script type="text/javascript">
        $().ready(function () {
            $('#menu_bill').addClass("current");
        });

    </script>
@endsection
