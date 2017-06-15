@extends('layouts.app')

@section('header')
    <title>发电记录填报</title>
@endsection


@section('script_header')
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function (event) {
            var addBtn = document.getElementById("addBtn");
            addBtn.addEventListener('click', function () {
                var listForm = document.getElementById("listForm");
                listForm.action = "{{url('backend/gnrRec/addPage')}}";
            });
        });

    </script>
@endsection
@section('content')
    <div class="container" style="width:100% ">
        <div class="row clearfix">
            <div class="col-md-12 column" style="padding: 0">
                <ul class="nav nav-tabs" style="font-size: 13px">
                    <li class="inactive">
                        <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">站址信息管理</a>
                    </li>
                    <li class="active">
                        <a href="{{url('backend/gnrRec?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">发电记录管理</a>
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">上站记录管理</a>
                    </li>
                    <li class="inactive">
                        @if(Auth::user()->area_level == '湖北省')                             <a
                                href="{{url('backend/siteShield/checkShieldPage?region=').Auth::user()->area_level.'&checkStatus=2&reqType=0&beginDate=&endDate='}}">屏蔽记录管理</a>@endif                         @if(Auth::user()->area_level != '湖北省')
                            <a href="{{url('backend/siteShield/addShieldPage')}}">屏蔽记录管理</a>@endif
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/osReasonFill?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">退服原因管理</a>
                    </li>
                </ul>
                <ul class="nav-tabs-2">
                    <li class="active">
                        <a href="{{url('backend/gnrRec?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">发电记录查询</a>
                    </li>
                    <li class="inactive" style="float: none">
                        <a href="{{url('backend/gnrRec/addPage')}}">发电记录新增</a>
                    </li>

                </ul>
                <ul class="breadcrumb" style="margin-bottom: 0;background-color: #F5F5F5">
                    当前位置：
                    <li>
                        <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">业务管理</a>
                    </li>
                    <li>
                        <a href="{{url('backend/gnrRec?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">发电记录管理</a>
                    </li>
                    <li class="active">
                        <a href="#">发电记录查询</a>
                    </li>
                </ul>


            </div>
        </div>

    </div>

    <div class="list">
        <form id="listForm" method="post" action="{{url('backend/gnrRec/')}}" enctype="multipart/form-data">
            <div class="body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="siteID" @if(isset($siteInfos)) value="{{$siteInfos[0]->id}}"@endif>
                <input type="hidden" name="siteChoose"
                       @if(isset($filter['siteChoose'])) value="{{$filter['siteChoose']}}" @endif>
                <input type="hidden" name="lastGnrTime"
                       @if(!empty($siteInfos[0]->last_gnr_time)) value="{{$siteInfos[0]->last_gnr_time}}" @endif>
                <input type="hidden" name="siteAddress"
                       @if(!empty($siteInfos[0]->site_address)) value="{{$siteInfos[0]->site_address}}" @endif>
                <input type="hidden" name="region_export"
                       @if(!empty($siteInfos[0]->region_name)) value="{{$siteInfos[0]->region_name}}" @endif>
                <input type="hidden" name="siteCode_export"
                       @if(!empty($siteInfos[0]->site_code)) value="{{$siteInfos[0]->site_code}}" @endif>

                <div class="listBar">
                    <label style="margin-bottom:10px">选择起止月份和地市来查发电记录：</label><br>

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
                        &nbsp;&nbsp;地市：
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
                        &nbsp;&nbsp;&nbsp;&nbsp;处理状态：
                        <input type="radio" name="checkStatus" value="0"/>未处理
                        <input type="radio" name="checkStatus" value="1" checked="checked"/>已处理
                    </td>
                    <td>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" id="searchBtn" class="formButton" value="搜 索"
                               onclick="doSearch()"/>
                    </td>
                    <td>
                        <input type="button" class="formButton" value="导 出" onclick="doExport()"
                               @if(!empty($gnrRecs)) style="display: inline;" @endif style="display: none;"/>
                    </td>

                </div>
            </div>


            <div>
                <table class="listTable" style="white-space:nowrap;font-size: 12px;">
                    <tr>
                        <th>
                            <a href="#" class="sort">地市</a>
                        </th>
                        <th>
                            <a href="#" class="sort">站址编码</a>
                        </th>
                        <th>
                            <a href="#" class="sort">发电申请时间</a>
                        </th>
                        <th>
                            <a href="#" class="sort">发电申请发起方</a>
                        </th>
                        <th>
                            <a href="#" class="sort">发电结果</a>
                        </th>
                        <th>
                            <a href="#" class="sort">发电有效状态</a>
                        </th>
                        <th>
                            <a href="#" class="sort">发电开始时间</a>
                        </th>
                        <th>
                            <a href="#" class="sort">发电结束时间</a>
                        </th>
                        <th>
                            <a href="#" class="sort">发电时长（时：分）</a>
                        </th>
                        <th>
                            <a href="#" class="sort">发电费用（元）</a>
                        </th>


                    </tr>
                    @if(isset($gnrRecs))
                        @foreach($gnrRecs as $gnrRec)

                            <tr>
                                <td>{{transRegion($gnrRec->region_id)}}</td>
                                <td>{{$gnrRec->site_code}}</td>
                                <td>{{$gnrRec->gnr_req_time}}</td>
                                <td>{{transGnrRaiseSide($gnrRec->gnr_raise_side)}}</td>
                                <td>{{transGnrResult($gnrRec->gnr_result)}}</td>
                                <td>{{transGnrStatus($gnrRec->gnr_status)}}</td>
                                <td>{{$gnrRec->gnr_start_time}}</td>
                                <td>{{$gnrRec->gnr_stop_time}}</td>
                                <td>{{$gnrRec->gnr_len}}</td>
                                <td>{{$gnrRec->gnr_fee}}</td>
                            </tr>
                        @endforeach
                        @if(isset($filter))
                            {!! $gnrRecs
                            ->appends(['region' => $filter['region'],
                            'beginDate' => $filter['beginDate'],
                            'endDate' => $filter['endDate'],
                            'checkStatus' => $filter['checkStatus']])
                            ->links() !!}@endif
                    @endif

                </table>
            </div>
        </form>
    </div>
@endsection

@section('script_footer')
    <script type="text/javascript" src="{{ URL::asset('common/datePicker/WdatePicker.js')}}"></script>
    <script type="text/javascript">
        $().ready(function () {
            var menu_business = document.getElementById('menu_business');
            menu_business.className = "current";
        });

        function doSearch() {
            var listForm = document.getElementById("listForm");
            var region = document.getElementById('region');
            var beginDate = document.getElementById('beginDate');
            var endDate = document.getElementById('endDate');
            var checkStatus = $('input[name="checkStatus"]:checked').val();
            var url = "{{url('backend/gnrRec?region=')}}" + region + '&beginDate=' + beginDate + '&endDate=' + endDate + '&checkStatus=' + checkStatus;
            listForm.method = "GET";
            listForm.action = url;
            listForm.submit();
        }

        function doSearchSites() {
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/gnrRec')}}";
            listForm.submit();
        }

        function doSearchGnrs() {
            var listForm = document.getElementById("listForm");
            var url = "{{url('backend/gnrRec/indexGnr')}}";
            listForm.action = url;
            listForm.submit();
        }

        function doConfirm() {
            var region = $('#region').val();
            if (region == '请选择...') {
                alert('请选择所在区域');
                return;
            }
            else {
                var siteChoose = document.getElementsByName('siteChoose');
                if (siteChoose.length == 0) {
                    alert('请先查询站址！');
                    return;
                }
                else {
                    for (var i = 0; i < siteChoose.length; i++) {
                        if (siteChoose[i].checked == true) {
                            var listForm = document.getElementById("listForm");
                            listForm.action = "{{url('backend/gnrRec/indexGnr')}}";
                            listForm.submit();
                            return;
                        }
                    }
                    if (siteChoose[siteChoose.length - 1].checked == false) {
                        alert('请先选择站址！')
                    }

                }

            }

        }

        function doChoose() {
            var confirmBtn = document.getElementById('confirmBtn');
            confirmBtn.style.display = "inline";
        }

        function doExport() {
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/gnrRec/export')}}";
            listForm.submit();
        }


        function doHandlePage(id) {
            var listForm = document.getElementById("listForm");
            var url = "{{url('backend/gnrRec/handlePage')}}" + '/' + id;
            listForm.action = url;
            listForm.submit();
        }

        function doAddPage() {
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/gnrRec/addPage')}}";
            listForm.submit();
        }


    </script>
@endsection
