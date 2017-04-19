@extends('layouts.app')

@section('header')
    <title>新增服务费用</title>
    <?php
    session_start();                //根据当前SESSION生成随机数
    $code = mt_rand(0,1000000);
    $_SESSION['code'] = $code;      //将此随机数暂存入到session
    ?>
@endsection

@section('content')
    <div class="bar" style="font-weight:bold;">

        <a href="javascript:;" onclick="doBack()">服务费用填报</a>
        <td>>>></td>
        <a href="#">新增服务费用</a>
    </div>


    <body class="input managerInfo">
    {{--<div class="bar">--}}
        {{--<div style="float:left;">--}}
            {{--服务费用价格信息--}}
        {{--</div>--}}

    {{--</div>--}}
    {{--<div id="validateErrorContainer" class="validateErrorContainer">--}}

    {{--</div>--}}
    <div class="body">
        <form id="listForm" method="post" action="{{url('backend/servCost/add')}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="beginDate" value="{{$beginDate}}">
            <input type="hidden" name="region_0" value="{{$region}}">
            <input type="hidden" name="endDate" value="{{$endDate}}">
            <input type="hidden" name="originator" value="<?php echo $code;?>">
            {{--<table class="inputTable tabContent">--}}
                {{--<tr>--}}
                    {{--<th>--}}
                        {{--地市：--}}
                    {{--</th>--}}
                    {{--<td>--}}
                        {{--<input name="region" type="text" @if($region!='请选择...') value="{{$region}}" @endif id="region"--}}
                               {{--onfocus=this.blur()>--}}
                    {{--</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<th>--}}
                        {{--站址总数：--}}
                    {{--</th>--}}
                    {{--<td>--}}

                        {{--<input name="siteNum" type="text" id="siteNum" onfocus=this.blur() value="{{$siteNum}}">--}}
                    {{--</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<th>--}}
                        {{--基准服务价格（元/不含税）：--}}
                    {{--</th>--}}
                    {{--<td>--}}

                        {{--<input name="feeBasic" type="text" id="feeBasic" onfocus=this.blur() value="{{formatNumber($servPrices[0])}}">--}}
                    {{--</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<th>--}}
                        {{--基准服务价格（元/含税）：--}}
                    {{--</th>--}}
                    {{--<td>--}}
                        {{--<input type="" name="feeBasicTaxed" id="feeBasicTaxed" onfocus=this.blur()--}}
                               {{--value="{{formatNumber($servPrices[1])}}">--}}

                    {{--</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<th>--}}
                        {{--场地费（元/不含税）：--}}
                    {{--</th>--}}
                    {{--<td>--}}
                        {{--<input name="feeSite" id="feeSite" onfocus=this.blur() value="{{$servPrices[2]}}">--}}


                    {{--</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<th>--}}
                        {{--场地费（元/含税）：--}}
                    {{--</th>--}}
                    {{--<td>--}}
                        {{--<input name="feeSiteTaxed" id="feeSiteTaxed" onfocus=this.blur() value="{{$servPrices[3]}}">--}}

                    {{--</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<th>--}}
                        {{--电力引入费（元/不含税）：--}}
                    {{--</th>--}}
                    {{--<td>--}}
                        {{--<input type="" name="feeImport" id="feeImport" onfocus=this.blur() value="{{$servPrices[4]}}">--}}

                    {{--</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<th>--}}
                        {{--电力引入费（元/含税）：--}}
                    {{--</th>--}}
                    {{--<td>--}}
                        {{--<input type="" name="feeImportTaxed" id="feeImportTaxed" onfocus=this.blur()--}}
                               {{--value="{{$servPrices[5]}}">--}}

                    {{--</td>--}}
                {{--</tr>--}}
            {{--</table>--}}
            <div class="bar" >
                <input id="newDate" @if(isset($newDate))value="{{$newDate}}"@endif type="hidden">
                <div style="float:left;">
                    @if(isset($latestMonth))最近填报月份为：{{$latestMonth}}&nbsp;&nbsp;请从&nbsp;{{$newDate}}&nbsp;开始填报@endif
                    @if(empty($latestMonth))当前还未填报过服务费用，请选择起止日期@endif
                </div>

            </div>
            <table class="inputTable tabContent">
                <tr>
                    <th>
                        地市：
                    </th>
                    <td>
                        <input name="region" type="text" @if($region!='请选择...') value="{{$region}}" @endif id="region"
                               onfocus=this.blur()>
                    </td>
                </tr>
                <tr>
                    <th>
                        起始日期：
                    </th>
                    <td>

                        <input type="text" id="beginDate" name="startDate" style="width:165px;padding-left:5px"
                               readonly="true" onclick="WdatePicker({dateFmt:'yyyy-MM'})"/>
                    </td>
                </tr>
                <tr>
                    <th>
                        终止日期：
                    </th>
                    <td>

                        <input type="text" id="endDate" name="stopDate" style="width:165px;padding-left:5px"
                               readonly="true" onclick="WdatePicker({dateFmt:'yyyy-MM'})"/>
                    </td>
                </tr>
            </table>
            {{--<tr>--}}
            {{--<th>--}}
            {{--日常电费（万元/不含税）:--}}
            {{--</th>--}}
            {{--<td>--}}
            {{--<input type="" name="feeElectricity" id="feeElectricity">--}}

            {{--</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
            {{--<th>--}}
            {{--日常电费（万元/含税）:--}}
            {{--</th>--}}
            {{--<td>--}}
            {{--<input type="" name="feeElectricityTaxed" id="feeElectricityTaxed">--}}

            {{--</td>--}}
            {{--</tr>--}}



        </form>
        <input type="button" value="提交" class="formButton" onclick="doAddSuccess()"/>
        <input type="button" value="返回" class="formButton" onclick="doBack()"/>
    </div>
    </body>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {
            $('#menu_business').addClass("current");
        });

        function doBack() {
            var listForm = document.getElementById('listForm');
            listForm.action = "{{url('backend/servCost/back')}}";
            listForm.submit();
        }
        function doAddSuccess() {
            var beginDate = $('#beginDate').val();
            var endDate = $('#endDate').val();
            var newDate = $('#newDate').val();
            if(beginDate == ''){
                alert('请选择起始日期！');
                return;
            }
            if(endDate == ''){
                alert('请选择终止日期！');
                return;
            }
            if(beginDate > endDate){
                alert('终止日期必须大于起始日期！');
                return;
            }
            if(beginDate < newDate){
                alert('请从'+newDate+'开始填报！')
                return;
            }
//            var region = $('#region').val();
//            var month = $('#month').val();
//            var siteNum = $('#siteNum').val();
//            var feeBasic = $('#feeBasic').val();
//            var feeBasicTaxed = $('#feeBasicTaxed').val();
//            var feeSite = $('#feeSite').val();
//            var feeSiteTaxed = $('#feeSiteTaxed').val();
//            var feeImport = $('#feeImport').val();
//            var feeImportTaxed = $('#feeImportTaxed').val();
//            var feeElectricity = $('#feeElectricity').val();
//            var feeElectricityTaxed = $('#feeElectricityTaxed').val();
//            if (region == '') {
//                alert('请输入地市！');
//                return;
//            }
//            if (month == '') {
//                alert('请输入服务费用月份！');
//                return;
//            }
//            if (siteNum == '') {
//                alert('请输入站址总数！');
//                return;
//            }
//            if (feeBasic == '') {
//                alert('请输入基准价格（万元/不含税）！');
//                return;
//            }
//            if (feeBasicTaxed == '') {
//                alert('请输入基准价格（万元/含税）！');
//                return;
//            }
//            if (feeSite == '') {
//                alert('请输入场地费（万元/不含税）！');
//                return;
//            }
//            if (feeSiteTaxed == '') {
//                alert('请输入场地费（万元/含税）！');
//                return;
//            }
//            if (feeImport == '') {
//                alert('请输入电力引入费（万元/不含税）！');
//                return;
//            }
//            if (feeImport == '') {
//                alert('请输入电力引入费（万元/含税）！');
//                return;
//            }
//            if (feeImportTaxed == '') {
//                alert('请输入日常电费（万元/不含税）！');
//                return;
//            }
//            if (feeElectricity == '') {
//                alert('请输入日常电费（万元/含税）！');
//                return;
//            }
            if (confirm('确认提交吗？')) {
                var form = $('#listForm');
                form.submit();
            }


        }


    </script>
@endsection







