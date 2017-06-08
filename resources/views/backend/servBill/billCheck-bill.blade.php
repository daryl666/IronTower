@extends('layouts.app')

@section('header')
    <title>未出服务账单列表</title>
@endsection

@section('script_header')

@endsection


@section('content')
    <div class="container" style="width:100% ">
        <div class="row clearfix">
            <div class="col-md-12 column" style="padding: 0">
                <ul class="nav nav-tabs">
                    <li class="inactive">
                        <a href="{{url('backend/servBill')}}">账单管理</a>
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/servBill/irontowerBillImportPage')}}">铁塔详单导入</a>
                    </li>
                    <li class="active">
                        <a href="{{url('backend/servBill/billCheck')}}">账单稽查</a>
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/siteStats/')}}">铁塔详单统计</a>
                    </li>
                </ul>
                <ul class="breadcrumb" style="margin-bottom: 0;background-color: #F5F5F5">
                    当前位置：
                    <li>
                        <a href="{{url('backend/servBill/billCheck')}}">账单稽查</a>
                    </li>
                    <li class="active">
                        <a href="#">账单比对</a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
    <div class="list">
        <div class="body">
            <form id="listForm" method="post" action="{{URL('backend/servBill/')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="listBar">
                    <label>选择月份和地市进行账单稽查：</label>
                    <table>
                        <tr>
                            <td>
                                月份:
                                <input type="text" id="month" name="month" style="width:130px;padding-left:5px"
                                       readonly="true"
                                       @if(isset($filter['month'])) value="{{$filter['month']}}" @endif
                                       onclick="WdatePicker({dateFmt:'yyyy-MM'})"/>
                            </td>
                            <td>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                地市：
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
                            </td>
                            <td>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="button" id="checkBtn" class="formButton" value="稽 查"
                                       onclick="doCheck()"/>
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>

        <table class="listTable" style="white-space:nowrap;" id="servBill">
            <tr>
                <th>
                    <a href="#" class="sort" hidefocus>操作</a>
                </th>
                <th>
                    <a href="" class="sort">地市</a>
                </th>
                <th>
                    <a href="#" class="sort" hidefocus>账单来源</a>

                </th>
                <th>
                    <a href="#" class="sort" hidefocus>铁塔基准价格</a>
                </th>
                <th>
                    <a href="#" class="sort" hidefocus>机房基准价格</a>
                </th>
                <th>
                    <a href="#" class="sort" hidefocus>配套基准价格</a>
                </th>
                <th>
                    <a href="#" class="sort" hidefocus>维护费</a>
                </th>
                <th>
                    <a href="#" class="sort" hidefocus>场地费</a>
                </th>
                <th>
                    <a href="#" class="sort" hidefocus>电力引入费</a>
                </th>
                <th>
                    <a href="#" class="sort" hidefocus>月服务成本</a>
                </th>
            </tr>

            @if (isset($telecomBills))
                @foreach($telecomBills as $telecomBill)
                    <tr>
                        <td rowspan="2">
                            <button class="buttonNextStep" onclick="viewBillSites({{$telecomBill->id}})">明细</button>
                        </td>
                        <td rowspan="2">{{transRegion($telecomBill->region_id)}}</td>
                        <td>电信</td>
                        <td @if(!$telecomBill->is_fee_tower_same) style="color: red" @endif>{{$telecomBill->fee_tower}}</td>
                        <td @if(!$telecomBill->is_fee_house_same) style="color: red" @endif>{{$telecomBill->fee_house}}</td>
                        <td @if(!$telecomBill->is_fee_support_same) style="color: red" @endif>{{$telecomBill->fee_support}}</td>
                        <td @if(!$telecomBill->is_fee_maintain_same) style="color: red" @endif>{{$telecomBill->fee_maintain}}</td>
                        <td @if(!$telecomBill->is_fee_site_same) style="color: red" @endif>{{$telecomBill->fee_site}}</td>
                        <td @if(!$telecomBill->is_fee_import_same) style="color: red" @endif>{{$telecomBill->fee_import}}</td>
                        <td @if(!$telecomBill->is_fee_total_same) style="color: red" @endif>{{$telecomBill->fee_total_allincharge}}</td>
                    </tr>
                    @foreach($ironTowerBills as $ironTowerBill)
                        @if($ironTowerBill->month == $telecomBill->month && $ironTowerBill->region_id == $telecomBill->region_id)
                            <tr>
                                <td>铁塔</td>
                                <td @if(!$telecomBill->is_fee_tower_same) style="color: red" @endif>{{$ironTowerBill->fee_tower}}</td>
                                <td @if(!$telecomBill->is_fee_house_same) style="color: red" @endif>{{$ironTowerBill->fee_house}}</td>
                                <td @if(!$telecomBill->is_fee_support_same) style="color: red" @endif>{{$ironTowerBill->fee_support}}</td>
                                <td @if(!$telecomBill->is_fee_maintain_same) style="color: red" @endif>{{$ironTowerBill->fee_maintain}}</td>
                                <td @if(!$telecomBill->is_fee_site_same) style="color: red" @endif>{{$ironTowerBill->fee_site}}</td>
                                <td @if(!$telecomBill->is_fee_import_same) style="color: red" @endif>{{$ironTowerBill->fee_import}}</td>
                                <td @if(!$telecomBill->is_fee_total_same) style="color: red" @endif>{{$ironTowerBill->fee_total}}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach

            @endif




            {{--@if($dayRange != '所有')--}}
            {{--<tr>--}}
            {{--<td></td>--}}
            {{--<td>{{$dayRange}}未入账</td>--}}
            {{--<td>--}}
            {{--{{($fee_free->gnr_sum)}}--}}
            {{--@if($fee_free->gnr_count = 0)--}}
            {{--<a href="javascript:viewFreeGnrs()">明细</a>--}}
            {{--@endif--}}
            {{--</td>--}}
            {{--<td>--}}
            {{--无--}}
            {{--</td>--}}
            {{--<td id="toGenBill">--}}
            {{--无--}}
            {{--</td>--}}
            {{--<td>--}}
            {{--@if($fee_free->gnr_count = 0)--}}
            {{--<button class="buttonNextStep" onclick="createFeeOut()">生成账单</button>--}}
            {{--@endif--}}
            {{--</td>--}}
            {{--</tr>--}}
            {{--@endif--}}
            {{--<tr>--}}
            {{--<td></td>--}}
            {{--<td>累计未入账</td>--}}
            {{--<td>--}}
            {{--金额：{{($fee_free_all->gnr_sum)}}；记录数：{{$fee_free_all->gnr_count}}--}}
            {{--@if($fee_free->gnr_sum != 0)--}}
            {{--<a href="javascript:viewFreeGnrs()">明细</a>--}}
            {{--@endif--}}
            {{--</td>--}}
            {{--<td>--}}
            {{--无--}}
            {{--</td>--}}
            {{--<td id="toGenBill">--}}
            {{--无--}}
            {{--</td>--}}
            {{--<td>--}}
            {{--</td>--}}
            {{--</tr>--}}

        </table>


    </div>
@endsection

@section('script_footer')
    <script type="text/javascript" src="{{ URL::asset('common/datePicker/WdatePicker.js')}}"></script>
    <script type="text/javascript">
        $().ready(function () {
            $('#menu_bill').addClass("current");

        });

        function doCheck() {
            var form = document.getElementById('listForm');
            form.action = "{{url('backend/servBill/billCheck')}}";
            form.submit();
        }

        function viewBillSites(id) {
            var form = document.getElementById('listForm');
            var url = "{{url('backend/servBill/billCheck/orders')}}" + '/' + id;
            form.action = url;
            form.submit();

        }
    </script>
@endsection