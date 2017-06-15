@extends('layouts.app')

@section('header')
    <title>编辑站址信息</title>
@endsection

@section('content')
    <div class="container" style="width:100% ">
        <div class="row clearfix">
            <div class="col-md-12 column" style="padding: 0">
                {{--<div class="collapse navbar-collapse" id="example-navbar-collapse" style="padding: 0">--}}
                <ul class="nav nav-tabs" style="font-size: 13px">
                    <li class="active">
                        <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">站址信息管理</a>
                    </li>
                    <li class="inactive">
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
                    {{--<li class="dropdown inactiive">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                    {{--扣费记录填报 <b class="caret"></b>--}}
                    {{--</a>--}}
                    {{--<ul class="dropdown-menu" style="font-size: 12px;">--}}


                    {{--</ul>--}}
                    {{--</li>--}}
                </ul>
                {{--</div>--}}
                <ul class="nav-tabs-2">
                    <li class="active">
                        <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">站址信息查询</a>
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/siteInfo/addNewPage')}}">站址信息新增</a>
                    </li>
                    <li class="inactive" style="float: none">
                        <a href="{{url('backend/excepHandle/importSiteInfo')}}">导入异常处理</a>
                    </li>
                    {{--<li class="dropdown inactiive">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                    {{--扣费记录填报 <b class="caret"></b>--}}
                    {{--</a>--}}
                    {{--<ul class="dropdown-menu" style="font-size: 12px;">--}}


                    {{--</ul>--}}
                    {{--</li>--}}
                </ul>
                <ul class="breadcrumb" style="margin-bottom: 0;background-color: #F5F5F5">
                    当前位置：
                    <li>
                        <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">业务管理</a>
                    </li>
                    <li>
                        <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">站址信息管理</a>
                    </li>
                    <li class="active">
                        <a href="#">站址信息修改</a>
                    </li>
                </ul>


            </div>
        </div>

    </div>

    {{--<body class="input managerInfo" onload="doLoad({{$siteInfo->sys_num}})">--}}
    <body class="input managerInfo">
    <div class="bar">
        <div style="float:left;">
            请修改或者删除站址信息
        </div>

    </div>
    <div id="validateErrorContainer" class="validateErrorContainer">

    </div>

    <form id="listForm" method="POST" action="{{url('backend/siteInfo/update')}}" style="display: inline;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{$siteInfo->id}}"/>
        <input name="region" type="hidden" value="{{$filter['region']}}">
        <input type="hidden" name="isNewTower" value="{{$siteInfo->is_new_tower}}">
        <input type="hidden" name="siteCode" value="{{$siteInfo->site_code}}">
        <table class="inputTable tabContent">
            <tr>
                <th>
                    产品业务确认单编号 :
                </th>
                <td>

                    <input type="text" @if(isset($siteInfo->business_code)) value="{{$siteInfo->business_code}}"
                           @endif id="businessCode" name="businessCode" readonly>
                </td>
            </tr>
            <tr>
                <th>
                    需求确认单编号 :
                </th>
                <td>

                    <input type="text" @if(isset($siteInfo->req_code)) value="{{$siteInfo->req_code}}"
                           @endif id="reqCode" name="reqCode" readonly>
                </td>
            </tr>
            <tr>
                <th>
                    站址编码 :
                </th>
                <td>

                    <input type="text" @if(isset($siteInfo->site_code)) value="{{$siteInfo->site_code}}"
                           @endif id="siteCode" name="siteCode" readonly>
                </td>
            </tr>
            <tr>
                <th>
                    站址名称 :
                </th>
                <td>

                    <input type="text" @if(isset($siteInfo->site_name)) value="{{$siteInfo->site_name}}"
                           @endif id="siteName" name="siteName" readonly>
                </td>
            </tr>
            <tr>
                <th>
                    地市 :
                </th>
                <td>

                    <input type="text"
                           @if(isset($siteInfo->region_name)) value="{{$siteInfo->region_name}}" @endif id="region"
                           name="regionName"
                           readonly>
                </td>
            </tr>
            <tr>
                <th>
                    区县 :
                </th>
                <td>

                    <input type="text"
                           @if(isset($siteInfo->city_name)) value="{{$siteInfo->city_name}}" @endif id="cityName"
                           name="cityName"
                           readonly>
                </td>
            </tr>
            <tr>
                <th>
                    是否为新建站 :
                </th>

                <td>
                    <input type="radio" id="isNewTower" name="isNewTower" value="是"
                           @if(isset($siteInfo->is_new_tower) && transIsNewTower($siteInfo->is_new_tower) == '是') checked="checked"
                           @endif disabled>是
                    <input type="radio" id="isNewTower" name="isNewTower" value="否"
                           @if(isset($siteInfo->is_new_tower) && transIsNewTower($siteInfo->is_new_tower) == '否') checked="checked"
                           @endif disabled>否

                </td>
            </tr>
            <tr>
                <th>站址属性变更日期</th>
                <td>
                    <input type="text" id="effectiveDate" name="effectiveDate" style="width:65px;padding-left:5px"
                           readonly="true" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})"/>
                </td>
            </tr>
            <tr>
                <th>
                    是否为竞合站点 :
                </th>

                <td>
                    <input type="radio" name="isCoOpetition" id="isCoOpetition" value="是"
                           @if(isset($siteInfo->is_co_opetition) && transIsCoOpetition($siteInfo->is_co_opetition) == '是') checked="checked" @endif>是
                    <input type="radio" name="isCoOpetition" id="isCoOpetition" value="否"
                           @if(isset($siteInfo->is_co_opetition) && transIsCoOpetition($siteInfo->is_co_opetition) == '否') checked="checked" @endif>否

                </td>
            </tr>
            @if(transIsNewTower($siteInfo->is_new_tower) == '是')
                <tr>
                    <th>
                        站址所在地区类型:
                    </th>
                    <td>
                        <input type="radio" name="siteDistType" id="siteDistType" value="市区"
                               @if(isset($siteInfo->site_district_type) && transSiteDistType($siteInfo->site_district_type) =="市区") checked="checked"@endif>市区
                        <input type="radio" name="siteDistType" id="siteDistType" value="城镇"
                               @if(isset($siteInfo->site_district_type) && transSiteDistType($siteInfo->site_district_type)=="城镇") checked="checked"@endif>城镇
                        <input type="radio" name="siteDistType" id="siteDistType" value="农村"
                               @if(isset($siteInfo->site_district_type) && transSiteDistType($siteInfo->site_district_type)=="农村") checked="checked"@endif>农村


                    </td>
                </tr>
                <tr>
                    <th>
                        是否RRU拉远:
                    </th>
                    <td>
                        <input type="radio" name="rruAway" id="rruAway" value="是"
                               @if(isset($siteInfo->is_rru_away) && transIsRRUAway($siteInfo->is_rru_away) =="是") checked="checked"@endif>是
                        <input type="radio" name="rruAway" id="rruAway" value="否"
                               @if(isset($siteInfo->is_rru_away) && transIsRRUAway($siteInfo->is_rru_away)=="否")checked="checked"@endif>否


                    </td>
                </tr>
                <tr>
                    <th>
                        引电类型(V):
                    </th>
                    <td>
                        <input type="radio" name="elecIntroType" id="elecIntroType" value="380V"
                               @if(isset($siteInfo->elec_introduced_type) && transElecType($siteInfo->elec_introduced_type) =="380V") checked="checked" @endif>380V
                        <input type="radio" name="elecIntroType" id="elecIntroType" value="220V"
                               @if(isset($siteInfo->elec_introduced_type) && transElecType($siteInfo->elec_introduced_type)=="220V") checked="checked" @endif>220V
                    </td>
                </tr>
            @endif
            <tr>
                <th>
                    产品配套类型 :
                </th>

                <td>
                    <input type="radio" name="productType" id="productType" value="铁塔+自有机房+配套"
                           @if(isset($siteInfo->product_type) && transProductType($siteInfo->product_type) == '铁塔+自有机房+配套') checked="checked"@endif>铁塔+自有机房+配套
                    <input type="radio" name="productType" id="productType" value="铁塔+租赁机房+配套"
                           @if(isset($siteInfo->product_type) && transProductType($siteInfo->product_type) == '铁塔+租赁机房+配套')checked="checked"@endif>铁塔+租赁机房+配套
                    <input type="radio" name="productType" id="productType" value="铁塔+一体化机柜+配套"
                           @if(isset($siteInfo->product_type) && transProductType($siteInfo->product_type) == '铁塔+一体化机柜+配套') checked="checked"@endif>铁塔+一体化机柜+配套
                    <input type="radio" name="productType" id="productType" value="铁塔+RRU拉远+配套"
                           @if(isset($siteInfo->product_type) && transProductType($siteInfo->product_type) == '铁塔+RRU拉远+配套') checked="checked"@endif>铁塔+RRU拉远+配套
                    <input type="radio" name="productType" id="productType" value="铁塔(无机房及配套)"
                           @if(isset($siteInfo->product_type) && transProductType($siteInfo->product_type) == '铁塔(无机房及配套)') checked="checked"@endif>铁塔(无机房及配套)

                </td>
            </tr>
            <tr>
                <th>
                    铁塔类型:
                </th>
                <td>
                    <input type="radio" name="towerType" id="towerType" value="普通地面塔"
                           @if(isset($siteInfo->tower_type) && transTowerType($siteInfo->tower_type) =="普通地面塔") checked="checked"
                           @endif
                           onclick="towerTypeChange(this)">普通地面塔
                    <input type="radio" name="towerType" id="towerType" value="景观塔"
                           @if(isset($siteInfo->tower_type) && transTowerType($siteInfo->tower_type)=="景观塔") checked="checked"
                           @endif
                           onclick="towerTypeChange(this)">景观塔
                    <input type="radio" name="towerType" id="towerType" value="简易塔"
                           @if(isset($siteInfo->tower_type) && transTowerType($siteInfo->tower_type)=="简易塔") checked="checked"
                           @endif
                           onclick="towerTypeChange(this)">简易塔
                    <input type="radio" name="towerType" id="towerType" value="普通楼面塔"
                           @if(isset($siteInfo->tower_type) && transTowerType($siteInfo->tower_type)=="普通楼面塔") checked="checked"
                           @endif
                           onclick="towerTypeChange(this)">普通楼面塔
                    <input type="radio" name="towerType" id="towerType" value="楼面抱杆"
                           @if(isset($siteInfo->tower_type) && transTowerType($siteInfo->tower_type)=="楼面抱杆") checked="checked"
                           @endif
                           onclick="towerTypeChange(this)">楼面抱杆


                </td>
            </tr>
            <tr>
                <th>系统数量1</th>
                <td>
                    <input type="radio" name="sysNum1" id="sysNum1" value="0"
                           @if(isset($siteInfo->sys_num1) && $siteInfo->sys_num1=="0") checked="checked"@endif>0
                    <input type="radio" name="sysNum1" id="sysNum1" value="1"
                           @if(isset($siteInfo->sys_num1) && $siteInfo->sys_num1=="1") checked="checked"@endif>1
                    <input type="radio" name="sysNum1" id="sysNum1" value="0.1"
                           @if(isset($siteInfo->sys_num1) && $siteInfo->sys_num1=="0.1") checked="checked"@endif>0.1
                    <input type="radio" name="sysNum1" id="sysNum1" value="0.2"
                           @if(isset($siteInfo->sys_num1) && $siteInfo->sys_num1=="0.2") checked="checked"
                            @endif>0.2
                    <input type="radio" name="sysNum1" id="sysNum1" value="0.3"
                           @if(isset($siteInfo->sys_num1) && $siteInfo->sys_num1=="0.3") checked="checked"
                            @endif>0.3
                    <input type="radio" name="sysNum1" id="sysNum1" value="0.4"
                           @if(isset($siteInfo->sys_num1) && $siteInfo->sys_num1=="0.4") checked="checked"
                            @endif>0.4
                    <input type="radio" name="sysNum1" id="sysNum1" value="0.6"
                           @if(isset($siteInfo->sys_num1) && $siteInfo->sys_num1=="0.6") checked="checked"
                            @endif>0.6
                    <input type="radio" name="sysNum1" id="sysNum1" value="0.9"
                           @if(isset($siteInfo->sys_num1) && $siteInfo->sys_num1=="0.9") checked="checked"
                            @endif>0.9
                    <input type="radio" name="sysNum1" id="sysNum1" value="1.1"
                           @if(isset($siteInfo->sys_num1) && $siteInfo->sys_num1=="1.1") checked="checked"
                            @endif>1.1
                    <input type="radio" name="sysNum1" id="sysNum1" value="1.3"
                           @if(isset($siteInfo->sys_num1) && $siteInfo->sys_num1=="1.3") checked="checked"
                            @endif>1.3

                </td>
            </tr>
            <tr>
                <th>
                    系统1挂高(m):
                </th>
                <td>
                    <input type="radio" name="sysHeight1" value="无"
                           @if($siteInfo->sys1_height == null) checked="checked"@endif>无
                    <input type="radio" name="sysHeight1" value="H<20"
                           @if(transSysHeight($siteInfo->sys1_height) == 'H<20') checked="checked"@endif>H<20
                    <input type="radio" name="sysHeight1" id="h2" value="20<=H<25"
                           @if(transSysHeight($siteInfo->sys1_height) == '20<=H<25') checked="checked"@endif>20<=H<25
                    <input type="radio" name="sysHeight1" value="25<=H<30"
                           @if(transSysHeight($siteInfo->sys1_height) == '25<=H<30') checked="checked"@endif>25<=H<30
                    <input type="radio" name="sysHeight1" value="H<30"
                           @if(transSysHeight($siteInfo->sys1_height) == 'H<30') checked="checked"@endif>H<30
                    <input type="radio" name="sysHeight1" value="30<=H<35"
                           @if(transSysHeight($siteInfo->sys1_height) == '30<=H<35') checked="checked"@endif>30<=H<35
                    <input type="radio" name="sysHeight1" value="35<=H<40"
                           @if(transSysHeight($siteInfo->sys1_height) == '35<=H<40') checked="checked"@endif>35<=H<40
                    <input type="radio" name="sysHeight1" value="40<=H<45"
                           @if(transSysHeight($siteInfo->sys1_height) == '40<=H<45') checked="checked"@endif>40<=H<45
                    <input type="radio" name="sysHeight1" value="45<=H<50"
                           @if(transSysHeight($siteInfo->sys1_height) == '45<=H<50') checked="checked"@endif>45<=H<50
                    <input type="radio" name="sysHeight1" value="任意高度"
                           @if(transSysHeight($siteInfo->sys1_height) == '任意高度') checked="checked"@endif>任意高度
                </td>
            </tr>
            <tr>
                <th>系统数量2</th>
                <td>
                    <input type="radio" name="sysNum2" id="sysNum2" value="0"
                           @if(isset($siteInfo->sys_num2) && $siteInfo->sys_num2=="0") checked="checked"@endif>0
                    <input type="radio" name="sysNum2" id="sysNum2" value="1"
                           @if(isset($siteInfo->sys_num2) && $siteInfo->sys_num2=="1") checked="checked"@endif>1
                    <input type="radio" name="sysNum2" id="sysNum2" value="0.1"
                           @if(isset($siteInfo->sys_num2) && $siteInfo->sys_num2=="0.1") checked="checked"@endif>0.1
                    <input type="radio" name="sysNum2" id="sysNum2" value="0.2"
                           @if(isset($siteInfo->sys_num2) && $siteInfo->sys_num2=="0.2") checked="checked"
                            @endif>0.2
                    <input type="radio" name="sysNum2" id="sysNum2" value="0.3"
                           @if(isset($siteInfo->sys_num2) && $siteInfo->sys_num2=="0.3") checked="checked"
                            @endif>0.3
                    <input type="radio" name="sysNum2" id="sysNum2" value="0.4"
                           @if(isset($siteInfo->sys_num2) && $siteInfo->sys_num2=="0.4") checked="checked"
                            @endif>0.4
                    <input type="radio" name="sysNum2" id="sysNum2" value="0.6"
                           @if(isset($siteInfo->sys_num2) && $siteInfo->sys_num2=="0.6") checked="checked"
                            @endif>0.6
                    <input type="radio" name="sysNum2" id="sysNum2" value="0.9"
                           @if(isset($siteInfo->sys_num2) && $siteInfo->sys_num2=="0.9") checked="checked"
                            @endif>0.9
                    <input type="radio" name="sysNum2" id="sysNum2" value="1.1"
                           @if(isset($siteInfo->sys_num2) && $siteInfo->sys_num2=="1.1") checked="checked"
                            @endif>1.1
                    <input type="radio" name="sysNum2" id="sysNum2" value="1.3"
                           @if(isset($siteInfo->sys_num2) && $siteInfo->sys_num2=="1.3") checked="checked"
                            @endif>1.3

                </td>
            </tr>
            <tr>
                <th>
                    系统2挂高(m):
                </th>
                <td>
                    <input type="radio" name="sysHeight2" value="无"
                           @if($siteInfo->sys2_height == null) checked="checked"@endif>无
                    <input type="radio" name="sysHeight2" value="H<20"
                           @if(transSysHeight($siteInfo->sys2_height) == 'H<20') checked="checked"@endif>H<20
                    <input type="radio" name="sysHeight2" id="h2" value="20<=H<25"
                           @if(transSysHeight($siteInfo->sys2_height) == '20<=H<25') checked="checked"@endif>20<=H<25
                    <input type="radio" name="sysHeight2" value="25<=H<30"
                           @if(transSysHeight($siteInfo->sys2_height) == '25<=H<30') checked="checked"@endif>25<=H<30
                    <input type="radio" name="sysHeight2" value="H<30"
                           @if(transSysHeight($siteInfo->sys2_height) == 'H<30') checked="checked"@endif>H<30
                    <input type="radio" name="sysHeight2" value="30<=H<35"
                           @if(transSysHeight($siteInfo->sys2_height) == '30<=H<35') checked="checked"@endif>30<=H<35
                    <input type="radio" name="sysHeight2" value="35<=H<40"
                           @if(transSysHeight($siteInfo->sys2_height) == '35<=H<40') checked="checked"@endif>35<=H<40
                    <input type="radio" name="sysHeight2" value="40<=H<45"
                           @if(transSysHeight($siteInfo->sys2_height) == '40<=H<45') checked="checked"@endif>40<=H<45
                    <input type="radio" name="sysHeight2" value="45<=H<50"
                           @if(transSysHeight($siteInfo->sys2_height) == '45<=H<50') checked="checked"@endif>45<=H<50
                    <input type="radio" name="sysHeight2" value="任意高度"
                           @if(transSysHeight($siteInfo->sys2_height) == '任意高度') checked="checked"@endif>任意高度
                </td>
            </tr>
            <tr>
                <th>系统数量3</th>
                <td>
                    <input type="radio" name="sysNum3" id="sysNum3" value="0"
                           @if(isset($siteInfo->sys_num3) && $siteInfo->sys_num3=="0") checked="checked"@endif>0
                    <input type="radio" name="sysNum3" id="sysNum3" value="1"
                           @if(isset($siteInfo->sys_num3) && $siteInfo->sys_num3=="1") checked="checked"@endif>1
                    <input type="radio" name="sysNum3" id="sysNum3" value="0.1"
                           @if(isset($siteInfo->sys_num3) && $siteInfo->sys_num3=="0.1") checked="checked"@endif>0.1
                    <input type="radio" name="sysNum3" id="sysNum3" value="0.2"
                           @if(isset($siteInfo->sys_num3) && $siteInfo->sys_num3=="0.2") checked="checked"
                            @endif>0.2
                    <input type="radio" name="sysNum3" id="sysNum3" value="0.3"
                           @if(isset($siteInfo->sys_num3) && $siteInfo->sys_num3=="0.3") checked="checked"
                            @endif>0.3
                    <input type="radio" name="sysNum3" id="sysNum3" value="0.4"
                           @if(isset($siteInfo->sys_num3) && $siteInfo->sys_num3=="0.4") checked="checked"
                            @endif>0.4
                    <input type="radio" name="sysNum3" id="sysNum3" value="0.6"
                           @if(isset($siteInfo->sys_num3) && $siteInfo->sys_num3=="0.6") checked="checked"
                            @endif>0.6
                    <input type="radio" name="sysNum3" id="sysNum3" value="0.9"
                           @if(isset($siteInfo->sys_num3) && $siteInfo->sys_num3=="0.9") checked="checked"
                            @endif>0.9
                    <input type="radio" name="sysNum3" id="sysNum3" value="1.1"
                           @if(isset($siteInfo->sys_num3) && $siteInfo->sys_num3=="1.1") checked="checked"
                            @endif>1.1
                    <input type="radio" name="sysNum3" id="sysNum3" value="1.3"
                           @if(isset($siteInfo->sys_num3) && $siteInfo->sys_num3=="1.3") checked="checked"
                            @endif>1.3

                </td>
            </tr>
            <tr>
                <th>
                    系统3挂高(m):
                </th>
                <td>
                    <input type="radio" name="sysHeight3" value="无"
                           @if($siteInfo->sys3_height == null) checked="checked"@endif>无
                    <input type="radio" name="sysHeight3" value="H<20"
                           @if(transSysHeight($siteInfo->sys3_height) == 'H<20') checked="checked"@endif>H<20
                    <input type="radio" name="sysHeight3" id="h2" value="20<=H<25"
                           @if(transSysHeight($siteInfo->sys3_height) == '20<=H<25') checked="checked"@endif>20<=H<25
                    <input type="radio" name="sysHeight3" value="25<=H<30"
                           @if(transSysHeight($siteInfo->sys3_height) == '25<=H<30') checked="checked"@endif>25<=H<30
                    <input type="radio" name="sysHeight3" value="H<30"
                           @if(transSysHeight($siteInfo->sys3_height) == 'H<30') checked="checked"@endif>H<30
                    <input type="radio" name="sysHeight3" value="30<=H<35"
                           @if(transSysHeight($siteInfo->sys3_height) == '30<=H<35') checked="checked"@endif>30<=H<35
                    <input type="radio" name="sysHeight3" value="35<=H<40"
                           @if(transSysHeight($siteInfo->sys3_height) == '35<=H<40') checked="checked"@endif>35<=H<40
                    <input type="radio" name="sysHeight3" value="40<=H<45"
                           @if(transSysHeight($siteInfo->sys3_height) == '40<=H<45') checked="checked"@endif>40<=H<45
                    <input type="radio" name="sysHeight3" value="45<=H<50"
                           @if(transSysHeight($siteInfo->sys3_height) == '45<=H<50') checked="checked"@endif>45<=H<50
                    <input type="radio" name="sysHeight3" value="任意高度"
                           @if(transSysHeight($siteInfo->sys3_height) == '任意高度') checked="checked"@endif>任意高度
                </td>
            </tr>

            <tr>
                <th>
                    覆盖场景:
                </th>
                <td>
                    <input type="radio" name="landForm" id="landForm" value="山区"
                           @if(isset($siteInfo->land_form) && transLandForm($siteInfo->land_form) =="山区") checked="checked"@endif>山区
                    <input type="radio" name="landForm" id="landForm" value="平原"
                           @if(isset($siteInfo->land_form) && transLandForm($siteInfo->land_form) =="平原") checked="checked"@endif>平原


                </td>
            </tr>
            <tr>
                <th>
                    用户类型:
                </th>
                <td>
                    @if(transIsNewTower($siteInfo->is_new_tower)  == '是')
                        <div id="userType1" style="float: left;"><input type="radio" name="userType" id="userType_old"
                                                                        value="锚定用户"
                                                                        @if(transUserType($siteInfo->user_type) =="锚定用户") checked="checked" @endif>锚定用户
                        </div>@endif
                    @if(transIsNewTower($siteInfo->is_new_tower) == '否')
                        <div id="userType2" style="float: left;"><input type="radio" name="userType" value="原产权"
                                                                        @if(transUserType($siteInfo->user_type)=="原产权") checked="checked"@endif>原产权
                        </div>@endif
                    @if(transIsNewTower($siteInfo->is_new_tower) == '是')
                        <div id="userType3" style="float: left;"><input type="radio" name="userType"
                                                                        id="userType_otheruser"
                                                                        value="其他用户"
                                                                        @if(transUserType($siteInfo->user_type)=="其他用户") checked="checked"@endif>其他用户
                        </div>@endif
                    @if(transIsNewTower($siteInfo->is_new_tower) == '否')
                        <div id="userType4" style="float: left;"><input type="radio" name="userType" value="既有共享"
                                                                        @if(transUserType($siteInfo->user_type)=="既有共享") checked="checked"@endif>既有共享
                        </div>@endif
                    @if(transIsNewTower($siteInfo->is_new_tower) == '否')
                        <div id="userType5" style="float: left;"><input type="radio" name="userType" value="新增共享"
                                                                        @if(transUserType($siteInfo->user_type)=="新增共享") checked="checked"@endif>新增共享
                        </div>@endif


                </td>
            </tr>
            <tr>
                <th>
                    铁塔共享类型:
                </th>
                <td>

                    <input type="radio" name="shareNumTower" id="shareNumTower" value="电信独享"
                           @if(isset($siteInfo->share_num_tower) && transShareType($siteInfo->share_num_tower) =="电信独享")
                           checked="checked" @endif>电信独享
                    <input type="radio" name="shareNumTower" id="shareType" value="两家共享"
                           @if(isset($siteInfo->share_num_tower) && transShareType($siteInfo->share_num_tower)=="两家共享")
                           checked="checked" @endif>两家共享
                    <input type="radio" name="shareNumTower" id="shareType" value="三家共享"
                           @if(isset($siteInfo->share_num_tower) && transShareType($siteInfo->share_num_tower)=="三家共享") checked="checked"
                            @endif>三家共享
                </td>
            </tr>
            <tr>
                <th>
                    机房共享类型:
                </th>
                <td>

                    <input type="radio" name="shareNumHouse" id="shareType" value="电信独享"
                           @if(isset($siteInfo->share_num_house) && transShareType($siteInfo->share_num_house) =="电信独享")
                           checked="checked" @endif>电信独享
                    <input type="radio" name="shareNumHouse" id="shareType" value="两家共享"
                           @if(isset($siteInfo->share_num_house) && transShareType($siteInfo->share_num_house)=="两家共享")
                           checked="checked" @endif>两家共享
                    <input type="radio" name="shareNumHouse" id="shareType" value="三家共享"
                           @if(isset($siteInfo->share_num_house) && transShareType($siteInfo->share_num_house)=="三家共享") checked="checked"
                            @endif>三家共享
                </td>
            </tr>
            <tr>
                <th>
                    配套共享类型:
                </th>
                <td>

                    <input type="radio" name="shareNumSupport" id="shareType" value="电信独享"
                           @if(isset($siteInfo->share_num_support) && transShareType($siteInfo->share_num_support) =="电信独享")
                           checked="checked" @endif>电信独享
                    <input type="radio" name="shareNumSupport" id="shareType" value="两家共享"
                           @if(isset($siteInfo->share_num_support) && transShareType($siteInfo->share_num_support)=="两家共享")
                           checked="checked" @endif>两家共享
                    <input type="radio" name="shareNumSupport" id="shareType" value="三家共享"
                           @if(isset($siteInfo->share_num_support) && transShareType($siteInfo->share_num_support)=="三家共享") checked="checked"
                            @endif>三家共享
                </td>
            </tr>
            <tr>
                <th>
                    维护共享类型:
                </th>
                <td>

                    <input type="radio" name="shareNumMaintain" id="shareType" value="电信独享"
                           @if(isset($siteInfo->share_num_maintain) && transShareType($siteInfo->share_num_maintain) =="电信独享")
                           checked="checked" @endif>电信独享
                    <input type="radio" name="shareNumMaintain" id="shareType" value="两家共享"
                           @if(isset($siteInfo->share_num_maintain) && transShareType($siteInfo->share_num_maintain)=="两家共享")
                           checked="checked" @endif>两家共享
                    <input type="radio" name="shareNumMaintain" id="shareType" value="三家共享"
                           @if(isset($siteInfo->share_num_maintain) && transShareType($siteInfo->share_num_maintain)=="三家共享") checked="checked"
                            @endif>三家共享
                </td>
            </tr>
            <tr>
                <th>
                    场地费共享类型:
                </th>
                <td>

                    <input type="radio" name="shareNumSite" id="shareType" value="电信独享"
                           @if(isset($siteInfo->share_num_site) && transShareType($siteInfo->share_num_site) =="电信独享")
                           checked="checked" @endif>电信独享
                    <input type="radio" name="shareNumSite" id="shareType" value="两家共享"
                           @if(isset($siteInfo->share_num_site) && transShareType($siteInfo->share_num_site)=="两家共享")
                           checked="checked" @endif>两家共享
                    <input type="radio" name="shareNumSite" id="shareType" value="三家共享"
                           @if(isset($siteInfo->share_num_site) && transShareType($siteInfo->share_num_site)=="三家共享") checked="checked"
                            @endif>三家共享
                </td>
            </tr>
            <tr>
                <th>
                    电力引入费共享类型:
                </th>
                <td>

                    <input type="radio" name="shareNumImport" id="shareType" value="电信独享"
                           @if(isset($siteInfo->share_num_import) && transShareType($siteInfo->share_num_import) =="电信独享")
                           checked="checked" @endif>电信独享
                    <input type="radio" name="shareNumImport" id="shareType" value="两家共享"
                           @if(isset($siteInfo->share_num_import) && transShareType($siteInfo->share_num_import)=="两家共享")
                           checked="checked" @endif>两家共享
                    <input type="radio" name="shareNumImport" id="shareType" value="三家共享"
                           @if(isset($siteInfo->share_num_import) && transShareType($siteInfo->share_num_import)=="三家共享") checked="checked"
                            @endif>三家共享
                </td>
            </tr>


            @if(transIsNewTower($siteInfo->is_new_tower)  == '否')
                <tr>
                    <th>
                        是否存在新增共享:
                    </th>
                    <td>
                        <input type="radio" name="isNewlyAdded" id="isNewlyAdded" value="是"
                               @if(transIsNewlyAdded($siteInfo->is_newly_added)  == '是') checked="checked" @endif>是
                        <input type="radio" name="isNewlyAdded" id="isNewlyAdded" value="否"
                               @if(transIsNewlyAdded($siteInfo->is_newly_added) == '否') checked="checked" @endif>否

                    </td>
                </tr>
                <tr>
                    <th>场地费</th>
                    <td>
                        <input type="text" name="feeSiteOld" id="feeSiteOld" value="{{$siteInfo->fee_site}}">
                    </td>
                </tr>
            @endif
            <tr>
                <th>
                    WLAN费用（元）
                </th>
                <td>
                    <input type="text" name="feeWlan" value="{{$siteInfo->fee_wlan}}">
                </td>
            </tr>
            <tr>
                <th>
                    微波费用（元）
                </th>
                <td>
                    <input type="text" name="feeMicwav" value="{{$siteInfo->fee_microwave}}">
                </td>
            </tr>
            <tr>
                <th>
                    微波费用（元）
                </th>
                <td>
                    <input type="text" name="feeMicwav" value="{{$siteInfo->fee_microwave}}">
                </td>
            </tr>
            <tr>
                <th>
                    超过10%高等级服务站址额外维护服务费（元）
                </th>
                <td>
                    <input type="text" name="feeAdd" value="{{$siteInfo->fee_add}}">
                </td>
            </tr>
            <tr>
                <th>
                    蓄电池额外保障费（元）
                </th>
                <td>
                    <input type="text" name="feeBat" value="{{$siteInfo->fee_battery}}">
                </td>
            </tr>
            <tr>
                <th>
                    bbu安装在铁塔机房费（元）
                </th>
                <td>
                    <input type="text" name="feeBbu" value="{{$siteInfo->fee_bbu}}">
                </td>
            </tr>

            <tr>
                <th>
                    站址起租标示：
                </th>
                <td>
                    <input name="rentSiteType" type="radio" value="租用站址"
                           @if(isset($siteInfo->rent_site_type) && transRentSiteType($siteInfo->rent_site_type) == '租用站址') checked="checked" @endif >
                    租用站址
                    <input name="rentSiteType" type="radio" value="自有站址"
                           @if(isset($siteInfo->rent_site_type) && transRentSiteType($siteInfo->rent_site_type) == '自有站址') checked="checked" @endif>
                    自有站址
                    <input name="rentSiteType" type="radio" value="第三方站址"
                           @if(isset($siteInfo->rent_site_type) && transRentSiteType($siteInfo->rent_site_type) == '第三方站址') checked="checked" @endif>
                    第三方站址

                </td>
            </tr>
            <tr>
                <th>
                    站址属性：
                </th>
                <td>
                    <input name="siteProperty" type="radio" value="存量原产权"
                           @if(isset($siteInfo->site_property) && transSiteProperty($siteInfo->site_property) == '存量原产权') checked="checked" @endif>
                    存量原产权
                    <input name="siteProperty" type="radio" value="存量既有共享"
                           @if(isset($siteInfo->site_property) && transSiteProperty($siteInfo->site_property) == '存量既有共享') checked="checked" @endif>
                    存量既有共享
                    <input name="siteProperty" type="radio" value="存量自改"
                           @if(isset($siteInfo->site_property) && transSiteProperty($siteInfo->site_property) == '存量自改') checked="checked" @endif>
                    存量自改
                    <input name="siteProperty" type="radio" value="存量共享改造"
                           @if(isset($siteInfo->site_property) && transSiteProperty($siteInfo->site_property) == '存量共享改造') checked="checked" @endif>
                    存量共享改造
                    <input name="siteProperty" type="radio" value="新建铁塔"
                           @if(isset($siteInfo->site_property) && transSiteProperty($siteInfo->site_property) == '新建铁塔') checked="checked" @endif>
                    新建铁塔

                </td>
            </tr>
            <tr>
                <th>
                    村通站号：
                </th>
                <td>
                    <input name="villageSiteCode" type="text" value="{{$siteInfo->village_site_code}}">
                </td>
            </tr>
            <tr>
                <th>
                    移动站址名称：
                </th>
                <td>
                    <input name="mobileSiteName" type="text" value="{{$siteInfo->mobile_site_name}}">
                </td>
            </tr>
            <tr>
                <th>
                    联通站址名称：
                </th>
                <td>
                    <input name="unicomSiteName" type="text" value="{{$siteInfo->unicom_site_name}}">
                </td>
            </tr>
            <tr>
                <th>
                    站址网络：
                </th>
                <td>
                    <input name="siteNet" type="radio" value="村通"
                           @if(isset($siteInfo->site_net) && transSiteNet($siteInfo->site_net) == '村通') checked="checked" @endif>
                    村通
                    <input name="siteNet" type="radio" value="C村"
                           @if(isset($siteInfo->site_net) && transSiteNet($siteInfo->site_net) == 'C村') checked="checked" @endif>
                    C村
                    <input name="siteNet" type="radio" value="CDMA"
                           @if(isset($siteInfo->site_net) && transSiteNet($siteInfo->site_net) == 'CDMA') checked="checked" @endif>
                    CDMA
                    <input name="siteNet" type="radio" value="C村L"
                           @if(isset($siteInfo->site_net) && transSiteNet($siteInfo->site_net) == 'C村L') checked="checked" @endif>
                    C村L
                    <input name="siteNet" type="radio" value="CL"
                           @if(isset($siteInfo->site_net) && transSiteNet($siteInfo->site_net) == 'CL') checked="checked" @endif>
                    CL
                </td>
            </tr>
            <tr>
                <th>
                    铁塔原产权：
                </th>
                <td>
                    <input name="towerOriProperty" type="radio" value="铁塔"
                           @if(isset($siteInfo->tower_ori_property) && transTowerOriProperty($siteInfo->tower_ori_property) == '铁塔') checked="checked" @endif>
                    铁塔
                    <input name="towerOriProperty" type="radio" value="电信"
                           @if(isset($siteInfo->tower_ori_property) && transTowerOriProperty($siteInfo->tower_ori_property) == '电信') checked="checked" @endif>
                    电信
                    <input name="towerOriProperty" type="radio" value="移动"
                           @if(isset($siteInfo->tower_ori_property) && transTowerOriProperty($siteInfo->tower_ori_property) == '移动') checked="checked" @endif>
                    移动
                    <input name="towerOriProperty" type="radio" value="联通"
                           @if(isset($siteInfo->tower_ori_property) && transTowerOriProperty($siteInfo->tower_ori_property) == '联通') checked="checked" @endif>
                    联通
                    <input name="towerOriProperty" type="radio" value="广电"
                           @if(isset($siteInfo->tower_ori_property) && transTowerOriProperty($siteInfo->tower_ori_property) == '广电') checked="checked" @endif>
                    广电
                    <input name="towerOriProperty" type="radio" value="第三方"
                           @if(isset($siteInfo->tower_ori_property) && transTowerOriProperty($siteInfo->tower_ori_property) == '第三方') checked="checked" @endif>
                    第三方
                </td>
            </tr>
            <tr>
                <th>
                    机房占用：
                </th>
                <td>
                    <input name="houseOccupation" type="radio" value="0"
                           @if(isset($siteInfo->house_occupation) && transWhetherOrNot($siteInfo->house_occupation) == '0') checked="checked" @endif>
                    否
                    <input name="houseOccupation" type="radio" value="1"
                           @if(isset($siteInfo->house_occupation) && transWhetherOrNot($siteInfo->house_occupation) == '1') checked="checked" @endif>
                    是
                </td>
            </tr>
            <tr>
                <th>
                    供电方式：
                </th>
                <td>
                    <input name="powerSupplyMode" type="radio" value="直供电"
                           @if(isset($siteInfo->power_supply_mode) && transPowerSupplyMode($siteInfo->power_supply_mode) == '直供电') checked="checked" @endif>
                    直供电
                    <input name="powerSupplyMode" type="radio" value="转供电"
                           @if(isset($siteInfo->power_supply_mode) && transPowerSupplyMode($siteInfo->power_supply_mode) == '转供电') checked="checked" @endif>
                    转供电
                </td>
            </tr>
            <tr>
                <th>
                    站址是否有铁塔政企业务：
                </th>
                <td>
                    <input name="hasGovAffairs" type="radio" value="0"
                           @if(isset($siteInfo->has_gov_affairs) && transWhetherOrNot($siteInfo->has_gov_affairs) == '0') checked="checked" @endif>
                    否
                    <input name="hasGovAffairs" type="radio" value="1"
                           @if(isset($siteInfo->has_gov_affairs) && transWhetherOrNot($siteInfo->has_gov_affairs) == '1') checked="checked" @endif>
                    是
                </td>
            </tr>
            <tr>
                <th>
                    双频天线数：
                </th>
                <td>
                    <input name="dualBandAntennaNum" type="text" value="{{$siteInfo->dual_band_antenna_num}}">
                </td>
            </tr>
            <tr>
                <th>
                    维护/电力引入费场景：
                </th>
                <td>
                    <input name=" maintainImportScene" type="text" value="{{$siteInfo->maintain_import_scene}}">
                </td>
            </tr>
            <tr>
                <th>
                    场地费场景：
                </th>
                <td>
                    <input name=" siteFeeScene" type="text" value="{{$siteInfo->site_fee_scene}}">
                </td>
            </tr>
            <tr>
                <th>
                    场地费合同起始日期：
                </th>
                <td>
                    <input name=" siteFeeBeginDate" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})"
                           readonly="true" style="width:65px;padding-left:5px" type="text"/
                    value="{{$siteInfo->site_fee_begin_date}}">
                </td>
            </tr>
            <tr>
                <th>
                    场地费合同编号：
                </th>
                <td>
                    <input name="siteFeeContractCode" type="text" value="{{$siteInfo->site_fee_contract_code}}">
                </td>
            </tr>
            <tr>
                <th>
                    BBU安装位置：
                </th>
                <td>
                    <input name=" BBULocation" type="radio"
                           value="铁塔机房"
                           @if(isset($siteInfo->BBU_location) && transBBULocation($siteInfo->BBU_location)=="铁塔机房")
                           checked="checked"
                            @endif>
                    铁塔机房
                    <input name="BBULocation" type="radio" value="自有机房"
                           @if(isset($siteInfo->BBU_location) && transBBULocation($siteInfo->BBU_location)=="自有机房") checked="checked"
                            @endif>
                    自有机房
                    <input name="BBULocation" type="radio" value="第三方机房"
                           @if(isset($siteInfo->BBU_location) && transBBULocation($siteInfo->BBU_location)=="第三方机房") checked="checked"
                            @endif>
                    第三方机房
                </td>
            </tr>
            <tr>
                <th>
                    RRU安装位置：
                </th>
                <td>
                    <input name="RRULocation" type="radio" value="机房"
                           @if(isset($siteInfo->RRU_location) && transRRULocation($siteInfo->RRU_location) == '机房') checked="checked" @endif>
                    机房
                    <input name="RRULocation" type="radio" value="塔上"
                           @if(isset($siteInfo->RRU_location) && transRRULocation($siteInfo->RRU_location) == '塔上') checked="checked" @endif>
                    塔上
                </td>
            </tr>
            <tr>
                <th>
                    站址等级：
                </th>
                <td>
                    <input name="siteLevel" type="radio" value="高等级"
                           @if(isset($siteInfo->site_level) && transSiteLevel($siteInfo->site_level) == '高等级') checked="checked" @endif>
                    高等级
                    <input name="siteLevel" type="radio" value="标准等级"
                           @if(isset($siteInfo->site_level) && transSiteLevel($siteInfo->site_level) == '标准等级') checked="checked" @endif>
                    标准等级
                </td>
            </tr>
            <tr>
                <th>
                    高山站标示：
                </th>
                <td>
                    <input name="isMountainSite" type="radio" value="非高山站"
                           @if(isset($siteInfo->is_mountain_site) && transIsMountainSite($siteInfo->is_mountain_site) == '非高山站') checked="checked" @endif>
                    非高山站
                    <input name="isMountainSite" type="radio" value="高山站"
                           @if(isset($siteInfo->is_mountain_site) && transIsMountainSite($siteInfo->is_mountain_site) == '高山站') checked="checked" @endif>
                    高山站
                </td>
            </tr>
            <tr>
                <th>
                    一级防雷SPD状态：
                </th>
                <td>
                    <input name="SPDLevel1" type="radio" value="正常"
                           @if(isset($siteInfo->SPD_level1) && transSPDLevel($siteInfo->SPD_level1) == '正常') checked="checked" @endif>
                    正常
                    <input name="SPDLevel1" type="radio" value="故障"
                           @if(isset($siteInfo->SPD_level1) && transSPDLevel($siteInfo->SPD_level1) == '故障') checked="checked" @endif>
                    故障
                    <input name="SPDLevel1" type="radio" value="无"
                           @if(isset($siteInfo->SPD_level1) && transSPDLevel($siteInfo->SPD_level1) == '无') checked="checked" @endif>
                    无
                </td>
            </tr>
            <tr>
                <th>
                    二级防雷SPD状态：
                </th>
                <td>
                    <input name="SPDLevel2" type="radio" value="正常"
                           @if(isset($siteInfo->SPD_level1) && transSPDLevel($siteInfo->SPD_level2) == '正常') checked="checked" @endif>
                    正常
                    <input name="SPDLevel2" type="radio" value="故障"
                           @if(isset($siteInfo->SPD_level1) && transSPDLevel($siteInfo->SPD_level2) == '故障') checked="checked" @endif>
                    故障
                    <input name="SPDLevel2" type="radio" value="无"
                           @if(isset($siteInfo->SPD_level1) && transSPDLevel($siteInfo->SPD_level2) == '无') checked="checked" @endif>
                    无
                </td>
            </tr>
            <tr>
                <th>
                    三级防雷SPD状态：
                </th>
                <td>
                    <input name="SPDLevel3" type="radio" value="正常"
                           @if(isset($siteInfo->SPD_level3) && transSPDLevel($siteInfo->SPD_level3) == '正常') checked="checked" @endif>
                    正常
                    <input name="SPDLevel3" type="radio" value="故障"
                           @if(isset($siteInfo->SPD_level3) && transSPDLevel($siteInfo->SPD_level3) == '故障') checked="checked" @endif>
                    故障
                    <input name="SPDLevel3" type="radio" value="无"
                           @if(isset($siteInfo->SPD_level3) && transSPDLevel($siteInfo->SPD_level3) == '无') checked="checked" @endif>
                    无
                </td>
            </tr>
            <tr>
                <th>
                    零地混接：
                </th>
                <td>
                    <input name="NEWireMixed" type="radio" value="0"
                           @if(isset($siteInfo->NE_wire_mixed) && transWhetherOrNot($siteInfo->NE_wire_mixed) == '0') checked="checked" @endif>
                    否
                    <input name="NEWireMixed" type="radio" value="1"
                           @if(isset($siteInfo->NE_wire_mixed) && transWhetherOrNot($siteInfo->NE_wire_mixed) == '1') checked="checked" @endif>
                    是
                </td>
            </tr>
            <tr>
                <th>
                    业务设备接地：
                </th>
                <td>
                    <input name="isBusinessEarth" type="radio" value="未接地"
                           @if(isset($siteInfo->is_business_earth) && transIsBusinessEarth($siteInfo->is_business_earth) == '未接地') checked="checked" @endif>
                    未接地
                    <input name="isBusinessEarth" type="radio" value="正常"
                           @if(isset($siteInfo->is_business_earth) && transIsBusinessEarth($siteInfo->is_business_earth) == '正常') checked="checked" @endif>
                    正常
                </td>
            </tr>
            <tr>
                <th>
                    接地线缆/汇流排：
                </th>
                <td>
                    <input name="earthBusBarWire" type="radio" value="正常"
                           @if(isset($siteInfo->earth_bus_bar_wire) && transEarthBusBarWire($siteInfo->earth_bus_bar_wire) == '正常') checked="checked" @endif>
                    正常
                    <input name="earthBusBarWire" type="radio" value="被盗"
                           @if(isset($siteInfo->earth_bus_bar_wire) && transEarthBusBarWire($siteInfo->earth_bus_bar_wire) == '被盗') checked="checked" @endif>
                    被盗
                    <input name="earthBusBarWire" type="radio" value="未接地"
                           @if(isset($siteInfo->earth_bus_bar_wire) && transEarthBusBarWire($siteInfo->earth_bus_bar_wire) == '未接地') checked="checked" @endif>
                    未接地
                </td>
            </tr>
            <tr>
                <th>
                    防雷接地状态：
                </th>
                <td>
                    <input name="SPDEarthStatus" type="radio" value="SPD正常"
                           @if(isset($siteInfo->SPD_earth_status) && transSPDEarthStatus($siteInfo->SPD_earth_status) == 'SPD正常') checked="checked" @endif>
                    SPD正常
                    <input name="SPDEarthStatus" type="radio" value="SPD故障"
                           @if(isset($siteInfo->SPD_earth_status) && transSPDEarthStatus($siteInfo->SPD_earth_status) == 'SPD故障') checked="checked" @endif>
                    SPD故障
                    <input name="SPDEarthStatus" type="radio" value="接地线被盗"
                           @if(isset($siteInfo->SPD_earth_status) && transSPDEarthStatus($siteInfo->SPD_earth_status) == '接地线被盗') checked="checked" @endif>
                    接地线被盗
                    <input name="SPDEarthStatus" type="radio" value="设备未接地"
                           @if(isset($siteInfo->SPD_earth_status) && transSPDEarthStatus($siteInfo->SPD_earth_status) == '设备未接地') checked="checked" @endif>
                    设备未接地
                </td>
            </tr>
            <tr>
                <th>
                    是否安装发电倒换箱：
                </th>
                <td>
                    <input name="hadPowerConversion" type="radio" value="0"
                           @if(isset($siteInfo->had_power_conversion) && transWhetherOrNot($siteInfo->had_power_conversion) == '0') checked="checked" @endif>
                    否
                    <input name="hadPowerConversion" type="radio" value="1"
                           @if(isset($siteInfo->had_power_conversion) && transWhetherOrNot($siteInfo->had_power_conversion) == '1') checked="checked" @endif>
                    是
                </td>
            </tr>
            <tr>
                <th>
                    零地电压：
                </th>
                <td>
                    <input name="NEVoltage" type="text" value="{{$siteInfo->NE_voltage}}">
                </td>
            </tr>
            <tr>
                <th>
                    是否具备发电条件：
                </th>
                <td>
                    <input name="hasGeCondition" type="radio" value="0"
                           @if(isset($siteInfo->has_ge_condition) && transWhetherOrNot($siteInfo->has_ge_condition) == '0') checked="checked" @endif>
                    否
                    <input name="hasGeCondition" type="radio" value="1"
                           @if(isset($siteInfo->has_ge_condition) && transWhetherOrNot($siteInfo->has_ge_condition) == '1') checked="checked" @endif>
                    是
                </td>
            </tr>
            <tr>
                <th>
                    是否包干发电：
                </th>
                <td>
                    <input name="isGnrAllInCharge" type="radio" value="0"
                           @if(isset($siteInfo->is_gnr_all_in_charge) && transIsGnrAllInCharge($siteInfo->is_gnr_all_in_charge) == '0') checked="checked" @endif>
                    否
                    <input name="isGnrAllInCharge" type="radio" value="1"
                           @if(isset($siteInfo->is_gnr_all_in_charge) && transIsGnrAllInCharge($siteInfo->is_gnr_all_in_charge) == '1') checked="checked" @endif>
                    是
                </td>
            </tr>
            <tr>
                <th>
                    电源柜性能：
                </th>
                <td>
                    <input name="powerCabinetCapacity" type="radio" value="正常"
                           @if(isset($siteInfo->power_cabinet_capacity) && transPowerCabinetCapacity($siteInfo->power_cabinet_capacity) == '正常') checked="checked" @endif>
                    正常
                    <input name="powerCabinetCapacity" type="radio" value="故障"
                           @if(isset($siteInfo->power_cabinet_capacity) && transPowerCabinetCapacity($siteInfo->power_cabinet_capacity) == '故障') checked="checked" @endif>
                    故障
                    <input name="powerCabinetCapacity" type="radio" value="容量不足"
                           @if(isset($siteInfo->power_cabinet_capacity) && transPowerCabinetCapacity($siteInfo->power_cabinet_capacity) == '容量不足') checked="checked" @endif>
                    容量不足
                </td>
            </tr>
            <tr>
                <th>
                    模块总容量：
                </th>
                <td>
                    <input name="moduleVolume" type="text" value="{{$siteInfo->module_volume}}">
                </td>
            </tr>
            <tr>
                <th>
                    电池容量：
                </th>
                <td>
                    <input name="batteryVolume" type="radio" value="300AH"
                           @if(isset($siteInfo->battery_volume) && transBatteryVolume($siteInfo->battery_volume) == '300AH') checked="checked" @endif>
                    300AH
                    <input name="batteryVolume" type="radio" value="500AH"
                           @if(isset($siteInfo->battery_volume) && transBatteryVolume($siteInfo->battery_volume) == '500AH') checked="checked" @endif>
                    500AH
                    <input name="batteryVolume" type="radio" value="1000AH"
                           @if(isset($siteInfo->battery_volume) && transBatteryVolume($siteInfo->battery_volume) == '1000AH') checked="checked" @endif>
                    1000AH
                </td>
            </tr>
            <tr>
                <th>
                    电池组数：
                </th>
                <td>
                    <input name="batteryNum" type="radio" value="1"
                           @if(isset($siteInfo->battery_num) && transBatteryNum($siteInfo->battery_num) == '1') checked="checked" @endif>
                    1
                    <input name="batteryNum" type="radio" value="2"
                           @if(isset($siteInfo->battery_num) && transBatteryNum($siteInfo->battery_num) == '2') checked="checked" @endif>
                    2
                </td>
            </tr>
            <tr>
                <th>
                    电池性能：
                </th>
                <td>
                    <input name="batteryCapability" type="radio" value="秒退"
                           @if(isset($siteInfo->battery_capability) && transBatteryCapability($siteInfo->battery_capability) == '秒退') checked="checked" @endif>
                    秒退
                    <input name="batteryCapability" type="radio" value="1小时"
                           @if(isset($siteInfo->battery_capability) && transBatteryCapability($siteInfo->battery_capability) == '1小时') checked="checked" @endif>
                    1小时
                    <input name="batteryCapability" type="radio" value="2小时"
                           @if(isset($siteInfo->battery_capability) && transBatteryCapability($siteInfo->battery_capability) == '2小时') checked="checked" @endif>
                    2小时
                    <input name="batteryCapability" type="radio" value="3小时"
                           @if(isset($siteInfo->battery_capability) && transBatteryCapability($siteInfo->battery_capability) == '3小时') checked="checked" @endif>
                    3小时
                    <input name="batteryCapability" type="radio" value="大于3小时"
                           @if(isset($siteInfo->battery_capability) && transBatteryCapability($siteInfo->battery_capability) == '大于3小时') checked="checked" @endif>
                    大于3小时
                </td>
            </tr>
            <tr>
                <th>
                    站址交流负荷：
                </th>
                <td>
                    <input name="AloadSite" type="text" value="{{$siteInfo->Aload_site}}">
                </td>
            </tr>
            <tr>
                <th>
                    电信直流负荷：
                </th>
                <td>
                    <input name="DloadTele" type="text" value="{{$siteInfo->Dload_tele}}">
                </td>
            </tr>
            <tr>
                <th>
                    移动直流负荷：
                </th>
                <td>
                    <input name="DloadMobile" type="text" value="{{$siteInfo->Dload_mobile}}">
                </td>
            </tr>
            <tr>
                <th>
                    联通直流负荷：
                </th>
                <td>
                    <input name="DloadUnicom" type="text" value="{{$siteInfo->Dload_unicom}}">
                </td>
            </tr>
            <tr>
                <th>
                    铁塔政企业务直流负荷：
                </th>
                <td>
                    <input name="DloadTowerGov" type="text" value="{{$siteInfo->Dload_tower_gov}}">
                </td>
            </tr>
            <tr>
                <th>
                    环境设备：
                </th>
                <td>
                    <input name="envirEquip" type="radio" value="空调"
                           @if(isset($siteInfo->envir_equip) && transEnvirEquip($siteInfo->envir_equip) =="空调")
                           checked="checked" @endif>
                    空调
                    <input name="envirEquip" type="radio" value="风机"
                           @if(isset($siteInfo->envir_equip) && transEnvirEquip($siteInfo->envir_equip) =="风机")
                           checked="checked" @endif>
                    风机
                    <input name="envirEquip" type="radio" value="无"
                           @if(isset($siteInfo->envir_equip) && transEnvirEquip($siteInfo->envir_equip) =="无")
                           checked="checked" @endif>
                    无
                </td>
            </tr>
            <tr>
                <th>
                    环境设备状态：
                </th>
                <td>
                    <input name="envirEquipStatus" type="radio" value="故障"
                           @if(isset($siteInfo->envir_equip_status) && transEnvirEquipStatus($siteInfo->envir_equip_status) =="故障") checked="checked" @endif>
                    故障
                    <input name="envirEquipStatus" type="radio" value="正常"
                           @if(isset($siteInfo->envir_equip_status) && transEnvirEquipStatus($siteInfo->envir_equip_status) =="正常") checked="checked" @endif>
                    正常
                </td>
            </tr>
            <tr>
                <th>
                    电信主设备：
                </th>
                <td>
                    <input name="teleMainEquip" type="text" value="{{$siteInfo->tele_main_equip}}">
                </td>
            </tr>
            <tr>
                <th>
                    铁塔动环状态：
                </th>
                <td>
                    <input name="towerDEStatus" type="radio" value="故障"
                           @if(isset($siteInfo->tower_DE_status) && transTowerDEStatus($siteInfo->tower_DE_status) =="故障") checked="checked" @endif>
                    故障
                    <input name="towerDEStatus" type="radio" value="正常"
                           @if(isset($siteInfo->tower_DE_status) && transTowerDEStatus($siteInfo->tower_DE_status) =="正常") checked="checked" @endif>
                    正常
                </td>
            </tr>
            <tr>
                <th>
                    直接上站：
                </th>
                <td>
                    <input name="directCheck" type="text" value="{{$siteInfo->direct_check}}">
                </td>
            </tr>
            <tr>
                <th>
                    需证件上站：
                </th>
                <td>
                    <input name="certificateCheck" type="text" value="{{$siteInfo->certificate_check}}">
                </td>
            </tr>
            <tr>
                <th>
                    楼顶管控：
                </th>
                <td>
                    <input name="roofControl" type="text" value="{{$siteInfo->roof_control}}">
                </td>
            </tr>
            <tr>
                <th>
                    不可抵达：
                </th>
                <td>
                    <input name="unreachable" type="text" value="{{$siteInfo->unreachable}}">
                </td>
            </tr>
            <tr>
                <th>
                    铁塔全景照片(采集/上传)：
                </th>
                <td>
                    <input name="CUTowerView" type="radio" value="0"
                           @if(isset($siteInfo->CU_tower_view) && transWhetherOrNot($siteInfo->CU_tower_view) =="0") checked="checked" @endif>
                    否
                    <input name="CUTowerView" type="radio" value="1"
                           @if(isset($siteInfo->CU_tower_view) && transWhetherOrNot($siteInfo->CU_tower_view) =="1") checked="checked" @endif>
                    是
                </td>
            </tr>
            <tr>
                <th>
                    机房全景照片(采集/上传)：
                </th>
                <td>
                    <input name="CUHouseView" type="radio" value="0"
                           @if(isset($siteInfo->CU_house_view) && transWhetherOrNot($siteInfo->CU_house_view) =="0") checked="checked" @endif>
                    否
                    <input name="CUHouseView" type="radio" value="1"
                           @if(isset($siteInfo->CU_house_view) && transWhetherOrNot($siteInfo->CU_house_view) =="1") checked="checked" @endif>
                    是
                </td>
            </tr>
            <tr>
                <th>
                    配套全景照片(采集/上传)：
                </th>
                <td>
                    <input name="CUSupportView" type="radio" value="0"
                           @if(isset($siteInfo->CU_support_view) && transWhetherOrNot($siteInfo->CU_support_view) =="0") checked="checked" @endif>
                    否
                    <input name="CUSupportView" type="radio" value="1"
                           @if(isset($siteInfo->CU_support_view) && transWhetherOrNot($siteInfo->CU_support_view) =="1") checked="checked" @endif>
                    是
                </td>
            </tr>



        </table>
        <input class="formButton" type="button" value="修改" onclick="doModify()">
    </form>
    <form action="{{url('backend/siteInfo/delete/'.$siteInfo->site_code)}}" method="get" style="display:inline;"
          id="delForm">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        <input type="hidden" value="{{$filter['region']}}" name="region">
        <input type="button" class="formButton" value="删除" onclick="doDel()">
    </form>
    <input type="button" class="formButton" value="返回" onclick="history.back()">
    </body>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {
            $('#menu_business').addClass("current");
        });

        function doBack() {
            var listForm = document.getElementById('listForm');
            listForm.action = "{{url('backend/siteInfo/back')}}";
            listForm.submit();
        }

        function doModify() {
            var siteCode = $('#siteCode').val();
            var modifyTime = $('#effectiveDate').val();
            var towerType = document.getElementById('towerType');
            var sysNum = document.getElementsByName('sysNum');
            var sysHeight1 = document.getElementsByName('sysHeight1');
            var sysHeight2 = document.getElementsByName('sysHeight2');
            var sysHeight3 = document.getElementsByName('sysHeight3');
            var sysHeight4 = document.getElementsByName('sysHeight4');
            var sysHeight5 = document.getElementsByName('sysHeight5');
            for (var i = 0; i < sysNum.length; i++) {
                if (sysNum[i].checked) {
                    var sys_Num = sysNum[i].value;
                }
            }
            for (var i = 0; i < sysHeight1.length; i++) {
                if (sysHeight1[i].checked) {
                    var sysHeight_1 = sysHeight1[i].value;
                }
            }
            for (var i = 0; i < sysHeight2.length; i++) {
                if (sysHeight2[i].checked) {
                    var sysHeight_2 = sysHeight2[i].value;
                }
            }
            for (var i = 0; i < sysHeight3.length; i++) {
                if (sysHeight3[i].checked) {
                    var sysHeight_3 = sysHeight3[i].value;
                }
            }
            for (var i = 0; i < sysHeight4.length; i++) {
                if (sysHeight4[i].checked) {
                    var sysHeight_4 = sysHeight4[i].value;
                }
            }
            for (var i = 0; i < sysHeight5.length; i++) {
                if (sysHeight5[i].checked) {
                    var sysHeight_5 = sysHeight5[i].value;
                }
            }


            if (modifyTime == '') {
                alert('请输入属性变更日期！');
                return;
            }
            if (sys_Num == '1') {
                if (sysHeight_1 == '无') {
                    alert('请选择系统1的挂高！');
                    return;
                }

//                if (towerType == '普通地面塔'){
//                    if(sysHeight_1 != 'H<30' && sysHeight_1 != '30<=H<35' && sysHeight_1 != '35<=H<40' &&
//                        sysHeight_1 != '40<=H<45' && sysHeight_1 != '45<=H<50'){
//                        alert('系统1的高度与铁塔类型不匹配！');
//                        return;
//                    }
//                }
//                if (towerType == '景观塔'){
//                    alert(sysHeight_1);
//                    if(sysHeight_1 != 'H<20' && sysHeight_1 != '20<=H<25' && sysHeight_1 != '25<=H<30' &&
//                        sysHeight_1 != '30<=H<35' && sysHeight_1 != '35<=H<40'){
//                        alert('系统1的高度与铁塔类型不匹配！');
//                        return;
//                    }
//                }
//                if (towerType == '简易塔' || towerType == '普通楼面塔' || towerType == '楼面抱杆'){
//                    if(sysHeight_1 != '任意高度'){
//                        alert('系统1的高度与铁塔类型不匹配！');
//                        return;
//                    }
//                }
            }
            if (sys_Num == '2') {
                if (sysHeight_1 == '无') {
                    alert('请选择系统1的挂高！');
                    return;
                }
                if (sysHeight_2 == '无') {
                    alert('请选择系统2的挂高！');
                    return;
                }
            }
            if (sys_Num == '3') {
                if (sysHeight_1 == '无') {
                    alert('请选择系统1的挂高！');
                    return;
                }
                if (sysHeight_2 == '无') {
                    alert('请选择系统2的挂高！');
                    return;
                }
                if (sysHeight_3 == '无') {
                    alert('请选择系统3的挂高！');
                    return;
                }
            }
            if (sys_Num == '4') {
                if (sysHeight_1 == '无') {
                    alert('请选择系统1的挂高！');
                    return;
                }
                if (sysHeight_2 == '无') {
                    alert('请选择系统2的挂高！');
                    return;
                }
                if (sysHeight_3 == '无') {
                    alert('请选择系统3的挂高！');
                    return;
                }
                if (sysHeight_4 == '无') {
                    alert('请选择系统4的挂高！');
                    return;
                }
            }
            if (sys_Num == '5') {
                if (sysHeight_1 == '无') {
                    alert('请选择系统1的挂高！');
                    return;
                }
                if (sysHeight_2 == '无') {
                    alert('请选择系统2的挂高！');
                    return;
                }
                if (sysHeight_3 == '无') {
                    alert('请选择系统3的挂高！');
                    return;
                }
                if (sysHeight_4 == '无') {
                    alert('请选择系统4的挂高！');
                    return;
                }
                if (sysHeight_5 == '无') {
                    alert('请选择系统5的挂高！');
                    return;
                }
            }
            if (siteCode == '') {
                alert('请输入站址编码！');
                return;
            }
            if (confirm('确认提交吗？')) {
                var form = $('#listForm');
                form.submit();
            }


        }

        function doDel() {
            if (confirm('确认删除吗？')) {
                var delForm = $('#delForm');
                delForm.submit();
            }

        }

        function towerTypeChange(osel) {
            var h1 = document.getElementsByName('h1');
            var h2 = document.getElementsByName('h2');
            var h3 = document.getElementsByName('h3');
            var h4 = document.getElementsByName('h4');
            var h5 = document.getElementsByName('h5');
            var h6 = document.getElementsByName('h6');
            var h7 = document.getElementsByName('h7');
            var h8 = document.getElementsByName('h8');
            var h9 = document.getElementsByName('h9');
            if (osel.value == '普通地面塔') {
                for (var i = 0; i < h1.length; i++) {
                    h1[i].style.display = 'none';
                }
                for (var i = 0; i < h2.length; i++) {
                    h2[i].style.display = 'none';
                }
                for (var i = 0; i < h3.length; i++) {
                    h3[i].style.display = 'none';
                }
                for (var i = 0; i < h4.length; i++) {
                    h4[i].style.display = 'inline';
                }
                for (var i = 0; i < h5.length; i++) {
                    h5[i].style.display = 'inline';
                }
                for (var i = 0; i < h6.length; i++) {
                    h6[i].style.display = 'inline';
                }
                for (var i = 0; i < h7.length; i++) {
                    h7[i].style.display = 'inline';
                }
                for (var i = 0; i < h8.length; i++) {
                    h8[i].style.display = 'inline';
                }
                for (var i = 0; i < h9.length; i++) {
                    h9[i].style.display = 'none';
                }
            }
            if (osel.value == '景观塔') {
                for (var i = 0; i < h1.length; i++) {
                    h1[i].style.display = 'inline';
                }
                for (var i = 0; i < h2.length; i++) {
                    h2[i].style.display = 'inline';
                }
                for (var i = 0; i < h3.length; i++) {
                    h3[i].style.display = 'inline';
                }
                for (var i = 0; i < h4.length; i++) {
                    h4[i].style.display = 'none';
                }
                for (var i = 0; i < h5.length; i++) {
                    h5[i].style.display = 'inline';
                }
                for (var i = 0; i < h6.length; i++) {
                    h6[i].style.display = 'inline';
                }
                for (var i = 0; i < h7.length; i++) {
                    h7[i].style.display = 'none';
                }
                for (var i = 0; i < h8.length; i++) {
                    h8[i].style.display = 'none';
                }
                for (var i = 0; i < h9.length; i++) {
                    h9[i].style.display = 'none';
                }
            }
            if (osel.value == '简易塔') {
                for (var i = 0; i < h1.length; i++) {
                    h1[i].style.display = 'none';
                }
                for (var i = 0; i < h2.length; i++) {
                    h2[i].style.display = 'none';
                }
                for (var i = 0; i < h3.length; i++) {
                    h3[i].style.display = 'none';
                }
                for (var i = 0; i < h4.length; i++) {
                    h4[i].style.display = 'none';
                }
                for (var i = 0; i < h5.length; i++) {
                    h5[i].style.display = 'none';
                }
                for (var i = 0; i < h6.length; i++) {
                    h6[i].style.display = 'none';
                }
                for (var i = 0; i < h7.length; i++) {
                    h7[i].style.display = 'none';
                }
                for (var i = 0; i < h8.length; i++) {
                    h8[i].style.display = 'none';
                }
                for (var i = 0; i < h9.length; i++) {
                    h9[i].style.display = 'inline';
                }
            }
            if (osel.value == '普通楼面塔') {
                for (var i = 0; i < h1.length; i++) {
                    h1[i].style.display = 'none';
                }
                for (var i = 0; i < h2.length; i++) {
                    h2[i].style.display = 'none';
                }
                for (var i = 0; i < h3.length; i++) {
                    h3[i].style.display = 'none';
                }
                for (var i = 0; i < h4.length; i++) {
                    h4[i].style.display = 'none';
                }
                for (var i = 0; i < h5.length; i++) {
                    h5[i].style.display = 'none';
                }
                for (var i = 0; i < h6.length; i++) {
                    h6[i].style.display = 'none';
                }
                for (var i = 0; i < h7.length; i++) {
                    h7[i].style.display = 'none';
                }
                for (var i = 0; i < h8.length; i++) {
                    h8[i].style.display = 'none';
                }
                for (var i = 0; i < h9.length; i++) {
                    h9[i].style.display = 'inline';
                }
            }
            if (osel.value == '楼面抱杆') {
                for (var i = 0; i < h1.length; i++) {
                    h1[i].style.display = 'none';
                }
                for (var i = 0; i < h2.length; i++) {
                    h2[i].style.display = 'none';
                }
                for (var i = 0; i < h3.length; i++) {
                    h3[i].style.display = 'none';
                }
                for (var i = 0; i < h4.length; i++) {
                    h4[i].style.display = 'none';
                }
                for (var i = 0; i < h5.length; i++) {
                    h5[i].style.display = 'none';
                }
                for (var i = 0; i < h6.length; i++) {
                    h6[i].style.display = 'none';
                }
                for (var i = 0; i < h7.length; i++) {
                    h7[i].style.display = 'none';
                }
                for (var i = 0; i < h8.length; i++) {
                    h8[i].style.display = 'none';
                }
                for (var i = 0; i < h9.length; i++) {
                    h9[i].style.display = 'inline';
                }
            }


        }

        function shareTypeChange(osel) {
            var userType1 = document.getElementById('userType1');
            var userType2 = document.getElementById('userType2');
            if (osel.options[osel.selectedIndex].text == '电信独享') {
                userType1.style.display = 'inline';
                userType2.style.display = 'none';
            }
            else {
                userType1.style.display = 'none';
                userType2.style.display = 'inline';
            }
        }

        function sysNumChange(osel) {
            var sys1 = document.getElementById('sys1');
            var sys2 = document.getElementById('sys2');
            var sys3 = document.getElementById('sys3');
            var sys4 = document.getElementById('sys4');
            var sys5 = document.getElementById('sys5');
            if (osel.options[osel.selectedIndex].text == '1') {
                sys1.style.display = '';
                sys2.style.display = 'none';
                sys3.style.display = 'none';
                sys4.style.display = 'none';
                sys5.style.display = 'none';
            }
            if (osel.options[osel.selectedIndex].text == '2') {
                sys1.style.display = '';
                sys2.style.display = '';
                sys3.style.display = 'none';
                sys4.style.display = 'none';
                sys5.style.display = 'none';
            }
            if (osel.options[osel.selectedIndex].text == '3') {
                sys1.style.display = '';
                sys2.style.display = '';
                sys3.style.display = '';
                sys4.style.display = 'none';
                sys5.style.display = 'none';
            }
            if (osel.options[osel.selectedIndex].text == '4') {
                sys1.style.display = '';
                sys2.style.display = '';
                sys3.style.display = '';
                sys4.style.display = '';
                sys5.style.display = 'none';
            }
            if (osel.options[osel.selectedIndex].text == '5') {
                sys1.style.display = '';
                sys2.style.display = '';
                sys3.style.display = '';
                sys4.style.display = '';
                sys5.style.display = '';
            }

        }

        function doLoad(sysNum) {
            var sys1 = document.getElementById('sys1');
            var sys2 = document.getElementById('sys2');
            var sys3 = document.getElementById('sys3');
            var sys4 = document.getElementById('sys4');
            var sys5 = document.getElementById('sys5');
            if (sysNum == '1') {
                sys1.style.display = '';
                sys2.style.display = 'none';
                sys3.style.display = 'none';
                sys4.style.display = 'none';
                sys5.style.display = 'none';
            }
            if (sysNum == '2') {
                sys1.style.display = '';
                sys2.style.display = '';
                sys3.style.display = 'none';
                sys4.style.display = 'none';
                sys5.style.display = 'none';
            }
            if (sysNum == '3') {
                sys1.style.display = '';
                sys2.style.display = '';
                sys3.style.display = '';
                sys4.style.display = 'none';
                sys5.style.display = 'none';
            }
            if (sysNum == '4') {
                sys1.style.display = '';
                sys2.style.display = '';
                sys3.style.display = '';
                sys4.style.display = '';
                sys5.style.display = 'none';
            }
            if (sysNum == '5') {
                sys1.style.display = '';
                sys2.style.display = '';
                sys3.style.display = '';
                sys4.style.display = '';
                sys5.style.display = '';
            }
        }


    </script>
@endsection







