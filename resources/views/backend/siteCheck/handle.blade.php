@extends('layouts.app')

@section('header')
    <title>上站结果填报</title>
@endsection

@section('content')
    <div class="container" style="width:100% ">
        <div class="row clearfix">
            <div class="col-md-12 column" style="padding: 0">
                <ul class="nav nav-tabs" style="font-size: 13px">
                    <li class="inactive">
                        <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">站址信息管理</a>
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/gnrRec?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">发电记录管理</a>
                    </li>
                    <li class="active">
                        <a href="{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">上站记录管理</a>
                    </li>
                    <li class="inactive">
                        @if(Auth::user()->area_level == '湖北省')                             <a href="{{url('backend/siteShield/checkShieldPage?region=').Auth::user()->area_level.'&checkStatus=2&reqType=0&beginDate=&endDate='}}">屏蔽记录管理</a>@endif                         @if(Auth::user()->area_level != '湖北省')                             <a href="{{url('backend/siteShield/addShieldPage')}}">屏蔽记录管理</a>@endif
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/osReasonFill?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">退服原因管理</a>
                    </li>
                </ul>
                <ul class="nav-tabs-2">
                    <li class="active">
                        <a href="{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">上站记录查询</a>
                    </li>
                    <li class="inactive" style="float: none">
                        <a href="{{url('backend/siteCheck/addPage')}}">上站申请填报</a>
                    </li>

                </ul>
                <ul class="breadcrumb" style="margin-bottom: 0;background-color: #F5F5F5">
                    当前位置：
                    <li>
                        <a href="{{url('backend/siteInfo?region=') . Auth::user()->area_level}}">业务管理</a>
                    </li>
                    <li>
                        <a href="{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}">上站记录管理</a>
                    </li>
                    <li class="active">
                        <a href="#">上站结果填报</a>
                    </li>
                </ul>


            </div>
        </div>

    </div>

    <body class="input managerInfo">
    <div class="bar">
        <div style="float:left;">
            请填报上站结果
        </div>

    </div>
    <div id="validateErrorContainer" class="validateErrorContainer">

    </div>

    <form id="listForm" method="POST" action="{{url('backend/siteCheck/handle')}}" style="display: inline;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{ $siteCheck[0]->id }}">
        <input type="hidden" name="region" value="{{$filter['region']}}">
        <input type="hidden" name="beginDate" value="{{$filter['beginDate']}}">
        <input type="hidden" name="endDate" value="{{$filter['endDate']}}">
        <input type="hidden" name="checkStatus" value="{{$filter['checkStatus']}}">
        <table class="inputTable tabContent">
            <tr>
                <th>地市</th>
                <td>{{$siteCheck[0]->region_name}}</td>
            </tr>
            <tr>
                <th>站址编码</th>
                <td>{{$siteCheck[0]->site_code}}</td>
            </tr>
            <tr>
                <th>上站申请时间</th>
                <td>{{$siteCheck[0]->check_req_time}}</td>
            </tr>
            <tr>
                <th>上站类型</th>
                <td>{{$siteCheck[0]->check_type}}</td>
            </tr>
           <tr>
               <th>上站结果</th>
               <td>
                   <input type="radio" name="checkResult" value="成功" checked="checked">成功
                   <input type="radio" name="checkResult" value="失败">失败
               </td>
           </tr>
        </table>
        <input class="formButton" type="button" value="提交" onclick="doHandle()">
    </form>
    {{--<form action="" method="get" style="display:inline;"--}}
          {{--id="delForm">--}}
        {{--{{ method_field('DELETE') }}--}}
        {{--{{ csrf_field() }}--}}
        {{--<input type="hidden" value="{{$region}}" name="region">--}}
        {{--<input type="button" class="formButton" value="删除" onclick="doDel()">--}}
    {{--</form>--}}
    <input type="button" class="formButton" value="返回" onclick="doBack()">
    </body>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {
            var menu_business = document.getElementById('menu_business');
            menu_business.className = "current";
        });

        function doBack() {
            var listForm = document.getElementById('listForm');
            listForm.action = "{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}";
            listForm.submit();
        }

        function doSiteCheckPage() {
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}";
            listForm.submit();
        }

        function doShieldPage() {
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/siteShield')}}";
            listForm.submit();
        }

        function doTysysPage() {
            var listForm = document.getElementById("listForm");
            listForm.action = "{{url('backend/osReasonFill?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}";
            listForm.submit();
        }

        function doHandle(){
            if (confirm('确认提交吗？')){
                var listForm = document.getElementById("listForm");
                listForm.submit();
            }

        }

        function doModify() {
            var siteCode = $('#siteCode').val();
            var modifyTime = $('#modifyTime').val();
            var towerType = document.getElementById('towerType');
            var sysNum = document.getElementsByName('sysNum');
            var sysHeight1 = document.getElementsByName('sysHeight1');
            var sysHeight2 = document.getElementsByName('sysHeight2');
            var sysHeight3 = document.getElementsByName('sysHeight3');
            var sysHeight4 = document.getElementsByName('sysHeight4');
            var sysHeight5 = document.getElementsByName('sysHeight5');
            for (var i = 0; i < sysNum.length; i++){
                if(sysNum[i].checked){
                    var sys_Num = sysNum[i].value;
                }
            }
            for (var i = 0; i < sysHeight1.length; i++){
                if(sysHeight1[i].checked){
                    var sysHeight_1 = sysHeight1[i].value;
                }
            }
            for (var i = 0; i < sysHeight2.length; i++){
                if(sysHeight2[i].checked){
                    var sysHeight_2 = sysHeight2[i].value;
                }
            }
            for (var i = 0; i < sysHeight3.length; i++){
                if(sysHeight3[i].checked){
                    var sysHeight_3 = sysHeight3[i].value;
                }
            }
            for (var i = 0; i < sysHeight4.length; i++){
                if(sysHeight4[i].checked){
                    var sysHeight_4 = sysHeight4[i].value;
                }
            }
            for (var i = 0; i < sysHeight5.length; i++){
                if(sysHeight5[i].checked){
                    var sysHeight_5 = sysHeight5[i].value;
                }
            }


            if(modifyTime == ''){
                alert('请输入属性变更日期！');
                return;
            }
            if(sys_Num == '1'){
                if (sysHeight_1 == '无'){
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
            if(sys_Num == '2'){
                if (sysHeight_1 == '无'){
                    alert('请选择系统1的挂高！');
                    return;
                }
                if (sysHeight_2 == '无'){
                    alert('请选择系统2的挂高！');
                    return;
                }
            }
            if(sys_Num == '3'){
                if (sysHeight_1 == '无'){
                    alert('请选择系统1的挂高！');
                    return;
                }
                if (sysHeight_2 == '无'){
                    alert('请选择系统2的挂高！');
                    return;
                }
                if (sysHeight_3 == '无'){
                    alert('请选择系统3的挂高！');
                    return;
                }
            }
            if(sys_Num == '4'){
                if (sysHeight_1 == '无'){
                    alert('请选择系统1的挂高！');
                    return;
                }
                if (sysHeight_2 == '无'){
                    alert('请选择系统2的挂高！');
                    return;
                }
                if (sysHeight_3 == '无'){
                    alert('请选择系统3的挂高！');
                    return;
                }
                if (sysHeight_4 == '无'){
                    alert('请选择系统4的挂高！');
                    return;
                }
            }
            if(sys_Num == '5'){
                if (sysHeight_1 == '无'){
                    alert('请选择系统1的挂高！');
                    return;
                }
                if (sysHeight_2 == '无'){
                    alert('请选择系统2的挂高！');
                    return;
                }
                if (sysHeight_3 == '无'){
                    alert('请选择系统3的挂高！');
                    return;
                }
                if (sysHeight_4 == '无'){
                    alert('请选择系统4的挂高！');
                    return;
                }
                if (sysHeight_5 == '无'){
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







