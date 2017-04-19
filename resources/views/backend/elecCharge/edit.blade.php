@extends('layouts.app')

@section('header')
    <title>编辑站址信息</title>
@endsection

@section('content')
    <div class="bar" style="font-weight:bold;">

        <a href="javascript:;" onclick="doBack()">日常电费填报</a>
        <td>>>></td>
        <a href="#">日常电费编辑</a>
    </div>

    <body class="input managerInfo">
    <div class="bar">
        <div style="float:left;">
            请修改或者删除电费信息
        </div>

    </div>
    <div id="validateErrorContainer" class="validateErrorContainer">

    </div>

    <form id="listForm" method="POST" action="{{url('backend/siteInfo/update')}}" style="display: inline;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <table class="inputTable tabContent">
            <tr>
                <th>
                    地市 :
                </th>
                <td>

                    <input name="region" type="text" value="十堰" id="region" readonly="true">
                </td>
            </tr>
            <tr>
                <th>
                    月份 :
                </th>

                <td>
                    <input type="text" id="endDate" name="endDate" style="width:130px;padding-left:5px"
                           readonly="true" onclick="WdatePicker({dateFmt:'yyyy-MM'})" value="2015-12"/>
                </td>
            </tr>
            <tr>
                <th>
                    电费（元/不含税）:
                </th>
                <td>
                    <input type="text" value="100.23">
                </td>
            </tr>
            <tr>
                <th>
                    电费（元/含税）:
                </th>
                <td>
                    <input type="text" value="111.25">
                </td>
            </tr>





        </table>
        <input type="button" value="修改" class="formButton">
        <input type="button" value="删除" class="formButton">
        <input type="button" value="返回" class="formButton" onclick="doBack()">

    </form>

    </body>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {

            $('#menu_elecCharge').addClass("current");
        });

        function doBack(){
            var listForm = document.getElementById('listForm');
            listForm.action="{{url('backend/elecCharge/back')}}"
            listForm.submit();
        }



    </script>
@endsection









