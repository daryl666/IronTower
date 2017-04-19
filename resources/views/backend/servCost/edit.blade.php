@extends('layouts.app')

@section('header')
    <title>编辑服务费用</title>
@endsection

@section('content')
    <body class="input managerInfo">
    <div class="bar" style="font-weight:bold;">

        <a href="javascript:;" onclick="doBack()">服务费用填报</a>
        <td>>>></td>
        <a href="#">服务费用编辑</a>
    </div>


    {{--<div class="bar">--}}
        {{--<div style="float:left;">--}}
            {{--服务费用价格信息--}}
        {{--</div>--}}

    {{--</div>--}}
    <div id="validateErrorContainer" class="validateErrorContainer">

    </div>
    <div class="body">
        <form id="listForm" method="post" action="{{url('backend/servCost/update/'.$servCost->id)}}" style="display: inline;">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="region_0" @if(isset($region)) value="{{$region}}"@endif>
            <input type="hidden" name="id" value="{{$servCost->id}}">
            <input type="hidden" name="beginDate" value="{{$beginDate}}">
            <input type="hidden" name="endDate" value="{{$endDate}}">
            <input type="hidden" name="monthOld" value="{{$monthOld}}">
            {{--<table class="inputTable tabContent">--}}
                {{--<tr>--}}
                    {{--<th>--}}
                        {{--地市：--}}
                    {{--</th>--}}
                    {{--<td>--}}
                        {{--<input name="region" type="text" @if($servCost->region_name!='请选择...') value="{{$servCost->region_name}}" @endif id="region"--}}
                               {{--onfocus=this.blur()>--}}
                    {{--</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<th>--}}
                        {{--站址总数：--}}
                    {{--</th>--}}
                    {{--<td>--}}

                        {{--<input name="siteNum" type="text" id="siteNum" onfocus=this.blur() value="{{$servCost->site_num}}">--}}
                    {{--</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<th>--}}
                        {{--基准服务价格（元/不含税）：--}}
                    {{--</th>--}}
                    {{--<td>--}}

                        {{--<input name="feeBasic" type="text" id="feeBasic" onfocus=this.blur() value="{{($servCost->fee_basic)}}">--}}
                    {{--</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<th>--}}
                        {{--基准服务价格（元/含税）：--}}
                    {{--</th>--}}
                    {{--<td>--}}
                        {{--<input type="" name="feeBasicTaxed" id="feeBasicTaxed" onfocus=this.blur()--}}
                               {{--value="{{($servCost->fee_basic_taxed)}}">--}}

                    {{--</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<th>--}}
                        {{--场地费（元/不含税）：--}}
                    {{--</th>--}}
                    {{--<td>--}}
                        {{--<input name="feeSite" id="feeSite" onfocus=this.blur() value="{{($servCost->fee_site)}}">--}}


                    {{--</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<th>--}}
                        {{--场地费（元/含税）：--}}
                    {{--</th>--}}
                    {{--<td>--}}
                        {{--<input name="feeSiteTaxed" id="feeSiteTaxed" onfocus=this.blur() value="{{($servCost->fee_site_taxed)}}">--}}

                    {{--</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<th>--}}
                        {{--电力引入费（元/不含税）：--}}
                    {{--</th>--}}
                    {{--<td>--}}
                        {{--<input type="" name="feeImport" id="feeImport" onfocus=this.blur() value="{{($servCost->fee_import)}}">--}}

                    {{--</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<th>--}}
                        {{--电力引入费（元/含税）：--}}
                    {{--</th>--}}
                    {{--<td>--}}
                        {{--<input type="" name="feeImportTaxed" id="feeImportTaxed" onfocus=this.blur()--}}
                               {{--value="{{($servCost->fee_import_taxed)}}">--}}

                    {{--</td>--}}
                {{--</tr>--}}
            {{--</table>--}}
            <div class="bar">
                <div style="float:left;">
                    请修改服务费用月份
                </div>

            </div>
            <table class="inputTable tabContent">
                <tr>
                    <th>
                        地市：
                    </th>
                    <td>
                        <input name="region" type="text" @if($servCost->region_name!='请选择...') value="{{$servCost->region_name}}" @endif id="region"
                               onfocus=this.blur()>
                    </td>
                </tr>

                <tr>
                    <th>
                        服务费用月份：
                    </th>
                    <td>

                        <input type="text" id="endDate" name="month" style="width:165px;padding-left:5px"
                               readonly="true" onclick="WdatePicker({dateFmt:'yyyy-MM'})" value="{{$servCost->month}}"/>
                    </td>
                </tr>


            </table>


            <input class="formButton" type="button" value="修改" onclick="doModify()">
        </form>

        <form action="{{url('backend/servCost/delete/'.$servCost->id)}}}" method="get" style="display: inline;" id="delForm">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <input type="hidden" name="region" @if(isset($servCost->region_name)) value="{{$servCost->region_name}}"@endif>
            <input type="hidden" name="beginDate" value="{{$beginDate}}">
            <input type="hidden" name="endDate" value="{{$endDate}}">
            <input type="hidden" name="monthOld" value="{{$monthOld}}">
            <input type="button" class="formButton" value="删除" onclick="doDel()">
        </form>
        <input type="button" class="formButton" value="返回" onclick="doBack()">
    </div>
    </body>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {
            $('#menu_business').addClass("current");
        });

        function doModify(){
            if(confirm('确认修改吗？')){
                var form=$('#listForm');
                form.submit();
            }
        }
        function doDel(){
            if(confirm('确认删除吗？')){
                var delForm=$('#delForm');
                delForm.submit();
            }

        }

        function doBack(){
            var listForm = document.getElementById('listForm');
            listForm.action="{{url('backend/servCost/back')}}";
            listForm.submit();
        }






    </script>
@endsection







