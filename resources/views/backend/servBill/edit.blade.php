@extends('layouts.app')

@section('header')
    <title>编辑站址信息</title>
@endsection

@section('content')
    <div class="container" style="width:100% ">
        <div class="row clearfix">
            <div class="col-md-12 column" style="padding: 0">
                {{--<div class="collapse navbar-collapse" id="example-navbar-collapse" style="padding: 0">--}}
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
                        <a href="#">异常订单编辑</a>
                    </li>
                </ul>
            </div>
        </div>

    </div>

    {{--<body class="input managerInfo" onload="doLoad({{$telecomOrder->sys_num}})">--}}
    <body class="input managerInfo">
    <div class="bar">
        <div style="float:left;">
            请修改或者删除站址信息
        </div>

    </div>
    <div id="validateErrorContainer" class="validateErrorContainer">

    </div>

    <form id="listForm" method="POST" action="" style="display: inline;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <table class="inputTable tabContent">
            <tr>
                <th>
                    产品业务确认单编号 :
                </th>
                <td>

                    <input type="text" @if(isset($telecomOrder->business_code)) value="{{$telecomOrder->business_code}}"
                           @endif id="businessCode" name="businessCode" readonly>
                </td>
            </tr>
            <tr>
                <th>
                    需求确认单编号 :
                </th>
                <td>

                    <input type="text" @if(isset($telecomOrder->req_code)) value="{{$telecomOrder->req_code}}"
                           @endif id="reqCode" name="reqCode" readonly>
                </td>
            </tr>
            <tr>
                <th>
                    站址编码 :
                </th>
                <td>

                    <input type="text" @if(isset($telecomOrder->site_code)) value="{{$telecomOrder->site_code}}"
                           @endif id="siteCode" name="siteCode" readonly>
                </td>
            </tr>
            <tr>
                <th>
                    站址名称 :
                </th>
                <td>

                    <input type="text" @if(isset($telecomOrder->site_name)) value="{{$telecomOrder->site_name}}"
                           @endif id="siteName" name="siteName" readonly>
                </td>
            </tr>
            <tr>
                <th>
                    地市 :
                </th>
                <td>

                    <input type="text"
                           @if(isset($telecomOrder->region_name)) value="{{$telecomOrder->region_name}}"
                           @endif id="region" name="region"
                           readonly>
                </td>
            </tr>
            <tr>
                <th>
                    是否为新建站 :
                </th>

                <td>
                    <input type="radio" id="isNewTower" name="isNewTower" value="是"
                           @if(isset($telecomOrder->is_new_tower) && transIsNewTower($telecomOrder->is_new_tower) == '是') checked="checked"
                           @endif disabled>是
                    <input type="radio" id="isNewTower" name="isNewTower" value="否"
                           @if(isset($telecomOrder->is_new_tower) && transIsNewTower($telecomOrder->is_new_tower) == '否') checked="checked"
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
                           @if(isset($telecomOrder->is_co_opetition) && transIsCoOpetition($telecomOrder->is_co_opetition) == '是') checked="checked" @endif>是
                    <input type="radio" name="isCoOpetition" id="isCoOpetition" value="否"
                           @if(isset($telecomOrder->is_co_opetition) && transIsCoOpetition($telecomOrder->is_co_opetition) == '否') checked="checked" @endif>否

                </td>
            </tr>
            @if(transIsNewTower($telecomOrder->is_new_tower) == '是')
                <tr>
                    <th>
                        站址所在地区类型:
                    </th>
                    <td>
                        <input type="radio" name="siteDistType" id="siteDistType" value="市区"
                               @if(isset($telecomOrder->site_district_type) && transSiteDistType($telecomOrder->site_district_type) =="市区") checked="checked"@endif>市区
                        <input type="radio" name="siteDistType" id="siteDistType" value="城镇"
                               @if(isset($telecomOrder->site_district_type) && transSiteDistType($telecomOrder->site_district_type)=="城镇") checked="checked"@endif>城镇
                        <input type="radio" name="siteDistType" id="siteDistType" value="农村"
                               @if(isset($telecomOrder->site_district_type) && transSiteDistType($telecomOrder->site_district_type)=="农村") checked="checked"@endif>农村


                    </td>
                </tr>
                <tr>
                    <th>
                        是否RRU拉远:
                    </th>
                    <td>
                        <input type="radio" name="rruAway" id="rruAway" value="是"
                               @if(isset($telecomOrder->is_rru_away) && transIsRRUAway($telecomOrder->is_rru_away) =="是") checked="checked"@endif>是
                        <input type="radio" name="rruAway" id="rruAway" value="否"
                               @if(isset($telecomOrder->is_rru_away) && transIsRRUAway($telecomOrder->is_rru_away)=="否")checked="checked"@endif>否


                    </td>
                </tr>
                <tr>
                    <th>
                        引电类型(V):
                    </th>
                    <td>
                        <input type="radio" name="elecIntroType" id="elecIntroType" value="380V"
                               @if(isset($telecomOrder->elec_introduced_type) && transElecType($telecomOrder->elec_introduced_type) =="380V") checked="checked" @endif>380V
                        <input type="radio" name="elecIntroType" id="elecIntroType" value="220V"
                               @if(isset($telecomOrder->elec_introduced_type) && transElecType($telecomOrder->elec_introduced_type)=="220V") checked="checked" @endif>220V
                    </td>
                </tr>
            @endif
            <tr>
                <th>
                    产品配套类型 :
                </th>

                <td>
                    <input type="radio" name="productType" id="productType" value="铁塔+自有机房+配套"
                           @if(isset($telecomOrder->product_type) && transProductType($telecomOrder->product_type) == '铁塔+自有机房+配套') checked="checked"@endif>铁塔+自有机房+配套
                    <input type="radio" name="productType" id="productType" value="铁塔+租赁机房+配套"
                           @if(isset($telecomOrder->product_type) && transProductType($telecomOrder->product_type) == '铁塔+租赁机房+配套')checked="checked"@endif>铁塔+租赁机房+配套
                    <input type="radio" name="productType" id="productType" value="铁塔+一体化机柜+配套"
                           @if(isset($telecomOrder->product_type) && transProductType($telecomOrder->product_type) == '铁塔+一体化机柜+配套') checked="checked"@endif>铁塔+一体化机柜+配套
                    <input type="radio" name="productType" id="productType" value="铁塔+RRU拉远+配套"
                           @if(isset($telecomOrder->product_type) && transProductType($telecomOrder->product_type) == '铁塔+RRU拉远+配套') checked="checked"@endif>铁塔+RRU拉远+配套
                    <input type="radio" name="productType" id="productType" value="铁塔(无机房及配套)"
                           @if(isset($telecomOrder->product_type) && transProductType($telecomOrder->product_type) == '铁塔(无机房及配套)') checked="checked"@endif>铁塔(无机房及配套)

                </td>
            </tr>
            <tr>
                <th>
                    铁塔类型:
                </th>
                <td>
                    <input type="radio" name="towerType" id="towerType" value="普通地面塔"
                           @if(isset($telecomOrder->tower_type) && transTowerType($telecomOrder->tower_type) =="普通地面塔") checked="checked"
                           @endif
                           onclick="towerTypeChange(this)">普通地面塔
                    <input type="radio" name="towerType" id="towerType" value="景观塔"
                           @if(isset($telecomOrder->tower_type) && transTowerType($telecomOrder->tower_type)=="景观塔") checked="checked"
                           @endif
                           onclick="towerTypeChange(this)">景观塔
                    <input type="radio" name="towerType" id="towerType" value="简易塔"
                           @if(isset($telecomOrder->tower_type) && transTowerType($telecomOrder->tower_type)=="简易塔") checked="checked"
                           @endif
                           onclick="towerTypeChange(this)">简易塔
                    <input type="radio" name="towerType" id="towerType" value="普通楼面塔"
                           @if(isset($telecomOrder->tower_type) && transTowerType($telecomOrder->tower_type)=="普通楼面塔") checked="checked"
                           @endif
                           onclick="towerTypeChange(this)">普通楼面塔
                    <input type="radio" name="towerType" id="towerType" value="楼面抱杆"
                           @if(isset($telecomOrder->tower_type) && transTowerType($telecomOrder->tower_type)=="楼面抱杆") checked="checked"
                           @endif
                           onclick="towerTypeChange(this)">楼面抱杆


                </td>
            </tr>
            <tr>
                <th>系统数量1</th>
                <td>
                    <input type="radio" name="sysNum1" id="sysNum1" value="0"
                           @if(isset($telecomOrder->sys_num1) && $telecomOrder->sys_num1=="0") checked="checked"@endif>0
                    <input type="radio" name="sysNum1" id="sysNum1" value="1"
                           @if(isset($telecomOrder->sys_num1) && $telecomOrder->sys_num1=="1") checked="checked"@endif>1
                    <input type="radio" name="sysNum1" id="sysNum1" value="0.1"
                           @if(isset($telecomOrder->sys_num1) && $telecomOrder->sys_num1=="0.1") checked="checked"@endif>0.1
                    <input type="radio" name="sysNum1" id="sysNum1" value="0.2"
                           @if(isset($telecomOrder->sys_num1) && $telecomOrder->sys_num1=="0.2") checked="checked"
                            @endif>0.2
                    <input type="radio" name="sysNum1" id="sysNum1" value="0.3"
                           @if(isset($telecomOrder->sys_num1) && $telecomOrder->sys_num1=="0.3") checked="checked"
                            @endif>0.3
                    <input type="radio" name="sysNum1" id="sysNum1" value="0.4"
                           @if(isset($telecomOrder->sys_num1) && $telecomOrder->sys_num1=="0.4") checked="checked"
                            @endif>0.4
                    <input type="radio" name="sysNum1" id="sysNum1" value="0.6"
                           @if(isset($telecomOrder->sys_num1) && $telecomOrder->sys_num1=="0.6") checked="checked"
                            @endif>0.6
                    <input type="radio" name="sysNum1" id="sysNum1" value="0.9"
                           @if(isset($telecomOrder->sys_num1) && $telecomOrder->sys_num1=="0.9") checked="checked"
                            @endif>0.9
                    <input type="radio" name="sysNum1" id="sysNum1" value="1.1"
                           @if(isset($telecomOrder->sys_num1) && $telecomOrder->sys_num1=="1.1") checked="checked"
                            @endif>1.1
                    <input type="radio" name="sysNum1" id="sysNum1" value="1.3"
                           @if(isset($telecomOrder->sys_num1) && $telecomOrder->sys_num1=="1.3") checked="checked"
                            @endif>1.3

                </td>
            </tr>
            <tr>
                <th>
                    系统1挂高(m):
                </th>
                <td>
                    <input type="radio" name="sysHeight1" value="无"
                           @if($telecomOrder->sys1_height == null) checked="checked"@endif>无
                    <input type="radio" name="sysHeight1" value="H<20"
                           @if(transSysHeight($telecomOrder->sys1_height) == 'H<20') checked="checked"@endif>H<20
                    <input type="radio" name="sysHeight1" id="h2" value="20<=H<25"
                           @if(transSysHeight($telecomOrder->sys1_height) == '20<=H<25') checked="checked"@endif>20<=H<25
                    <input type="radio" name="sysHeight1" value="25<=H<30"
                           @if(transSysHeight($telecomOrder->sys1_height) == '25<=H<30') checked="checked"@endif>25<=H<30
                    <input type="radio" name="sysHeight1" value="H<30"
                           @if(transSysHeight($telecomOrder->sys1_height) == 'H<30') checked="checked"@endif>H<30
                    <input type="radio" name="sysHeight1" value="30<=H<35"
                           @if(transSysHeight($telecomOrder->sys1_height) == '30<=H<35') checked="checked"@endif>30<=H<35
                    <input type="radio" name="sysHeight1" value="35<=H<40"
                           @if(transSysHeight($telecomOrder->sys1_height) == '35<=H<40') checked="checked"@endif>35<=H<40
                    <input type="radio" name="sysHeight1" value="40<=H<45"
                           @if(transSysHeight($telecomOrder->sys1_height) == '40<=H<45') checked="checked"@endif>40<=H<45
                    <input type="radio" name="sysHeight1" value="45<=H<50"
                           @if(transSysHeight($telecomOrder->sys1_height) == '45<=H<50') checked="checked"@endif>45<=H<50
                    <input type="radio" name="sysHeight1" value="任意高度"
                           @if(transSysHeight($telecomOrder->sys1_height) == '任意高度') checked="checked"@endif>任意高度
                </td>
            </tr>
            <tr>
                <th>系统数量2</th>
                <td>
                    <input type="radio" name="sysNum2" id="sysNum2" value="0"
                           @if(isset($telecomOrder->sys_num2) && $telecomOrder->sys_num2=="0") checked="checked"@endif>0
                    <input type="radio" name="sysNum2" id="sysNum2" value="1"
                           @if(isset($telecomOrder->sys_num2) && $telecomOrder->sys_num2=="1") checked="checked"@endif>1
                    <input type="radio" name="sysNum2" id="sysNum2" value="0.1"
                           @if(isset($telecomOrder->sys_num2) && $telecomOrder->sys_num2=="0.1") checked="checked"@endif>0.1
                    <input type="radio" name="sysNum2" id="sysNum2" value="0.2"
                           @if(isset($telecomOrder->sys_num2) && $telecomOrder->sys_num2=="0.2") checked="checked"
                            @endif>0.2
                    <input type="radio" name="sysNum2" id="sysNum2" value="0.3"
                           @if(isset($telecomOrder->sys_num2) && $telecomOrder->sys_num2=="0.3") checked="checked"
                            @endif>0.3
                    <input type="radio" name="sysNum2" id="sysNum2" value="0.4"
                           @if(isset($telecomOrder->sys_num2) && $telecomOrder->sys_num2=="0.4") checked="checked"
                            @endif>0.4
                    <input type="radio" name="sysNum2" id="sysNum2" value="0.6"
                           @if(isset($telecomOrder->sys_num2) && $telecomOrder->sys_num2=="0.6") checked="checked"
                            @endif>0.6
                    <input type="radio" name="sysNum2" id="sysNum2" value="0.9"
                           @if(isset($telecomOrder->sys_num2) && $telecomOrder->sys_num2=="0.9") checked="checked"
                            @endif>0.9
                    <input type="radio" name="sysNum2" id="sysNum2" value="1.1"
                           @if(isset($telecomOrder->sys_num2) && $telecomOrder->sys_num2=="1.1") checked="checked"
                            @endif>1.1
                    <input type="radio" name="sysNum2" id="sysNum2" value="1.3"
                           @if(isset($telecomOrder->sys_num2) && $telecomOrder->sys_num2=="1.3") checked="checked"
                            @endif>1.3

                </td>
            </tr>
            <tr>
                <th>
                    系统2挂高(m):
                </th>
                <td>
                    <input type="radio" name="sysHeight2" value="无"
                           @if($telecomOrder->sys2_height == null) checked="checked"@endif>无
                    <input type="radio" name="sysHeight2" value="H<20"
                           @if(transSysHeight($telecomOrder->sys2_height) == 'H<20') checked="checked"@endif>H<20
                    <input type="radio" name="sysHeight2" id="h2" value="20<=H<25"
                           @if(transSysHeight($telecomOrder->sys2_height) == '20<=H<25') checked="checked"@endif>20<=H<25
                    <input type="radio" name="sysHeight2" value="25<=H<30"
                           @if(transSysHeight($telecomOrder->sys2_height) == '25<=H<30') checked="checked"@endif>25<=H<30
                    <input type="radio" name="sysHeight2" value="H<30"
                           @if(transSysHeight($telecomOrder->sys2_height) == 'H<30') checked="checked"@endif>H<30
                    <input type="radio" name="sysHeight2" value="30<=H<35"
                           @if(transSysHeight($telecomOrder->sys2_height) == '30<=H<35') checked="checked"@endif>30<=H<35
                    <input type="radio" name="sysHeight2" value="35<=H<40"
                           @if(transSysHeight($telecomOrder->sys2_height) == '35<=H<40') checked="checked"@endif>35<=H<40
                    <input type="radio" name="sysHeight2" value="40<=H<45"
                           @if(transSysHeight($telecomOrder->sys2_height) == '40<=H<45') checked="checked"@endif>40<=H<45
                    <input type="radio" name="sysHeight2" value="45<=H<50"
                           @if(transSysHeight($telecomOrder->sys2_height) == '45<=H<50') checked="checked"@endif>45<=H<50
                    <input type="radio" name="sysHeight2" value="任意高度"
                           @if(transSysHeight($telecomOrder->sys2_height) == '任意高度') checked="checked"@endif>任意高度
                </td>
            </tr>
            <tr>
                <th>系统数量3</th>
                <td>
                    <input type="radio" name="sysNum3" id="sysNum3" value="0"
                           @if(isset($telecomOrder->sys_num3) && $telecomOrder->sys_num3=="0") checked="checked"@endif>0
                    <input type="radio" name="sysNum3" id="sysNum3" value="1"
                           @if(isset($telecomOrder->sys_num3) && $telecomOrder->sys_num3=="1") checked="checked"@endif>1
                    <input type="radio" name="sysNum3" id="sysNum3" value="0.1"
                           @if(isset($telecomOrder->sys_num3) && $telecomOrder->sys_num3=="0.1") checked="checked"@endif>0.1
                    <input type="radio" name="sysNum3" id="sysNum3" value="0.2"
                           @if(isset($telecomOrder->sys_num3) && $telecomOrder->sys_num3=="0.2") checked="checked"
                            @endif>0.2
                    <input type="radio" name="sysNum3" id="sysNum3" value="0.3"
                           @if(isset($telecomOrder->sys_num3) && $telecomOrder->sys_num3=="0.3") checked="checked"
                            @endif>0.3
                    <input type="radio" name="sysNum3" id="sysNum3" value="0.4"
                           @if(isset($telecomOrder->sys_num3) && $telecomOrder->sys_num3=="0.4") checked="checked"
                            @endif>0.4
                    <input type="radio" name="sysNum3" id="sysNum3" value="0.6"
                           @if(isset($telecomOrder->sys_num3) && $telecomOrder->sys_num3=="0.6") checked="checked"
                            @endif>0.6
                    <input type="radio" name="sysNum3" id="sysNum3" value="0.9"
                           @if(isset($telecomOrder->sys_num3) && $telecomOrder->sys_num3=="0.9") checked="checked"
                            @endif>0.9
                    <input type="radio" name="sysNum3" id="sysNum3" value="1.1"
                           @if(isset($telecomOrder->sys_num3) && $telecomOrder->sys_num3=="1.1") checked="checked"
                            @endif>1.1
                    <input type="radio" name="sysNum3" id="sysNum3" value="1.3"
                           @if(isset($telecomOrder->sys_num3) && $telecomOrder->sys_num3=="1.3") checked="checked"
                            @endif>1.3

                </td>
            </tr>
            <tr>
                <th>
                    系统3挂高(m):
                </th>
                <td>
                    <input type="radio" name="sysHeight3" value="无"
                           @if($telecomOrder->sys3_height == null) checked="checked"@endif>无
                    <input type="radio" name="sysHeight3" value="H<20"
                           @if(transSysHeight($telecomOrder->sys3_height) == 'H<20') checked="checked"@endif>H<20
                    <input type="radio" name="sysHeight3" id="h2" value="20<=H<25"
                           @if(transSysHeight($telecomOrder->sys3_height) == '20<=H<25') checked="checked"@endif>20<=H<25
                    <input type="radio" name="sysHeight3" value="25<=H<30"
                           @if(transSysHeight($telecomOrder->sys3_height) == '25<=H<30') checked="checked"@endif>25<=H<30
                    <input type="radio" name="sysHeight3" value="H<30"
                           @if(transSysHeight($telecomOrder->sys3_height) == 'H<30') checked="checked"@endif>H<30
                    <input type="radio" name="sysHeight3" value="30<=H<35"
                           @if(transSysHeight($telecomOrder->sys3_height) == '30<=H<35') checked="checked"@endif>30<=H<35
                    <input type="radio" name="sysHeight3" value="35<=H<40"
                           @if(transSysHeight($telecomOrder->sys3_height) == '35<=H<40') checked="checked"@endif>35<=H<40
                    <input type="radio" name="sysHeight3" value="40<=H<45"
                           @if(transSysHeight($telecomOrder->sys3_height) == '40<=H<45') checked="checked"@endif>40<=H<45
                    <input type="radio" name="sysHeight3" value="45<=H<50"
                           @if(transSysHeight($telecomOrder->sys3_height) == '45<=H<50') checked="checked"@endif>45<=H<50
                    <input type="radio" name="sysHeight3" value="任意高度"
                           @if(transSysHeight($telecomOrder->sys3_height) == '任意高度') checked="checked"@endif>任意高度
                </td>
            </tr>

            <tr>
                <th>
                    覆盖场景:
                </th>
                <td>
                    <input type="radio" name="landForm" id="landForm" value="山区"
                           @if(isset($telecomOrder->land_form) && transLandForm($telecomOrder->land_form) =="山区") checked="checked"@endif>山区
                    <input type="radio" name="landForm" id="landForm" value="平原"
                           @if(isset($telecomOrder->land_form) && transLandForm($telecomOrder->land_form) =="平原") checked="checked"@endif>平原


                </td>
            </tr>
            <tr>
                <th>
                    用户类型:
                </th>
                <td>
                    @if(transIsNewTower($telecomOrder->is_new_tower)  == '是')
                        <div id="userType1" style="float: left;"><input type="radio" name="userType" id="userType_old"
                                                                        value="锚定用户"
                                                                        @if(transUserType($telecomOrder->user_type) =="锚定用户") checked="checked" @endif>锚定用户
                        </div>@endif
                    @if(transIsNewTower($telecomOrder->is_new_tower) == '否')
                        <div id="userType2" style="float: left;"><input type="radio" name="userType" value="原产权"
                                                                        @if(transUserType($telecomOrder->user_type)=="原产权") checked="checked"@endif>原产权
                        </div>@endif
                    @if(transIsNewTower($telecomOrder->is_new_tower) == '是')
                        <div id="userType3" style="float: left;"><input type="radio" name="userType"
                                                                        id="userType_otheruser"
                                                                        value="其他用户"
                                                                        @if(transUserType($telecomOrder->user_type)=="其他用户") checked="checked"@endif>其他用户
                        </div>@endif
                    @if(transIsNewTower($telecomOrder->is_new_tower) == '否')
                        <div id="userType4" style="float: left;"><input type="radio" name="userType" value="既有共享"
                                                                        @if(transUserType($telecomOrder->user_type)=="既有共享") checked="checked"@endif>既有共享
                        </div>@endif
                    @if(transIsNewTower($telecomOrder->is_new_tower) == '否')
                        <div id="userType5" style="float: left;"><input type="radio" name="userType" value="新增共享"
                                                                        @if(transUserType($telecomOrder->user_type)=="新增共享") checked="checked"@endif>新增共享
                        </div>@endif


                </td>
            </tr>
            <tr>
                <th>
                    铁塔共享类型:
                </th>
                <td>

                    <input type="radio" name="shareNumTower" id="shareNumTower" value="电信独享"
                           @if(isset($telecomOrder->share_num_tower) && transShareType($telecomOrder->share_num_tower) =="电信独享")
                           checked="checked" @endif>电信独享
                    <input type="radio" name="shareNumTower" id="shareType" value="两家共享"
                           @if(isset($telecomOrder->share_num_tower) && transShareType($telecomOrder->share_num_tower)=="两家共享")
                           checked="checked" @endif>两家共享
                    <input type="radio" name="shareNumTower" id="shareType" value="三家共享"
                           @if(isset($telecomOrder->share_num_tower) && transShareType($telecomOrder->share_num_tower)=="三家共享") checked="checked"
                            @endif>三家共享
                </td>
            </tr>
            <tr>
                <th>
                    机房共享类型:
                </th>
                <td>

                    <input type="radio" name="shareNumHouse" id="shareType" value="电信独享"
                           @if(isset($telecomOrder->share_num_house) && transShareType($telecomOrder->share_num_house) =="电信独享")
                           checked="checked" @endif>电信独享
                    <input type="radio" name="shareNumHouse" id="shareType" value="两家共享"
                           @if(isset($telecomOrder->share_num_house) && transShareType($telecomOrder->share_num_house)=="两家共享")
                           checked="checked" @endif>两家共享
                    <input type="radio" name="shareNumHouse" id="shareType" value="三家共享"
                           @if(isset($telecomOrder->share_num_house) && transShareType($telecomOrder->share_num_house)=="三家共享") checked="checked"
                            @endif>三家共享
                </td>
            </tr>
            <tr>
                <th>
                    配套共享类型:
                </th>
                <td>

                    <input type="radio" name="shareNumSupport" id="shareType" value="电信独享"
                           @if(isset($telecomOrder->share_num_support) && transShareType($telecomOrder->share_num_support) =="电信独享")
                           checked="checked" @endif>电信独享
                    <input type="radio" name="shareNumSupport" id="shareType" value="两家共享"
                           @if(isset($telecomOrder->share_num_support) && transShareType($telecomOrder->share_num_support)=="两家共享")
                           checked="checked" @endif>两家共享
                    <input type="radio" name="shareNumSupport" id="shareType" value="三家共享"
                           @if(isset($telecomOrder->share_num_support) && transShareType($telecomOrder->share_num_support)=="三家共享") checked="checked"
                            @endif>三家共享
                </td>
            </tr>
            <tr>
                <th>
                    维护共享类型:
                </th>
                <td>

                    <input type="radio" name="shareNumMaintain" id="shareType" value="电信独享"
                           @if(isset($telecomOrder->share_num_maintain) && transShareType($telecomOrder->share_num_maintain) =="电信独享")
                           checked="checked" @endif>电信独享
                    <input type="radio" name="shareNumMaintain" id="shareType" value="两家共享"
                           @if(isset($telecomOrder->share_num_maintain) && transShareType($telecomOrder->share_num_maintain)=="两家共享")
                           checked="checked" @endif>两家共享
                    <input type="radio" name="shareNumMaintain" id="shareType" value="三家共享"
                           @if(isset($telecomOrder->share_num_maintain) && transShareType($telecomOrder->share_num_maintain)=="三家共享") checked="checked"
                            @endif>三家共享
                </td>
            </tr>
            <tr>
                <th>
                    场地费共享类型:
                </th>
                <td>

                    <input type="radio" name="shareNumSite" id="shareType" value="电信独享"
                           @if(isset($telecomOrder->share_num_site) && transShareType($telecomOrder->share_num_site) =="电信独享")
                           checked="checked" @endif>电信独享
                    <input type="radio" name="shareNumSite" id="shareType" value="两家共享"
                           @if(isset($telecomOrder->share_num_site) && transShareType($telecomOrder->share_num_site)=="两家共享")
                           checked="checked" @endif>两家共享
                    <input type="radio" name="shareNumSite" id="shareType" value="三家共享"
                           @if(isset($telecomOrder->share_num_site) && transShareType($telecomOrder->share_num_site)=="三家共享") checked="checked"
                            @endif>三家共享
                </td>
            </tr>
            <tr>
                <th>
                    电力引入费共享类型:
                </th>
                <td>

                    <input type="radio" name="shareNumImport" id="shareType" value="电信独享"
                           @if(isset($telecomOrder->share_num_import) && transShareType($telecomOrder->share_num_import) =="电信独享")
                           checked="checked" @endif>电信独享
                    <input type="radio" name="shareNumImport" id="shareType" value="两家共享"
                           @if(isset($telecomOrder->share_num_import) && transShareType($telecomOrder->share_num_import)=="两家共享")
                           checked="checked" @endif>两家共享
                    <input type="radio" name="shareNumImport" id="shareType" value="三家共享"
                           @if(isset($telecomOrder->share_num_import) && transShareType($telecomOrder->share_num_import)=="三家共享") checked="checked"
                            @endif>三家共享
                </td>
            </tr>


            @if(transIsNewTower($telecomOrder->is_new_tower)  == '否')
                <tr>
                    <th>
                        是否存在新增共享:
                    </th>
                    <td>
                        <input type="radio" name="isNewlyAdded" id="isNewlyAdded" value="是"
                               @if(transIsNewlyAdded($telecomOrder->is_newly_added)  == '是') checked="checked" @endif>是
                        <input type="radio" name="isNewlyAdded" id="isNewlyAdded" value="否"
                               @if(transIsNewlyAdded($telecomOrder->is_newly_added) == '否') checked="checked" @endif>否

                    </td>
                </tr>
                {{--<tr>--}}
                {{--<th>场地费</th>--}}
                {{--<td>--}}
                {{--<input type="text" name="feeSiteOld" id="feeSiteOld" value="{{$telecomOrder->fee_site}}">--}}
                {{--</td>--}}
                {{--</tr>--}}
            @endif
            <tr>
                <th>
                    WLAN费用（元）
                </th>
                <td>
                    <input type="text" name="feeWlan" value="{{$telecomOrder->fee_wlan}}">
                </td>
            </tr>
            <tr>
                <th>
                    微波费用（元）
                </th>
                <td>
                    <input type="text" name="feeMicwav" value="{{$telecomOrder->fee_microwave}}">
                </td>
            </tr>
            <tr>
                <th>
                    微波费用（元）
                </th>
                <td>
                    <input type="text" name="feeMicwav" value="{{$telecomOrder->fee_microwave}}">
                </td>
            </tr>
            <tr>
                <th>
                    超过10%高等级服务站址额外维护服务费（元）
                </th>
                <td>
                    <input type="text" name="feeAdd" value="{{$telecomOrder->fee_add}}">
                </td>
            </tr>
            <tr>
                <th>
                    蓄电池额外保障费（元）
                </th>
                <td>
                    <input type="text" name="feeBat" value="{{$telecomOrder->fee_battery}}">
                </td>
            </tr>
            <tr>
                <th>
                    bbu安装在铁塔机房费（元）
                </th>
                <td>
                    <input type="text" name="feeBbu" value="{{$telecomOrder->fee_bbu}}">
                </td>
            </tr>


        </table>
        <input class="formButton" type="button" value="修改" onclick="doModify({{$telecomOrder->id}})">
    </form>
    <form action="{{url('backend/siteInfo/delete/'.$telecomOrder->site_code)}}" method="get" style="display:inline;"
          id="delForm">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        {{--        <input type="hidden" value="{{$filter['region']}}" name="region">--}}
        <input type="button" class="formButton" value="删除" onclick="doDel({{$telecomOrder->id}})">
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

        function doModify(id) {
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
                var form = document.getElementById('listForm');
                var url = "{{url('backend/servBill/billCheck/orders/update')}}" + '/' + id;
                form.action = url;
                form.submit();
            }


        }

        function doDel(id) {
            if (confirm('确认删除吗？')) {
                var form = document.getElementById('delForm');
                var url = "{{url('backend/servBill/billCheck/orders/delete')}}" + '/' + id;
                form.action = url;
                form.submit();
            }

        }



    </script>
@endsection







