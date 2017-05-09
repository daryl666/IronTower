@extends('layouts.app')

@section('header')
<title>站址信息列表</title>
@endsection

@section('script_header')
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function (event) {
    var addBtn = document.getElementById("addBtn");
    var region = $('#region').val();
    addBtn.addEventListener('click', function () {
        var listForm = document.getElementById("listForm");
        var url = "{{url('backend/siteInfo/addNewPage')}}" + '/' + region;
        listForm.action = url;

    });
});
</script>
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
                <li class="inactive" style="float: none">
                    <a href="{{url('backend/siteStats/')}}">站址统计</a>
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
                    <a href="#">站址信息查询</a>
                </li>
            </ul>


        </div>
    </div>

</div>




<div class="list">
    <div class="body">
        <form id="listForm" method="post" action="{{url('backend/siteInfo/')}}" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="listBar">
                <td>
                    请选择地市或者站址编码来查看站址信息：
                </td>
                <td>
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
    &nbsp;&nbsp;&nbsp;站址编码：
    <input type="text" name="siteCode" @if(isset($filter['siteCode'])) value="{{$filter['siteCode']}}" @endif>
</td>


<td>
    &nbsp;&nbsp;&nbsp;
    <input type="button" id="viewBtn" class="formButton" value="查询" hidefocus onclick="doSearch()"/>
</td>

{{--<td style="float:left;margin-right:30px;">--}}
{{--<input type="submit" class="formButton" value="新增站址" id="addBtn" style="float: right;"/>--}}
{{--</td>--}}

<td>
    <input type="button" class="formButton" value="导出" onclick="doExport()"
    @if(isset($infoSites)) style="display: inline;" @endif style="display: none;"/>
</td>

</div>
</form>
</div>
<div id="siteInfo">
    <table class="listTable" style="white-space:nowrap;font-size:12px;">

        <tr>
            @if(Auth::user()->site_modify == 1)
            <th>
                <a href="#" class="sort" name="" hidefocus>操作</a>
            </th>
            @endif
            <th>
                <a href="#" class="sort" name="" hidefocus>站址编码</a>
            </th>
            <th>
                <a href="#" class="sort" name="" hidefocus>站址名称</a>
            </th>
            <th>
                <a href="#" class="sort" name="" hidefocus>服务起始日期</a>
            </th>
            <th>
                <a href="#" class="sort" name="" hidefocus>地市</a>
            </th>
            @if(Auth::user()->site_view_advance == 1)
            <th class="scanStopTime">
                <a href="#" class="sort" name="" hidefocus>铁塔类型</a>
            </th>
            <th class="scanStopTime">
                <a href="#" class="sort" name="" hidefocus>是否为新建站</a>
            </th>
            <th>
                <a href="#" class="sort" name="" hidefocus>产品配套类型</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>是否为竞合站点</a>
            </th>
            <th class="scanStopTime">
                <a href="#" class="sort" name="" hidefocus>是否存在新增共享</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>用户类型</a>
            </th>
            <th class="gp">
                <a href="#" class="sort" name="" hidefocus>覆盖场景</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>铁塔共享类型</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>铁塔基准价格（元/月）（折扣前）</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>铁塔共享折扣</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>铁塔基准价格（元/月）（折扣后）</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>机房共享类型</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>机房基准价格（元/月）（折扣前）</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>机房共享折扣</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>机房基准价格（元/月）（折扣后）</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>配套共享类型</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>配套基准价格（元/月）（折扣前）</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>配套机房共享折扣</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>配套基准价格（元/月）（折扣后）</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>维护费共享类型</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>维护费基准价格（元/月）（折扣前）</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>维护费共享折扣</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>维护费基准价格（元/月）（折扣后）</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>场地费共享类型</a>
            </th>

            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>场地费（元/月）（折扣前）</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>场地费共享折扣</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>场地费（元/月）（折扣后）</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>电力引入费共享类型</a>
            </th>

            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>电力引入费（元/月）（折扣前）</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>电力引入费共享折扣</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>电力引入费（元/月）（折扣后）</a>
            </th>

            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>WLAN费用(元)</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>微波费用(元)</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>超过10%高等级服务站址额外维护服务费(元)</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>蓄电池额外保障费(元)</a>
            </th>
            <th class="freqMode">
                <a href="#" class="sort" name="" hidefocus>bbu安装在铁塔机房费(元)</a>
            </th>
            @endif
        </tr>
        @if(isset($infoSites))
        @foreach($infoSites as $infoSite)
        <tr>
            @if(Auth::user()->site_modify == 1)
            <td>
                <button class="buttonNextStep" onclick="doEditPage({{$infoSite->id}})">编辑</button>
            </td>
            @endif
            <td>{{$infoSite->site_code}}</td>
            <td>{{$infoSite->site_name}}</td>
            <td>{{$infoSite->established_time}}</td>
            <td>{{$infoSite->region_name}}</td>
            @if(Auth::user()->site_view_advance)
            <td>{{transTowerType($infoSite->tower_type) }}</td>
            <td>{{transIsNewTower($infoSite->is_new_tower) }}</td>
            <td>{{transProductType($infoSite->product_type) }}</td>
            <td>{{transIsCoOpetition($infoSite->is_co_opetition) }}</td>
            <td>{{transIsNewlyAdded($infoSite->is_newly_added) }}</td>
            <td>{{transUserType($infoSite->user_type) }}</td>
            <td>{{transLandForm($infoSite->land_form) }}</td>
            <td>{{transShareType($infoSite->share_num_tower) }}</td>
            <td>{{$infoSite->fee_tower}}</td>
            <td>{{$infoSite->tower_share_discount}}</td>
            <td>{{$infoSite->fee_tower_discounted}}</td>

            <td>{{transShareType($infoSite->share_num_house) }}</td>
            <td>{{$infoSite->fee_house}}</td>
            <td>{{$infoSite->house_share_discount}}</td>
            <td>{{$infoSite->fee_house_discounted}}</td>

            <td>{{transShareType($infoSite->share_num_support) }}</td>
            <td>{{$infoSite->fee_support}}</td>
            <td>{{$infoSite->support_share_discount}}</td>
            <td>{{$infoSite->fee_support_discounted}}</td>

            <td>{{transShareType($infoSite->share_num_maintain) }}</td>
            <td>{{$infoSite->fee_maintain}}</td>
            <td>{{$infoSite->maintain_share_discount}}</td>
            <td>{{$infoSite->fee_maintain_discounted}}</td>

            <td>{{transShareType($infoSite->share_num_site) }}</td>
            <td>{{$infoSite->fee_site}}</td>
            <td>{{$infoSite->site_share_discount}}</td>
            <td>{{$infoSite->fee_site_discounted}}</td>

            <td>{{transShareType($infoSite->share_num_import) }}</td>
            <td>{{$infoSite->fee_import}}</td>
            <td>{{$infoSite->import_share_discount}}</td>
            <td>{{$infoSite->fee_import_discounted}}</td>

            <td>{{$infoSite->fee_wlan}}</td>
            <td>{{$infoSite->fee_microwave}}</td>
            <td>{{$infoSite->fee_add}}</td>
            <td>{{$infoSite->fee_battery}}</td>
            <td>{{$infoSite->fee_bbu}}</td>
            @endif    

        </tr>
        @endforeach
        @if(isset($filter))
        {!! $infoSites->appends(['region' => $filter['region']])->render() !!}@endif
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
    var listForm = document.getElementById("listForm");
    var region = document.getElementById('region');
    var url = "{{url('backend/siteInfo?region=')}}" + region;
    listForm.method = "GET";
    listForm.action = url;
    listForm.submit();
}

function doExport() {
    var listForm = document.getElementById("listForm");
    listForm.action = "{{url('backend/siteInfo/export')}}";
    listForm.submit();
}

function doImport() {
    var siteInfoFile = document.getElementById('siteInfoFile');
    if (siteInfoFile.value == "") {
        alert('请选择需要导入的文件');
        return;
    }
    var listForm = document.getElementById("listForm");
    listForm.action = "{{url('backend/siteInfo/import')}}";
    listForm.submit();
}

function doEditPage(id) {
    var region = $('#region').val();
    var listForm = document.getElementById('listForm');
    url = "{{url('backend/siteInfo/editPage')}}" + '/' + id;
    listForm.action = url;
    listForm.submit();
}


</script>
@endsection