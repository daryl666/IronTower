@extends('layouts.app')

@section('header')
    <title>服务价格查询</title>
@endsection

@section('script_header')


    @endsection
@section('content')
    <div class="list">
        <div class="body">
            <form id="listForm" method="post" action="{{url('backend/servPrice/')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="listBar">
                    <div style="float:left;font-size:15px;margin-top:5px">
                        请选择区县查看站址的月服务价格：
                    </div>

                    <select name="region" id="region">
                        <option>请选择...</option>
                        <option @if(isset($filter['region']) && $filter['region']=='十堰') selected="selected" @endif>十堰</option>
                    </select>
                    <td>
                        &nbsp;&nbsp;&nbsp;
                        <input type="button" id="viewBtn" class="formButton" value="查询" onclick="doSearch()" hidefocus />
                    </td>

                </div>
            </form>
        </div>
        <div id="servPrice">
            <table class="listTable" style="white-space:nowrap;">
                {{--<tr>--}}
                    {{--<label style="margin-right:10px;font-size:15px;">你可以输入站址编码进行过滤</label>--}}
                    {{--<input type="text" style="width:100px;">--}}
                    {{--<button class="buttonNextStep" id="filter" style="margin:5px">过滤</button>--}}

                {{--</tr>--}}
                <tr>
                    <th>
                        <a href="#" class="sort" name="userlabel" hidefocus>站址编码</a>

                    </th>
                    <th>
                        <a href="#" class="sort" name="intId" hidefocus>基准价格（元/不含税）</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="objectRdn" hidefocus>基准价格（元/含税）</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="scanStartTime" hidefocus>场地费（元/不含税）</a>
                    </th>
                    <th class="scanStopTime">
                        <a href="#" class="sort" name="scanStopTime" hidefocus>场地费（元/含税）</a>
                    </th>
                    <th class="gp">
                        <a href="#" class="sort" name="gp" hidefocus>电力引入费（元/不含税）</a>
                    </th>
                    <th class="freqMode">
                        <a href="#" class="sort" name="freqMode" hidefocus>电力引入费（元/含税）</a>
                    </th>

                </tr>
                @if(isset($servPrices))
                    @foreach($servPrices as $servPrice)
                        <tr>
                            <td>{{$servPrice->site_code}}</td>
                            <td>{{$servPrice->fee_basic}}</td>
                            <td>{{$servPrice->fee_basic_taxed}}</td>
                            <td>{{$servPrice->fee_site}}</td>
                            <td>{{$servPrice->fee_site_taxed}}</td>
                            <td>{{$servPrice->fee_import}}</td>
                            <td>{{$servPrice->fee_import_taxed}}</td>
                        </tr>
                    @endforeach
                @endif

            </table>
        </div>
    </div>
    @endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function() {

            $('#menu_price').addClass("current");
        });

        function doSearch(){
            var region = $('#region').val();
            if(region == '请选择...'){
                alert('请选择所在区域');
                return;
            }
            var form = $('#listForm');
            form.submit();
        }
    </script>
@endsection