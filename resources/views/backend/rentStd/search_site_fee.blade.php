@extends('layouts.app')

@section('header')
    <title>场地费标准查询</title>
@endsection

@section('content')
    <div class="container" style="width:100% ">
        <div class="row clearfix">
            <div class="col-md-12 column" style="padding: 0">
                <div class="collapse navbar-collapse" id="example-navbar-collapse">
                    <ul class="nav nav-tabs">
                        <li class="inactive">
                            <a href="{{url('backend/userManage')}}">用户管理</a>
                        </li>
                        <li class="inactive">
                            <a href="{{url('backend/eventLog')}}">日志管理</a>
                        </li>
                        <li class="active">
                            <a href="{{url('backend/rentStd')}}">计费标准管理</a>
                        </li>

                    </ul>
                    <ul class="breadcrumb" style="margin-bottom: 0;background-color: #F5F5F5">
                        当前位置：
                        <li>
                            <a href="{{url('backend/userManage')}}">系统管理</a>
                        </li>
                        <li>
                            <a href="{{url('backend/rentStd')}}">计费标准管理</a>
                        </li>
                        <li class="active">
                            <a href="#">场地费查询</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

    </div>
    <div class="list">
        <div class="body">
            <form id="listForm" method="post" target="_self" action="{{url('backend/rentStd/fee_std_search')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="listBar">
                    <td>请选择地市：</td>
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
                    @if(Auth::user()->area_level != '湖北省' && Auth::user()->area_level != 'admin')
                        <select name="region" id="region">
                            @if(Auth::user()->area_level == '武汉')
                                <option @if(isset($filter['region']) && $filter['region']=='武汉') selected="selected"
                                        @endif value="武汉">武汉
                                </option>
                            @endif

                            @if(Auth::user()->area_level == '黄石')
                                <option @if(isset($filter['region']) && $filter['region']=='黄石') selected="selected"
                                        @endif value="黄石">黄石
                                </option>
                            @endif

                            @if(Auth::user()->area_level == '十堰')
                                <option @if(isset($filter['region']) && $filter['region']=='十堰') selected="selected"
                                        @endif value="十堰">十堰
                                </option>
                            @endif

                            @if(Auth::user()->area_level == '宜昌')
                                <option @if(isset($filter['region']) && $filter['region']=='宜昌') selected="selected"
                                        @endif value="宜昌">宜昌
                                </option>
                            @endif

                            @if(Auth::user()->area_level == '襄阳')
                                <option @if(isset($filter['region']) && $filter['region']=='襄阳') selected="selected"
                                        @endif value="襄阳">襄阳
                                </option>
                            @endif

                            @if(Auth::user()->area_level == '鄂州')
                                <option @if(isset($filter['region']) && $filter['region']=='鄂州') selected="selected"
                                        @endif value="鄂州">鄂州
                                </option>
                            @endif

                            @if(Auth::user()->area_level == '荆门')
                                <option @if(isset($filter['region']) && $filter['region']=='荆门') selected="selected"
                                        @endif value="荆门">荆门
                                </option>
                            @endif

                            @if(Auth::user()->area_level == '孝感')
                                <option @if(isset($filter['region']) && $filter['region']=='孝感') selected="selected"
                                        @endif value="孝感">孝感
                                </option>
                            @endif

                            @if(Auth::user()->area_level == '荆州')
                                <option @if(isset($filter['region']) && $filter['region']=='荆州') selected="selected"
                                        @endif value="荆州">荆州
                                </option>
                            @endif

                            @if(Auth::user()->area_level == '黄冈')
                                <option @if(isset($filter['region']) && $filter['region']=='黄冈') selected="selected"
                                        @endif value="黄冈">黄冈
                                </option>
                            @endif

                            @if(Auth::user()->area_level == '咸宁')
                                <option @if(isset($filter['region']) && $filter['region']=='咸宁') selected="selected"
                                        @endif value="咸宁">咸宁
                                </option>
                            @endif

                            @if(Auth::user()->area_level == '随州')
                                <option @if(isset($filter['region']) && $filter['region']=='随州') selected="selected"
                                        @endif value="随州">随州
                                </option>
                            @endif

                            @if(Auth::user()->area_level == '恩施')
                                <option @if(isset($filter['region']) && $filter['region']=='恩施') selected="selected"
                                        @endif value="恩施">恩施
                                </option>
                            @endif

                            @if(Auth::user()->area_level == '仙桃')
                                <option @if(isset($filter['region']) && $filter['region']=='仙桃') selected="selected"
                                        @endif value="仙桃">仙桃
                                </option>
                            @endif

                            @if(Auth::user()->area_level == '潜江')
                                <option @if(isset($filter['region']) && $filter['region']=='潜江') selected="selected"
                                        @endif value="潜江">潜江
                                </option>
                            @endif

                            @if(Auth::user()->area_level == '天门')
                                <option @if(isset($filter['region']) && $filter['region']=='天门') selected="selected"
                                        @endif value="天门">天门
                                </option>
                            @endif

                            @if(Auth::user()->area_level == '林区')
                                <option @if(isset($filter['region']) && $filter['region']=='林区') selected="selected"
                                        @endif value="林区">林区
                                </option>
                            @endif
                        </select>
                    @endif
                    <td>请选择要查询的价格或折扣：</td>
                    <select name="fee_type">
                        <option>铁塔基准价格</option>
                        <option>机房基准价格</option>
                        <option>配套基准价格</option>
                        <option>维护费</option>
                        <option selected="selected">场地费</option>
                        <option>电力引入费</option>
                        <option>共享折扣</option>
                    </select>
                    <input type="button" id="viewBtn" class="formButton" value="查询" hidefocus onclick="doSearch()"/>
                    {{--<input type="button" id="viewBtn" class="formButton" value="导出" hidefocus onclick="exportStd()"/>--}}
                </div>
            </form>
        </div>
        <div id="site_fee">
            <table class="listTable" style="white-space:nowrap;">
                {{--<th class="freqMode">--}}
                    {{--<a href="#" class="sort" name="freqMode" hidefocus>操作</a>--}}
                {{--</th>--}}
                <th class="freqMode">
                    <a href="#" class="sort" name="freqMode" hidefocus>地市</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="freqMode" hidefocus>站址所在地区类型</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="freqMode" hidefocus>是否RRU拉远</a>
                </th>
                <th class="freqMode">
                    <a href="#" class="sort" name="freqMode" hidefocus>场地费(元/天)(不含税)</a>
                </th>

                </tr>

                @if(isset($site_fees))
                    @foreach($site_fees as $site_fee)
                        <tr>
{{--                            <td><a href="{{url('backend/rentStd/site_fee_update/'.$site_fee->seq)}}">修改</a></td>--}}
                            <td>{{$site_fee->region_name}}</td>
                            <td>{{transSiteDistType($site_fee->site_district_type) }}</td>
                            <td>{{transIsRRUAway($site_fee->is_rru_away) }}</td>
                            <td>{{$site_fee->fee_site}}</td>
                        </tr>
                    @endforeach
                @endif

            </table>
        </div>
    </div>
@endsection

@section('script_footer')
    <script type="text/javascript" src="{{ URL::asset('common/datePicker/WdatePicker.js')}}"></script>
    <script type="text/javascript">
        $().ready(function () {
            $('#menu_sys').addClass("current");
        });

        function exportStd() {
            var listForm = document.getElementById('listForm');
            listForm.action = "{{url('backend/rentStd/exportSiteFee')}}";
            listForm.submit();
        }

        function doSearch() {
            var listForm = document.getElementById('listForm');
            listForm.action = "{{url('backend/rentStd/fee_std_search')}}";
            listForm.submit();
        }

    </script>
@endsection







