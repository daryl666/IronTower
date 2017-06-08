@extends('layouts.app')

@section('header')
    <title>服务账单明细</title>
@endsection

@section('script_header')

@endsection

@section('content')
    <div class="list">
        <table class="listTable" style="white-space:nowrap;font-size:12px;">

            <tr>
                <th>
                    <a href="#" class="sort" hidefocus>操作</a>
                </th>
                <th>
                    <a href="#" class="sort" name="" hidefocus>数据来源</a>
                </th>
                <th>
                    <a href="#" class="sort" name="" hidefocus>产品业务确认单编号</a>
                </th>
                <th>
                    <a href="#" class="sort" name="" hidefocus>站址名称</a>
                </th>
                <th>
                    <a href="#" class="sort" name="" hidefocus>站址编码</a>
                </th>
                <th>
                    <a href="#" class="sort" name="" hidefocus>需求确认单编号</a>
                </th>
                <th>
                    <a href="#" class="sort" name="" hidefocus>服务起始日期</a>
                </th>
                <th class="scanStopTime">
                    <a href="#" class="sort" name="" hidefocus>铁塔类型</a>
                </th>
                {{--<th class="scanStopTime">--}}
                {{--<a href="#" class="sort" name="" hidefocus>是否为新建站</a>--}}
                {{--</th>--}}
                <th>
                    <a href="#" class="sort" name="" hidefocus>产品配套类型</a>
                </th>
                <th class="scanStopTime">
                    <a href="#" class="sort" name="" hidefocus>系统数量1</a>
                </th>
                <th class="scanStopTime">
                    <a href="#" class="sort" name="" hidefocus>系统1挂高(米)</a>
                </th>
                <th class="scanStopTime">
                    <a href="#" class="sort" name="" hidefocus>系统数量2</a>
                </th>
                <th class="scanStopTime">
                    <a href="#" class="sort" name="" hidefocus>系统2挂高(米)</a>
                </th>
                <th class="scanStopTime">
                    <a href="#" class="sort" name="" hidefocus>系统数量3</a>
                </th>
                <th class="scanStopTime">
                    <a href="#" class="sort" name="" hidefocus>系统3挂高(米)</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>铁塔共享类型</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>铁塔共享运营商1的起租日期</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>铁塔共享运营商2的起租日期</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>机房共享类型</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>机房共享运营商1的起租日期</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>机房共享运营商2的起租日期</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>配套共享类型</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>配套共享运营商1的起租日期</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>配套共享运营商2的起租日期</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>维修共享类型</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>维护费共享运营商1的起租日期</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>维护费共享运营商2的起租日期</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>场地费共享类型</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>场地费共享运营商1的起租日期</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>场地费共享运营商2的起租日期</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>电力引入费共享类型</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>电力引入费共享运营商1的起租日期</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>电力引入费共享运营商2的起租日期</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>铁塔共享后基准价格</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>机房共享后基准价格</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>配套共享后基准价格</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>维护费折扣后金额</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>场地费折扣后金额</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>电力引入费折扣后金额</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>油机发电服务费（包干）</a>
                </th>
                <th class="gp">
                    <a href="#" class="sort" name="" hidefocus>超过10%高等级服务站址额外维护服务费</a>
                </th>
                <th class="scanStopTime">
                    <a href="#" class="sort" name="" hidefocus>蓄电池额外保障费</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>WLAN费用</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>微波费用</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="" hidefocus>bbu安装在铁塔机房费</a>
                </th>

            </tr>
            @if (isset($orders))
                @foreach($orders as $order)
                    @if (!empty($order->fos_id))
                        <tr>
                            <td rowspan="2">
                                <button class="buttonNextStep" onclick="doEditPage($order->fos_id)">编辑
                                </button>
                            </td>
                            <td>电信</td>
                            <td>{{$order->business_code}}</td>
                            <td>{{$order->site_name}}</td>
                            <td>{{$order->site_code}}</td>
                            <td>{{$order->req_code}}</td>
                            <td @if (!compareOrderDetail($order->established_time_si, $order->established_time_ibd)) style="color: red;" @endif>{{$order->established_time_si}}</td>
                            <td @if (!compareOrderDetail($order->tower_type_si, $order->tower_type_ibd)) style="color: red;" @endif>{{transTowerType($order->tower_type_si)}}</td>
                            {{--<td @if (!$order->is_is_new_tower_same) style="color: red;"@endif>{{transIsNewTower($order->is_new_tower_si)}}</td>--}}
                            <td @if (!compareOrderDetail($order->product_type_si, $order->product_type_ibd)) style="color: red;" @endif>{{transProductType($order->product_type_si)}}</td>
                            <td @if (!compareOrderDetail($order->sys_num1_si, $order->sys_num1_ibd)) style="color: red;" @endif>{{$order->sys_num1_si}}</td>
                            <td @if (!compareOrderDetail($order->sys1_height_si, $order->sys1_height_ibd)) style="color: red;" @endif>{{transSysHeight($order->sys1_height_si)}}</td>
                            <td @if (!compareOrderDetail($order->sys_num2_si, $order->sys_num2_ibd)) style="color: red;" @endif>{{$order->sys_num2_si}}</td>
                            <td @if (!compareOrderDetail($order->sys2_height_si, $order->sys2_height_ibd)) style="color: red;" @endif>{{transSysHeight($order->sys2_height_si)}}</td>
                            <td @if (!compareOrderDetail($order->sys_num3_si, $order->sys_num3_ibd)) style="color: red;" @endif>{{$order->sys_num3_si}}</td>
                            <td @if (!compareOrderDetail($order->sys3_height_si, $order->sys3_height_ibd)) style="color: red;" @endif>{{transSysHeight($order->sys3_height_si)}}</td>
                            <td @if (!compareOrderDetail($order->share_num_tower_si, $order->share_num_tower_ibd)) style="color: red;" @endif>{{transShareType($order->share_num_tower_si)}}</td>
                            <td @if (!compareOrderDetail($order->user1_rent_tower_date_si, $order->user1_rent_tower_date_ibd)) style="color: red;" @endif>{{$order->user1_rent_tower_date_si}}</td>
                            <td @if (!compareOrderDetail($order->user2_rent_tower_date_si, $order->user2_rent_tower_date_ibd)) style="color: red;" @endif>{{$order->user2_rent_tower_date_si}}</td>
                            <td @if (!compareOrderDetail($order->share_num_house_si, $order->share_num_house_ibd)) style="color: red;" @endif>{{transShareType($order->share_num_house_si)}}</td>
                            <td @if (!compareOrderDetail($order->user1_rent_house_date_si, $order->user1_rent_house_date_ibd)) style="color: red;" @endif>{{$order->user1_rent_house_date_si}}</td>
                            <td @if (!compareOrderDetail($order->user2_rent_house_date_si, $order->user2_rent_house_date_ibd)) style="color: red;" @endif>{{$order->user2_rent_house_date_si}}</td>
                            <td @if (!compareOrderDetail($order->share_num_support_si, $order->share_num_support_ibd)) style="color: red;" @endif>{{transShareType($order->share_num_support_si)}}</td>
                            <td @if (!compareOrderDetail($order->user1_rent_support_date_si, $order->user1_rent_support_date_ibd)) style="color: red;" @endif>{{$order->user1_rent_support_date_si}}</td>
                            <td @if (!compareOrderDetail($order->user2_rent_support_date_si, $order->user2_rent_support_date_ibd)) style="color: red;" @endif>{{$order->user2_rent_support_date_si}}</td>
                            <td @if (!compareOrderDetail($order->share_num_maintain_si, $order->share_num_maintain_ibd)) style="color: red;" @endif>{{transShareType($order->share_num_maintain_si)}}</td>
                            <td @if (!compareOrderDetail($order->user1_rent_maintain_date_si, $order->user1_rent_maintain_date_ibd)) style="color: red;" @endif>{{$order->user1_rent_maintain_date_si}}</td>
                            <td @if (!compareOrderDetail($order->user2_rent_maintain_date_si, $order->user2_rent_maintain_date_ibd)) style="color: red;" @endif>{{$order->user2_rent_maintain_date_si}}</td>
                            <td @if (!compareOrderDetail($order->share_num_site_si, $order->share_num_site_ibd)) style="color: red;" @endif>{{transShareType($order->share_num_site_si)}}</td>
                            <td @if (!compareOrderDetail($order->user1_rent_site_date_si, $order->user1_rent_site_date_ibd)) style="color: red;" @endif>{{$order->user1_rent_site_date_si}}</td>
                            <td @if (!compareOrderDetail($order->user2_rent_site_date_si, $order->user2_rent_site_date_ibd)) style="color: red;" @endif>{{$order->user2_rent_site_date_si}}</td>
                            <td @if (!compareOrderDetail($order->share_num_import_si, $order->share_num_import_ibd)) style="color: red;" @endif>{{transShareType($order->share_num_import_si)}}</td>
                            <td @if (!compareOrderDetail($order->user1_rent_import_date_si, $order->user1_rent_import_date_ibd)) style="color: red;" @endif>{{$order->user1_rent_import_date_si}}</td>
                            <td @if (!compareOrderDetail($order->user2_rent_import_date_si, $order->user2_rent_import_date_ibd)) style="color: red;" @endif>{{$order->user2_rent_import_date_si}}</td>
                            <td @if (!compareOrderDetail($order->fee_tower_fos, $order->fee_tower_ibd)) style="color: red;" @endif>{{$order->fee_tower_fos}}</td>
                            <td @if (!compareOrderDetail($order->fee_house_fos, $order->fee_house_ibd)) style="color: red;" @endif>{{$order->fee_house_fos}}</td>
                            <td @if (!compareOrderDetail($order->fee_support_fos, $order->fee_support_ibd)) style="color: red;" @endif>{{$order->fee_support_fos}}</td>
                            <td @if (!compareOrderDetail($order->fee_maintain_fos, $order->fee_maintain_ibd)) style="color: red;" @endif>{{$order->fee_maintain_fos}}</td>
                            <td @if (!compareOrderDetail($order->fee_site_fos, $order->fee_site_ibd)) style="color: red;" @endif>{{$order->fee_site_fos}}</td>
                            <td @if (!compareOrderDetail($order->fee_import_fos, $order->fee_import_ibd)) style="color: red;" @endif>{{$order->fee_import_fos}}</td>
                            <td @if (!compareOrderDetail($order->fee_gnr_allincharge_fos, $order->fee_gnr_allincharge_ibd)) style="color: red;" @endif>{{$order->fee_gnr_allincharge_fos}}</td>
                            <td @if (!compareOrderDetail($order->fee_add_fos, $order->fee_add_ibd)) style="color: red;" @endif>{{$order->fee_add_fos}}</td>
                            <td @if (!compareOrderDetail($order->fee_battery_fos, $order->fee_battery_ibd)) style="color: red;" @endif>{{$order->fee_battery_fos}}</td>
                            <td @if (!compareOrderDetail($order->fee_wlan_fos, $order->fee_wlan_ibd)) style="color: red;" @endif>{{$order->fee_wlan_fos}}</td>
                            <td @if (!compareOrderDetail($order->fee_microwave_fos, $order->fee_microwave_ibd)) style="color: red;" @endif>{{$order->fee_microwave_fos}}</td>
                            <td @if (!compareOrderDetail($order->fee_bbu_fos, $order->fee_bbu_ibd)) style="color: red;" @endif>{{$order->fee_bbu_fos}}</td>
                        </tr>
                    @endif
                    @if (!empty($order->ibd_id))
                        <tr>
                            <td>铁塔</td>
                            <td>{{$order->business_code}}</td>
                            <td>{{$order->site_name}}</td>
                            <td>{{$order->site_code}}</td>
                            <td>{{$order->req_code}}</td>
                            <td @if (!compareOrderDetail($order->established_time_si, $order->established_time_ibd)) style="color: red;" @endif>{{$order->established_time_ibd}}</td>
                            <td @if (!compareOrderDetail($order->tower_type_si, $order->tower_type_ibd)) style="color: red;" @endif>{{transTowerType($order->tower_type_ibd)}}</td>
                            {{--<td @if (!$order->is_is_new_tower_same) style="color: red;"@endif>{{transIsNewTower($order->is_new_tower_ibd)}}</td>--}}
                            <td @if (!compareOrderDetail($order->product_type_si, $order->product_type_ibd)) style="color: red;" @endif>{{transProductType($order->product_type_ibd)}}</td>
                            <td @if (!compareOrderDetail($order->sys_num1_si, $order->sys_num1_ibd)) style="color: red;" @endif>{{$order->sys_num1_ibd}}</td>
                            <td @if (!compareOrderDetail($order->sys1_height_si, $order->sys1_height_ibd)) style="color: red;" @endif>{{transSysHeight($order->sys1_height_ibd)}}</td>
                            <td @if (!compareOrderDetail($order->sys_num2_si, $order->sys_num2_ibd)) style="color: red;" @endif>{{$order->sys_num2_ibd}}</td>
                            <td @if (!compareOrderDetail($order->sys2_height_si, $order->sys2_height_ibd)) style="color: red;" @endif>{{transSysHeight($order->sys2_height_ibd)}}</td>
                            <td @if (!compareOrderDetail($order->sys_num3_si, $order->sys_num3_ibd)) style="color: red;" @endif>{{$order->sys_num3_ibd}}</td>
                            <td @if (!compareOrderDetail($order->sys3_height_si, $order->sys3_height_ibd)) style="color: red;" @endif>{{transSysHeight($order->sys3_height_ibd)}}</td>
                            <td @if (!compareOrderDetail($order->share_num_tower_si, $order->share_num_tower_ibd)) style="color: red;" @endif>{{transShareType($order->share_num_tower_ibd)}}</td>
                            <td @if (!compareOrderDetail($order->user1_rent_tower_date_si, $order->user1_rent_tower_date_ibd)) style="color: red;" @endif>{{$order->user1_rent_tower_date_ibd}}</td>
                            <td @if (!compareOrderDetail($order->user2_rent_tower_date_si, $order->user2_rent_tower_date_ibd)) style="color: red;" @endif>{{$order->user2_rent_tower_date_ibd}}</td>
                            <td @if (!compareOrderDetail($order->share_num_house_si, $order->share_num_house_ibd)) style="color: red;" @endif>{{transShareType($order->share_num_house_ibd)}}</td>
                            <td @if (!compareOrderDetail($order->user1_rent_house_date_si, $order->user1_rent_house_date_ibd)) style="color: red;" @endif>{{$order->user1_rent_house_date_ibd}}</td>
                            <td @if (!compareOrderDetail($order->user2_rent_house_date_si, $order->user2_rent_house_date_ibd)) style="color: red;" @endif>{{$order->user2_rent_house_date_ibd}}</td>
                            <td @if (!compareOrderDetail($order->share_num_support_si, $order->share_num_support_ibd)) style="color: red;" @endif>{{transShareType($order->share_num_support_ibd)}}</td>
                            <td @if (!compareOrderDetail($order->user1_rent_support_date_si, $order->user1_rent_support_date_ibd)) style="color: red;" @endif>{{$order->user1_rent_support_date_ibd}}</td>
                            <td @if (!compareOrderDetail($order->user2_rent_support_date_si, $order->user2_rent_support_date_ibd)) style="color: red;" @endif>{{$order->user2_rent_support_date_ibd}}</td>
                            <td @if (!compareOrderDetail($order->share_num_maintain_si, $order->share_num_maintain_ibd)) style="color: red;" @endif>{{transShareType($order->share_num_maintain_ibd)}}</td>
                            <td @if (!compareOrderDetail($order->user1_rent_maintain_date_si, $order->user1_rent_maintain_date_ibd)) style="color: red;" @endif>{{$order->user1_rent_maintain_date_ibd}}</td>
                            <td @if (!compareOrderDetail($order->user2_rent_maintain_date_si, $order->user2_rent_maintain_date_ibd)) style="color: red;" @endif>{{$order->user2_rent_maintain_date_ibd}}</td>
                            <td @if (!compareOrderDetail($order->share_num_site_si, $order->share_num_site_ibd)) style="color: red;" @endif>{{transShareType($order->share_num_site_ibd)}}</td>
                            <td @if (!compareOrderDetail($order->user1_rent_site_date_si, $order->user1_rent_site_date_ibd)) style="color: red;" @endif>{{$order->user1_rent_site_date_ibd}}</td>
                            <td @if (!compareOrderDetail($order->user2_rent_site_date_si, $order->user2_rent_site_date_ibd)) style="color: red;" @endif>{{$order->user2_rent_site_date_ibd}}</td>
                            <td @if (!compareOrderDetail($order->share_num_import_si, $order->share_num_import_ibd)) style="color: red;" @endif>{{transShareType($order->share_num_import_ibd)}}</td>
                            <td @if (!compareOrderDetail($order->user1_rent_import_date_si, $order->user1_rent_import_date_ibd)) style="color: red;" @endif>{{$order->user1_rent_import_date_ibd}}</td>
                            <td @if (!compareOrderDetail($order->user2_rent_import_date_si, $order->user2_rent_import_date_ibd)) style="color: red;" @endif>{{$order->user2_rent_import_date_ibd}}</td>
                            <td @if (!compareOrderDetail($order->fee_tower_fos, $order->fee_tower_ibd)) style="color: red;" @endif>{{$order->fee_tower_ibd}}</td>
                            <td @if (!compareOrderDetail($order->fee_house_fos, $order->fee_house_ibd)) style="color: red;" @endif>{{$order->fee_house_ibd}}</td>
                            <td @if (!compareOrderDetail($order->fee_support_fos, $order->fee_support_ibd)) style="color: red;" @endif>{{$order->fee_support_ibd}}</td>
                            <td @if (!compareOrderDetail($order->fee_maintain_fos, $order->fee_maintain_ibd)) style="color: red;" @endif>{{$order->fee_maintain_ibd}}</td>
                            <td @if (!compareOrderDetail($order->fee_site_fos, $order->fee_site_ibd)) style="color: red;" @endif>{{$order->fee_site_ibd}}</td>
                            <td @if (!compareOrderDetail($order->fee_import_fos, $order->fee_import_ibd)) style="color: red;" @endif>{{$order->fee_import_ibd}}</td>
                            <td @if (!compareOrderDetail($order->fee_gnr_allincharge_fos, $order->fee_gnr_allincharge_ibd)) style="color: red;" @endif>{{$order->fee_gnr_allincharge_ibd}}</td>
                            <td @if (!compareOrderDetail($order->fee_add_fos, $order->fee_add_ibd)) style="color: red;" @endif>{{$order->fee_add_ibd}}</td>
                            <td @if (!compareOrderDetail($order->fee_battery_fos, $order->fee_battery_ibd)) style="color: red;" @endif>{{$order->fee_battery_ibd}}</td>
                            <td @if (!compareOrderDetail($order->fee_wlan_fos, $order->fee_wlan_ibd)) style="color: red;" @endif>{{$order->fee_wlan_ibd}}</td>
                            <td @if (!compareOrderDetail($order->fee_microwave_fos, $order->fee_microwave_ibd)) style="color: red;" @endif>{{$order->fee_microwave_ibd}}</td>
                            <td @if (!compareOrderDetail($order->fee_bbu_fos, $order->fee_bbu_ibd)) style="color: red;" @endif>{{$order->fee_bbu_ibd}}</td>
                        </tr>
                    @endif


                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endforeach
                {!! $orders->render() !!}
            @endif
        </table>
    </div>
@endsection


