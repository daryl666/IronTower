
@extends('layouts.app')

@section('header')
    <title>基准价格修改</title>
@endsection

@section('content')
    <div class="bar" style="font-weight:bold;">
        <a href="{{url('backend/rentStd')}}">月租标准查询</a>
        <td>>>></td>
        <a href="{{url('backend/rentStd/fee_std_search?fee_type=基准价格')}}">基准价格</a>
        <td>>>></td>
        <a href="#">基准价格修改</a>
    </div>
    <div id="validateErrorContainer" class="validateErrorContainer">

    </div>
    <div class="input managerInfo">
        <form id="basic_fee" method="post" action="{{url('backend/rentStd/update_basic_fee')}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @if(!empty($basic_fee))
            <table class="inputTable tabContent">
                <tr>
                    <th>
                        产品配套类型:
                    </th>
                    <td>
                        <select name="product_type" class="towerType" id="towerType">
                            <option>{{$basic_fee->product_type}}</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        铁塔类型:
                    </th>
                    <td>
                        <select name="tower_type" class="formText" id="towerType">
                            <option>{{$basic_fee->tower_type}}</option>
                        </select>

                    </td>
                </tr>
                <tr>
                    <th>
                        系统挂高(米):
                    </th>
                    <td>
                        <select name="sys_height">
                            <option>{{$basic_fee->sys_height}}</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        是否为新建站:
                    </th>
                    <td>
                        <select name="is_new_tower">
                            <option>{{$basic_fee->is_new_tower}}</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        基准价格(元/天)(不含税):
                    </th>
                    <td>
                        <input type="text" name="fee_basic"  value="{{$basic_fee->fee_basic}}">

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
            $('#basic_fee').submit();
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





