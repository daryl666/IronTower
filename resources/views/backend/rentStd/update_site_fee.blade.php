
@extends('layouts.app')

@section('header')
    <title>场地费修改</title>
@endsection

@section('content')
    <div class="bar" style="font-weight:bold;">
        <a href="{{url('backend/rentStd')}}">月租标准查询</a>
        <td>>>></td>
        <a href="{{url('backend/rentStd/fee_std_search?fee_type=场地费')}}">场地费</a>
        <td>>>></td>
        <a href="#">场地费修改</a>
    </div>
    <div id="validateErrorContainer" class="validateErrorContainer">

    </div>
    <div class="body input">
        <form id="site_fee" method="post" action="{{url('backend/rentStd/update_site_fee')}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @if(isset($site_fee))
            <table class="inputTable tabContent">
                <tr>
                    <th>
                        地市:
                    </th>
                    <td>
                        <select name="region_name">
                            <option>{{$site_fee->region_name}}</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        站址所在地区类型:
                    </th>
                    <td>
                        <select id="siteDistType" name="site_district_type" class="formText" >
                            <option>{{$site_fee->site_district_type}}</option>
                        </select>

                    </td>
                </tr>
                <tr>
                    <th>
                        是否RRU拉远:
                    </th>
                    <td>
                        <select id="rruAway" name="is_rru_away" class="formText" >
                            <option>{{$site_fee->is_rru_away}}</option>
                        </select>

                    </td>
                </tr>
                <tr>
                    <th>
                        场地费(元/天)(不含税):
                    </th>
                    <td>
                        <input type="text" name="fee_site" value="{{$site_fee->fee_site}}">

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
                $('#site_fee').submit();
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





