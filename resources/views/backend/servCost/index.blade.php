@extends('layouts.app')

@section('header')
    <title>服务费用填报/title>
        @endsection

        @section('script_header')
            <script type="text/javascript">

            </script>
        @endsection

        @section('content')
            <div class="container" style="width:100% ">
                <div class="row clearfix">
                    <div class="col-md-12 column" style="padding: 0">
                        <div class="collapse navbar-collapse" id="example-navbar-collapse">
                            <ul class="nav nav-tabs">
                                <li class="inactive">
                                    <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">站址信息维护</a>
                                </li>
                                <li class="active">
                                    <a href="{{url('backend/servCost')}}">服务费用填报</a>
                                </li>
                                <li class="inactive">
                                    <a href="{{url('backend/gnrRec')}}">发电记录填报</a>
                                </li>
                                <li class="inactive">
                                    <a href="{{url('backend/otherCost')}}">其他费用填报</a>
                                </li>
                                <li class="dropdown inactiive">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        扣费记录填报 <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">上站记录填报</a></li>
                                        <li class="divider"></li>
                                        <li><a href="{{url('backend/siteShield')}}">屏蔽记录填报</a></li>
                                        <li class="divider"></li>
                                        <li><a href="{{url('backend/osReasonFill?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">退服原因填报</a></li>

                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <ul class="breadcrumb" style="margin-bottom: 0;background-color: #F5F5F5">
                            <li>
                                <a href="#">Home</a>
                            </li>
                            <li>
                                <a href="#">Library</a>
                            </li>
                            <li class="active">
                                Data
                            </li>
                        </ul>
                    </div>
                </div>

            </div>


            <div class="list">
                <div class="body">
                    <form id="listForm" method="post" action="{{url('backend/servCost/')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="listBar">
                            <div style="float:left;margin-top:5px">
                                请选择地市和起止日期查看服务费用记录：
                            </div>
                            @if(Auth::user()->area_level == '湖北省' || Auth::user()->area_level == 'admin')
                                <select name="region" id="region">
                                    <option @if(isset($filter['region']) && $filter['region']=='湖北省') selected="selected"
                                            @endif value="湖北省">湖北省
                                    </option>
                                    <option @if(isset($filter['region']) && $filter['region']=='武汉') selected="selected"
                                            @endif value="武汉">武汉
                                    </option>
                                    <option @if(isset($filter['region']) && $filter['region']=='黄石') selected="selected"
                                            @endif value="黄石">黄石
                                    </option>
                                    <option @if(isset($filter['region']) && $filter['region']=='十堰') selected="selected"
                                            @endif value="十堰">十堰
                                    </option>
                                    <option @if(isset($filter['region']) && $filter['region']=='宜昌') selected="selected"
                                            @endif value="宜昌">宜昌
                                    </option>
                                    <option @if(isset($filter['region']) && $filter['region']=='襄阳') selected="selected"
                                            @endif value="襄阳">襄阳
                                    </option>
                                    <option @if(isset($filter['region']) && $filter['region']=='鄂州') selected="selected"
                                            @endif value="鄂州">鄂州
                                    </option>
                                    <option @if(isset($filter['region']) && $filter['region']=='荆门') selected="selected"
                                            @endif value="荆门">荆门
                                    </option>
                                    <option @if(isset($filter['region']) && $filter['region']=='孝感') selected="selected"
                                            @endif value="孝感">孝感
                                    </option>
                                    <option @if(isset($filter['region']) && $filter['region']=='荆州') selected="selected"
                                            @endif value="荆州">荆州
                                    </option>
                                    <option @if(isset($filter['region']) && $filter['region']=='黄冈') selected="selected"
                                            @endif value="黄冈">黄冈
                                    </option>
                                    <option @if(isset($filter['region']) && $filter['region']=='咸宁') selected="selected"
                                            @endif value="咸宁">咸宁
                                    </option>
                                    <option @if(isset($filter['region']) && $filter['region']=='随州') selected="selected"
                                            @endif value="随州">随州
                                    </option>
                                    <option @if(isset($filter['region']) && $filter['region']=='恩施') selected="selected"
                                            @endif value="恩施">恩施
                                    </option>
                                    <option @if(isset($filter['region']) && $filter['region']=='仙桃') selected="selected"
                                            @endif value="仙桃">仙桃
                                    </option>
                                    <option @if(isset($filter['region']) && $filter['region']=='潜江') selected="selected"
                                            @endif value="潜江">潜江
                                    </option>
                                    <option @if(isset($filter['region']) && $filter['region']=='天门') selected="selected"
                                            @endif value="天门">天门
                                    </option>
                                    <option @if(isset($filter['region']) && $filter['region']=='林区') selected="selected"
                                            @endif value="林区">林区
                                    </option>
                                </select>
                            @endif

                            @if(Auth::user()->area_level == '武汉')
                                <select name="region" id="region">
                                    <option @if(isset($filter['region']) && $filter['region']=='武汉') selected="selected"
                                            @endif value="武汉">武汉
                                    </option>
                                </select>
                            @endif

                            @if(Auth::user()->area_level == '黄石')
                                <select name="region" id="region">
                                    <option @if(isset($filter['region']) && $filter['region']=='黄石') selected="selected"
                                            @endif value="黄石">黄石
                                    </option>
                                </select>
                            @endif

                            @if(Auth::user()->area_level == '十堰')
                                <select name="region" id="region">
                                    <option @if(isset($filter['region']) && $filter['region']=='十堰') selected="selected"
                                            @endif value="十堰">十堰
                                    </option>
                                </select>
                            @endif

                            @if(Auth::user()->area_level == '宜昌')
                                <select name="region" id="region">
                                    <option @if(isset($filter['region']) && $filter['region']=='宜昌') selected="selected"
                                            @endif value="宜昌">宜昌
                                    </option>
                                </select>
                            @endif

                            @if(Auth::user()->area_level == '襄阳')
                                <select name="region" id="region">
                                    <option @if(isset($filter['region']) && $filter['region']=='襄阳') selected="selected"
                                            @endif value="襄阳">襄阳
                                    </option>
                                </select>
                            @endif

                            @if(Auth::user()->area_level == '鄂州')
                                <select name="region" id="region">
                                    <option @if(isset($filter['region']) && $filter['region']=='鄂州') selected="selected"
                                            @endif value="鄂州">鄂州
                                    </option>
                                </select>
                            @endif

                            @if(Auth::user()->area_level == '荆门')
                                <select name="region" id="region">
                                    <option @if(isset($filter['region']) && $filter['region']=='荆门') selected="selected"
                                            @endif value="荆门">荆门
                                    </option>
                                </select>
                            @endif

                            @if(Auth::user()->area_level == '孝感')
                                <select name="region" id="region">
                                    <option @if(isset($filter['region']) && $filter['region']=='孝感') selected="selected"
                                            @endif value="孝感">孝感
                                    </option>
                                </select>
                            @endif

                            @if(Auth::user()->area_level == '荆州')
                                <select name="region" id="region">
                                    <option @if(isset($filter['region']) && $filter['region']=='荆州') selected="selected"
                                            @endif value="荆州">荆州
                                    </option>
                                </select>
                            @endif

                            @if(Auth::user()->area_level == '黄冈')
                                <select name="region" id="region">
                                    <option @if(isset($filter['region']) && $filter['region']=='黄冈') selected="selected"
                                            @endif value="黄冈">黄冈
                                    </option>
                                </select>
                            @endif

                            @if(Auth::user()->area_level == '咸宁')
                                <select name="region" id="region">
                                    <option @if(isset($filter['region']) && $filter['region']=='咸宁') selected="selected"
                                            @endif value="咸宁">咸宁
                                    </option>
                                </select>
                            @endif

                            @if(Auth::user()->area_level == '随州')
                                <select name="region" id="region">
                                    <option @if(isset($filter['region']) && $filter['region']=='随州') selected="selected"
                                            @endif value="随州">随州
                                    </option>
                                </select>
                            @endif

                            @if(Auth::user()->area_level == '恩施')
                                <select name="region" id="region">
                                    <option @if(isset($filter['region']) && $filter['region']=='恩施') selected="selected"
                                            @endif value="恩施">恩施
                                    </option>
                                </select>
                            @endif

                            @if(Auth::user()->area_level == '仙桃')
                                <select name="region" id="region">
                                    <option @if(isset($filter['region']) && $filter['region']=='仙桃') selected="selected"
                                            @endif value="仙桃">仙桃
                                    </option>
                                </select>
                            @endif

                            @if(Auth::user()->area_level == '潜江')
                                <select name="region" id="region">
                                    <option @if(isset($filter['region']) && $filter['region']=='潜江') selected="selected"
                                            @endif value="潜江">潜江
                                    </option>
                                </select>
                            @endif

                            @if(Auth::user()->area_level == '天门')
                                <select name="region" id="region">
                                    <option @if(isset($filter['region']) && $filter['region']=='天门') selected="selected"
                                            @endif value="天门">天门
                                    </option>
                                </select>
                            @endif

                            @if(Auth::user()->area_level == '林区')
                                <select name="region" id="region">
                                    <option @if(isset($filter['region']) && $filter['region']=='林区') selected="selected"
                                            @endif value="林区">林区
                                    </option>
                                </select>
                            @endif
                            <td>
                                统计起始时间:
                                <input type="text" id="beginDate" name="beginDate" style="width:60px;padding-left:5px"
                                       readonly="true" @if(isset($filter['beginDate'])) value="{{$filter['beginDate']}}"
                                       @endif onclick="WdatePicker({dateFmt:'yyyy-MM'})"/>
                                ~
                                统计结束时间:
                                <input type="text" id="endDate" name="endDate" style="width:60px;padding-left:5px"
                                       readonly="true" @if(isset($filter['endDate'])) value="{{$filter['endDate']}}"
                                       @endif onclick="WdatePicker({dateFmt:'yyyy-MM'})"/>


                            </td>
                            &nbsp;&nbsp;
                            <td>

                                <input type="button" id="" class="formButton" value="查询" hidefocus
                                       onclick="doSearch()"/>
                            </td>
                            <td>

                                <input type="button" id="" class="formButton" value="新增记录" hidefocus onclick="doAdd()"
                                       style="float: right;"/>
                            </td>
                            <td>

                                <input type="button" id="" class="formButton" value="导出" hidefocus onclick="doExport()"
                                       @if(isset($servCosts)) style="display: inline;" @endif style="display: none;"/>
                            </td>

                        </div>
                    </form>
                </div>
                <div id="siteInfo" style="">
                    <table class="listTable" style="white-space:nowrap;font-size: 12px;">
                        <!-- <tr>

                                <label style="margin-right:10px;font-size:15px;">你可以输入站址编码进行过滤</label>
                                <input type="text" style="width:100px;">
                                <button class="buttonNextStep" id="filter" style="margin:5px">过滤</button>

                            </tr> -->
                        <tr>
                            <th>
                                <a href="#" class="sort" name="" hidefocus>操作</a>
                            </th>
                            <th>
                                <a href="#" class="sort" name="" hidefocus>地市</a>
                            </th>
                            <th>
                                <a href="#" class="sort" name="" hidefocus>提交时间</a>
                            </th>
                            <th>
                                <a href="#" class="sort" name="" hidefocus>服务费用日期</a>
                            </th>
                            <th>
                                <a href="#" class="sort" name="" hidefocus>站址总数</a>
                            </th>
                            <th>
                                <a href="#" class="sort" name="" hidefocus>铁塔基准价格（元/不含税）</a>
                            </th>
                            <th>
                                <a href="#" class="sort" name="" hidefocus>机房基准价格（元/不含税）</a>
                            </th>
                            <th>
                                <a href="#" class="sort" name="" hidefocus>配套基准价格（元/不含税）</a>
                            </th>
                            <th>
                                <a href="#" class="sort" name="" hidefocus>维护费基准价格（元/不含税）</a>
                            </th>
                            <th class="gp">
                                <a href="#" class="sort" name="" hidefocus>场地费（元/不含税）</a>
                            </th>

                            <th class="freqMode">
                                <a href="#" class="sort" name="" hidefocus>电力引入费（元/不含税）</a>
                            </th>
                            <th class="freqMode">
                                <a href="#" class="sort" name="" hidefocus>油机发电包干费（元/不含税）</a>
                            </th>


                        </tr>
                        @if(isset($servCosts))
                            @foreach($servCosts as $servCost)
                                <tr>
                                    {{--<td>--}}
                                    {{--<a href="{{url('backend/servCost/'.$servCost->id.'/editPage'.'/'.$servCost->beginDate.'/'.$servCost->endDate)}}"--}}
                                    {{--class="">编辑</a></td>--}}
                                    <td><a href="javascript:void(0)"
                                           onclick="doEditPage({{json_encode(array($servCost->id))}})">编辑</a>
                                        {{--{{$servCost->id}},{{$servCost->beginDate}},{{$servCost->endDate}}--}}
                                    </td>
                                    <td>{{$servCost->region_name}}</td>
                                    <td>{{$servCost->created_at}}</td>
                                    <td>{{$servCost->month}}</td>
                                    <td>{{$servCost->site_num}}</td>
                                    <td>{{$servCost->fee_tower}}</td>
                                    <td>{{$servCost->fee_house}}</td>
                                    <td>{{$servCost->fee_support}}</td>
                                    <td>{{$servCost->fee_maintain}}</td>

                                    <td>{{($servCost->fee_site)}}</td>
                                    <td>{{($servCost->fee_import)}}</td>
                                    <td>{{($servCost->fee_gnr_allincharge)}}</td>
                                    {{--<td>{{$servCost->fee_electricity}}</td>--}}


                                </tr>
                            @endforeach
                        @endif

                    </table>
                </div>
            </div>
        @endsection


        @section('script_footer')
            <script type="text/javascript">
                $().ready(function () {
                    $('#menu_business').addClass("current");
                });


                function doSearch() {
                    var region = $('#region').val();
                    var beginDate = $('#beginDate').val();
                    var endDate = $('#endDate').val();
//                    if (region == '请选择...') {
//                        alert('请选择所在区域！');
//                        return;
//                    }
//                    if (beginDate == '') {
//                        alert('请选择起始时间！');
//                        return;
//                    }
//                    if (endDate == '') {
//                        alert('请选择终止时间！');
//                        return;
//                    }
                    var listForm = document.getElementById('listForm');
                    listForm.action = "{{url('backend/servCost/')}}";
                    listForm.submit();
                }

                function doAdd() {
                    var listForm = document.getElementById('listForm');
                    var region = $('#region').val();
                    if (region == '湖北省') {
                        alert('请选择一个地市！');
                        return;
                    }
                    listForm.action = "{{url('backend/servCost/addPage')}}"
                    listForm.submit();
                }

                function doExport() {
                    var listForm = document.getElementById("listForm");
                    listForm.action = "{{url('backend/servCost/export')}}";
                    listForm.submit();
                }

                function doEditPage(info) {
                    var id = info[0];
//                    var beginDate = info[1];
//                    var endDate = info[2];
                    var listForm = document.getElementById("listForm");
                    var region = $('#region').val();
                    var url = "{{url('backend/servCost/editPage')}}" + '/' + id + '/' + region;
                    listForm.action = url;
                    listForm.submit();

                }
            </script>
@endsection








