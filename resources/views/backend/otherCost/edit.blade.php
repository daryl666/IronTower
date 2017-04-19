@extends('layouts.app')

@section('header')
    <title>站址信息新增</title>
@endsection

@section('content')
    <body class="input managerInfo">
    <div class="bar" style="font-weight:bold;">

        <a href="javascript:;" onclick="doBack()">其他费用填报</a>
        <td>>>></td>
        <a href="#">编辑费用</a>
    </div>

    <form id="listForm" method="post" action="{{url('backend/otherCost')}}" enctype="multipart/form-data"
          style="display: inline">
        {!! csrf_field() !!}
        <input name="region" type="hidden" value="{{$region}}">
        <input name="siteCode" type="hidden" value="{{$otherCosts->site_code}}">

        <table class="inputTable tabContent">
            <tr>
                <th>站址编码</th>
                <td>
                    <input type="text" @if($otherCosts->site_code)
                    value="{{$otherCosts->site_code}}" @endif disabled="disabled">
                </td>
            </tr>
            <tr>
                <th>
                    地市 :
                </th>
                <td>
                    <input type="text" @if($otherCosts->region_name)
                    value="{{$otherCosts->region_name}}" @endif disabled="disabled">
                </td>
            </tr>
            <tr>
                <th>wlan费用(元/月)</th>
                <td>
                    <input type="text" @if($otherCosts->fee_wlan)
                    value="{{$otherCosts->fee_wlan}}" @endif name="feeWlan">
                </td>
            </tr>
            <tr>
                <th>微波费用(元/月)</th>
                <td>
                    <input type="text" @if($otherCosts->fee_microwave)
                    value="{{$otherCosts->fee_microwave}}" @endif name="feeMicwav">
                </td>
            </tr>
            <tr>
                <th>超过10%高等级服务站址额外维护服务费(元/月)</th>
                <td>
                    <input type="text" @if($otherCosts->fee_add)
                    value="{{$otherCosts->fee_add}}" @endif name="feeAdd">
                </td>
            </tr>
            <tr>
                <th>蓄电池额外保障费(元/月)</th>
                <td>
                    <input type="text" @if($otherCosts->fee_battery)
                    value="{{$otherCosts->fee_battery}}" @endif name="feeBat">
                </td>
            </tr>
            <tr>
                <th>bbu安装在铁塔机房费(元/月)</th>
                <td>
                    <input type="text" @if($otherCosts->fee_bbu)
                    value="{{$otherCosts->fee_bbu}}" @endif name="feeBbu">
                </td>
            </tr>

        </table>
        <input type="button" value="提交" class="formButton" onclick="doEdit({{$otherCosts->id}})"/>

    </form>
    <form action="{{url('backend/otherCost/delete/'.$otherCosts->id)}}" method="get" style="display:inline;"
          id="delForm">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        <input type="hidden" value="{{$region}}" name="region">
        <input type="button" class="formButton" value="删除" onclick="doDel()">
    </form>
    <input type="button" value="返回" class="formButton" onclick="doBack()"/>


    </body>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {
            $('#menu_business').addClass("current");
        });

        function doEdit(id) {
            var siteCode = $('#siteCode').val();
            if (siteCode == '') {
                alert('请输入站址编码！');
                return;
            }
            if (confirm('确认修改吗？')) {
                var form = document.getElementById('listForm');
                var url = "{{url('backend/otherCost/edit')}}" + '/' + id;
                form.action = url;
                form.submit();
            }

        }

        function doBack(){
            var form = document.getElementById('listForm');
            form.action = "{{url('backend/otherCost/back')}}";
            form.submit();
        }

        function doDel(){
            if (confirm('确认删除吗？')){
                var form = document.getElementById('delForm');
                form.submit();
            }
        }


    </script>
@endsection







