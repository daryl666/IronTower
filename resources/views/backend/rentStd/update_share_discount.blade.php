
@extends('layouts.app')

@section('header')
    <title>场地费修改</title>
@endsection

@section('content')
    <div class="bar" style="font-weight:bold;">
        <a href="{{url('backend/rentStd')}}">月租标准查询</a>
        <td>>>></td>
        <a href="{{url('backend/rentStd/fee_std_search?fee_type=基准价格')}}">共享折扣</a>
        <td>>>></td>
        <a href="#">共享折扣修改</a>
    </div>
    <div id="validateErrorContainer" class="validateErrorContainer">

    </div>
    <div class="body input">
        <form id="share_discount" method="post"  action="{{url('backend/rentStd/update_share_discount')}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @if(isset($share_discount))
            <table class="inputTable tabContent">
                <tr>
                    <th>
                        是否为新建站:
                    </th>
                    <td>
                        <select name="is_new_tower">
                            <option>{{$share_discount->is_new_tower}}</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        共享类型:
                    </th>
                    <td>
                        <select name="share_num">
                            <option>{{$share_discount->share_num}}</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        用户类型:
                    </th>
                    <td>
                        <select id="siteDistType" name="user_type" class="formText" >
                            <option>{{$share_discount->user_type}}</option>
                        </select>

                    </td>
                </tr>
                <tr>
                    <th>
                        是否存在新增共享:
                    </th>
                    <td>
                        <select name="is_newly_added">
                            <option>{{$share_discount->is_newly_added}}</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        基准价格折扣:
                    </th>
                    <td>
                        <input type="text" name="discount_basic" value="{{$share_discount->discount_basic}}">

                    </td>
                </tr>
                <tr>
                    <th>
                        场地费折扣:
                    </th>
                    <td>
                        <input type="text" name="discount_site" value="{{$share_discount->discount_site}}">

                    </td>
                </tr>
                <tr>
                    <th>
                        电力引入费折扣:
                    </th>
                    <td>
                        <input type="text" name="discount_import" value="{{$share_discount->discount_import}}">

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
                $('#share_discount').submit();
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





