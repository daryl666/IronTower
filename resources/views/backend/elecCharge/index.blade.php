@extends('layouts.app')

@section('header')
    <title>站址信息新增</title>
@endsection

@section('content')
    <div class="bar" style="font-weight:bold;">

        <a href="#">日常电费填报</a>
        <td>>>></td>
        <a href="#">日常电费查看</a>
    </div>
    <div class="list">

    <div class="body">
        <form id="listForm" method="post" action="{{url('backend/siteInfo/')}}" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="listBar">
                <td>
                    请选择地市来查看日常电费：
                </td>
                <td>
                    <select name="region" id="region">
                        <option>请选择...</option>
                        <option selected="selected" value="十堰">十堰</option>


                    </select>
                </td>




                <td>
                    &nbsp;&nbsp;&nbsp;
                    <input type="button" id="viewBtn" class="formButton" value="查询" hidefocus onclick="doSearch()"/>
                </td>
                <td style="float:left;margin-right:30px;">
                    <input type="button" class="formButton" value="新增记录" id="addBtn" style="float: right;" onclick="doAddPage()"/>
                </td>
                {{--<td>--}}
                {{--<input type="file" name="siteInfoFile"  style="width: 170px" id="siteInfoFile">--}}
                {{--</td>--}}
                {{--<td style="float:left;margin-right:30px;">--}}
                {{--<input type="button" class="formButton" value="导入" onclick="doImport()"/>--}}
                {{--</td>--}}
                <td>
                    <input type="button" class="formButton" value="导出" onclick="doExport()" @if(isset($infoSites)) style="display: inline;" @endif style="display: none;"/>
                </td>

            </div>
        </form>
    </div>
    <div id="">
        <table class="listTable" style="white-space:nowrap;font-size:12px;">
            <tr>
                <th>
                    <a href="#" class="sort" name="" hidefocus>操作</a>
                </th>
                <th>
                    <a href="#" class="sort" name="" hidefocus>月份</a>
                </th>
                <th>
                    <a href="#" class="sort" name="" hidefocus>电费（元/不含税）</a>
                </th>
                <th>
                    <a href="#" class="sort" name="" hidefocus>电费（元/含税）</a>
                </th>

            </tr>
            <tr>
                <td><a href="{{url('backend/elecCharge/edit')}}">编辑</a></td>
                <td>2015-12</td>
                <td>100.23</td>
                <td>111.25</td>
            </tr>
            </table>
                </div>
        </div>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {

            $('#menu_elecCharge').addClass("current");
        });

        function doAddPage(){
            var listForm = document.getElementById('listForm');
            listForm.action="{{url('backend/elecCharge/add')}}";
            listForm.submit();
        }


    </script>
@endsection







