
@extends('layouts.app')

@section('header')
    <title>电力引入费修改</title>
@endsection

@section('content')
    <div class="bar" style="font-weight:bold;">
        <a href="{{url('backend/rentStd')}}">月租标准查询</a>
        <td>>>></td>
        <a href="{{url('backend/rentStd/fee_std_search?fee_type=电力引入费')}}">电力引入费</a>
        <td>>>></td>
        <a href="#">电力引入费修改</a>
    </div>
    <div id="validateErrorContainer" class="validateErrorContainer">

    </div>
    <div class="body input">
        <form id="elec_introduced_fee" method="post" action="{{url('backend/rentStd/update_elec_introduced_fee')}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @if(isset($elec_introduced_fee))
            <table class="inputTable tabContent">
                <tr>
                    <th>
                        地市:
                    </th>
                    <td>
                        <select name="region_name">
                            <option>{{$elec_introduced_fee->region_name}}</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        引电类型(V):
                    </th>
                    <td>
                        <select id="elecIntroType" name="elec_introduced_type" class="formText" >
                            <option>{{$elec_introduced_fee->elec_introduced_type}}</option>
                        </select>

                    </td>
                </tr>
                <tr>
                    <th>
                        电力引入费(元/天)(不含税):
                    </th>
                    <td>
                    <input type="text" name="fee_import" value="{{$elec_introduced_fee->fee_import}}">

                    </td>
                </tr>
            </table>
            @endif
            <input type="button"  class="formButton" onclick="update_confirm()" value="修改">
            <input type="button" class="formButton" onclick="location.href=history.go(-1)" value="返回">
        </form>
    </div>
@endsection
@section('script_footer')
    <script type="text/javascript">
        function update_confirm() {
            if(confirm('确认修改吗?')){
                $('#elec_introduced_fee').submit();
            }
        }
    </script>
@endsection

@section('script_footer')
    <script type="text/javascript" src="{{ URL::asset('common/datePicker/WdatePicker.js')}}"></script>
    <script type="text/javascript">
        $().ready(function() {
            $('#rent_std').addClass("current");
        });

    </script>
@endsection





