@extends('layouts.app')

@section('header')
    <title>已出服务账单列表</title>
@endsection

@section('script_header')

@endsection


@section('content')
    <div class="container" style="width:100% ">
        <div class="row clearfix">
            <div class="col-md-12 column" style="padding: 0">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="{{url('backend/servBill')}}">账单管理</a>
                    </li>
                </ul>
                <ul class="breadcrumb" style="margin-bottom: 0;background-color: #F5F5F5">
                    当前位置：
                    <li>
                        <a href="{{url('backend/servBill')}}">账单管理</a>
                    </li>
                    <li class="active">
                        <a href="#">账单查询</a>
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
                    <label>选择起止月份和区县来查看地区月账单：</label>
                    <table>
                        <tr>
                            <td>
                                统计起始时间:
                                <input type="text" id="beginDate" name="beginDate" style="width:130px;padding-left:5px"
                                       readonly="true"
                                       @if(isset($filter['beginDate'])) value="{{$filter['beginDate']}}" @endif
                                       onclick="WdatePicker({dateFmt:'yyyy-MM'})"/>
                                ~
                                统计结束时间:
                                <input type="text" id="endDate" name="endDate" style="width:130px;padding-left:5px"
                                       readonly="true"
                                       @if(isset($filter['endDate'])) value="{{$filter['endDate']}}" @endif
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
                                &nbsp;&nbsp;&nbsp;&nbsp;出账：
                                <input type="radio" name="out_status" value="0"/>未出账
                                <input type="radio" name="out_status" value="1" checked="checked"/>已出账
                            </td>
                            <td>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="button" id="searchBtn" class="formButton" value="搜 索"
                                       onclick="doSearch()"/>
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>

        <table class="listTable" style="white-space:nowrap;" id="servBill">
            <tr>
                <th>
                    <a href="#" class="sort" hidefocus>地市</a>

                </th>
                <th>
                    <a href="#" class="sort" hidefocus>月份</a>

                </th>
                <th>
                    <a href="#" class="sort" hidefocus>标准站址月服务费（元）（不含税）</a>
                </th>
                <th>
                    <a href="#" class="sort" hidefocus>标准站址月服务费（元）（含税）</a>
                </th>
                <th>
                    <a href="#" class="sort" hidefocus>油机发电费（包干发电）（元）（不含税）</a>
                </th>
                <th>
                    <a href="#" class="sort" hidefocus>油机发电费（包干发电）（元）（含税）</a>
                </th>
                <th>
                    <a href="#" class="sort" hidefocus>油机发电费（按次发电）（元）（不含税）</a>
                </th>
                <th>
                    <a href="#" class="sort" hidefocus>油机发电费（按次发电）（元）（含税）</a>
                </th>
                <th>
                    <a href="#" class="sort" hidefocus>集团指标扣费（元）（不含税）</a>
                </th>
                <th>
                    <a href="#" class="sort" hidefocus>集团指标扣费（元）（含税）</a>
                </th>
                <th>
                    <a href="#" class="sort" hidefocus>省内指标扣费（元）（不含税）</a>
                </th>
                <th>
                    <a href="#" class="sort" hidefocus>省内指标扣费（元）（含税）</a>
                </th>
                <th>
                    <a href="#" class="sort" hidefocus>月度产品服务费（元）（包干发电）（不含税）</a>
                </th>
                <th>
                    <a href="#" class="sort" hidefocus>月度产品服务费（元）（包干发电）（含税）</a>
                </th>
                <th>
                    <a href="#" class="sort" hidefocus>月度产品服务费（元）（逐次发电）（不含税）</a>
                </th>
                <th>
                    <a href="#" class="sort" hidefocus>月度产品服务费（元）（逐次发电）（含税）</a>
                </th>
                <th>
                    <a href="" class="sort">出账状态</a>
                </th>

            </tr>
            @foreach($feeouts as $feeout)
                <tr>
                    <td>{{transRegion($feeout->region_id)}}</td>
                    <td>{{$feeout->month}}</td>
                    <td>{{$feeout->fee_service - $feeout->fee_gnr_allincharge}}
                        @if(($feeout->fee_service - $feeout->fee_gnr_allincharge) != 0)
                            <a href="javascript:viewBillSites('{{$feeout->id}}')">明细</a>
                        @endif
                    </td>
                    <td>
                        {{($feeout->fee_service - $feeout->fee_gnr_allincharge) * 1.06}}
                    </td>
                    <td>
                        {{$feeout->fee_gnr_allincharge}}
                    </td>
                    <td>
                        {{$feeout->fee_gnr_allincharge * 1.06}}
                    </td>
                    <td>
                        {{($feeout->fee_gnr)}}
                        @if($feeout->fee_gnr != 0)
                            <a href="javascript:viewBillGnrs('{{$feeout->id}}')">明细</a>
                        @endif
                    </td>
                    <td>
                        {{$feeout->fee_gnr * 1.06}}
                    </td>
                    <td>{{$feeout->deduction_1}}
                        @if($feeout->deduction_1 != 0)
                            <a href="javascript:viewBillDed1('{{$feeout->id}}')">明细</a>
                        @endif
                    </td>
                    <td>
                        {{$feeout->deduction_1 * 1.06}}
                    </td>
                    <td>{{$feeout->deduction_2}}
                        @if($feeout->deduction_2 != 0)
                            <a href="javascript:viewBillDed2('{{$feeout->id}}')">明细</a>
                        @endif</td>
                    <td>{{$feeout->deduction_2 * 1.06}}</td>
                    <td>{{$feeout->fee_total_allincharge}}</td>
                    <td>{{$feeout->fee_total_allincharge * 1.06}}</td>
                    <td>{{$feeout->fee_total_succ}}</td>
                    <td>{{$feeout->fee_total_succ * 1.06}}</td>
                    <td id="toGenBill">
                        {{transFeeOutStatus($feeout->is_out)}}
                    </td>

                </tr>
            @endforeach
        </table>
    </div>
@endsection

@section('script_footer')
    <script type="text/javascript" src="{{ URL::asset('common/datePicker/WdatePicker.js')}}"></script>
    <script type="text/javascript">
        $().ready(function () {

            $('#menu_bill').addClass("current");
        });

        function doSearch() {
            var region = $('#region').val();
            if (region == '') {
                alert('请选择所在区域');
                return;
            }
            var form = $('#listForm');
            form.submit();
        }

        function viewBillGnrs(id) {
            location.href = '{{URL('backend/servBill/billGnr')}}' + '?out_id=' + id;
        }

        function viewBillSites(id) {
            location.href = '{{URL('backend/servBill/site')}}' + '?out_id=' + id;
        }

        function viewBillDed1(id) {
            location.href = '{{URL('backend/servBill/deduction1')}}' + '?out_id=' + id;
        }
        function viewBillDed2(id) {
            location.href = '{{URL('backend/servBill/deduction2')}}' + '?out_id=' + id;
        }

    </script>
@endsection