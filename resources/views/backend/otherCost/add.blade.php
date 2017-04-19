@extends('layouts.app')

@section('header')
    <title>站址信息新增</title>
@endsection

@section('content')
    <div class="bar" style="font-weight:bold;">

        <a href="javascript:;" onclick="doBack()">其他费用填报</a>
        <td>>>></td>
        <a href="#">新增费用</a>
    </div>

    <form id="listForm" method="post" action="{{url('backend/otherCost/add')}}" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <input name="region" type="hidden" value="{{$region}}">
        <div class="input managerInfo">
            <table class="inputTable tabContent">
                <tr>
                    <th>站址编码</th>
                    <td>
                        <input type="text" id="siteCode" name="siteCode">
                    </td>
                </tr>
                <tr>
                    <th>
                        地市 :
                    </th>
                    <td>
                        @if(Auth::user()->area_level != '湖北省' && Auth::user()->area_level != 'admin')
                            <select name="regionName" id="region">
                                @if(Auth::user()->area_level == '武汉'))
                                <option>武汉</option>@endif
                                @if(Auth::user()->area_level == '黄石'))
                                <option>黄石</option>@endif
                                @if(Auth::user()->area_level == '十堰'))
                                <option>十堰</option>@endif
                                @if(Auth::user()->area_level == '宜昌'))
                                <option>宜昌</option>@endif
                                @if(Auth::user()->area_level == '襄阳'))
                                <option>襄阳</option>@endif
                                @if(Auth::user()->area_level == '鄂州'))
                                <option>鄂州</option>@endif
                                @if(Auth::user()->area_level == '荆门'))
                                <option>荆门</option>@endif
                                @if(Auth::user()->area_level == '孝感'))
                                <option>孝感</option>@endif
                                @if(Auth::user()->area_level == '荆州'))
                                <option>荆州</option>@endif
                                @if(Auth::user()->area_level == '黄冈'))
                                <option>黄冈</option>@endif
                                @if(Auth::user()->area_level == '咸宁'))
                                <option>咸宁</option>@endif
                                @if(Auth::user()->area_level == '随州'))
                                <option>随州</option>@endif
                                @if(Auth::user()->area_level == '恩施'))
                                <option>恩施</option>@endif
                                @if(Auth::user()->area_level == '仙桃'))
                                <option>仙桃</option>@endif
                                @if(Auth::user()->area_level == '潜江'))
                                <option>潜江</option>@endif
                                @if(Auth::user()->area_level == '天门'))
                                <option>天门</option>@endif
                                @if(Auth::user()->area_level == '林区'))
                                <option>林区</option>@endif
                            </select>
                        @endif
                        @if(Auth::user()->area_level == '湖北省' || Auth::user()->area_level == 'admin')
                            <select name="regionName" id="region">
                                <option>武汉</option>
                                <option>黄石</option>
                                <option>十堰</option>
                                <option>宜昌</option>
                                <option>襄阳</option>
                                <option>鄂州</option>
                                <option>荆门</option>
                                <option>孝感</option>
                                <option>荆州</option>
                                <option>黄冈</option>
                                <option>咸宁</option>
                                <option>随州</option>
                                <option>恩施</option>
                                <option>仙桃</option>
                                <option>潜江</option>
                                <option>天门</option>
                                <option>林区</option>
                            </select>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>wlan费用(元/月)</th>
                    <td>
                        <input type="text" id="feeWlan" name="feeWlan" value="0.00">
                    </td>
                </tr>
                <tr>
                    <th>微波费用(元/月)</th>
                    <td>
                        <input type="text" id="feeMicwav" name="feeMicwav" value="0.00">
                    </td>
                </tr>
                <tr>
                    <th>超过10%高等级服务站址额外维护服务费(元/月)</th>
                    <td>
                        <input type="text" id="feeAdd" name="feeAdd" value="0.00">
                    </td>
                </tr>
                <tr>
                    <th>蓄电池额外保障费(元/月)</th>
                    <td>
                        <input type="text" id="feeBat" name="feeBat" value="0.00">
                    </td>
                </tr>
                <tr>
                    <th>bbu安装在铁塔机房费(元/月)</th>
                    <td>
                        <input type="text" id="feeBbu" name="feeBbu" value="0.00">
                    </td>
                </tr>

            </table>
            <input type="button" value="提交" class="formButton" onclick="doAdd()"/>
            <input type="button" value="返回" class="formButton" onclick="doBack()"/>
        </div>
    </form>
    </body>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {
            $('#menu_business').addClass("current");
        });

        function doAdd(){
            var siteCode = $('#siteCode').val();
            if (siteCode == ''){
                alert('请输入站址编码！');
                return;
            }
            if(confirm('确认提交吗？')){
                var form = document.getElementById('listForm');
                form.action = "{{url('backend/otherCost/add')}}";
                form.submit();
            }

        }

        function doBack(){
            var form = document.getElementById('listForm');
            form.action = "{{url('backend/otherCost/back')}}";
            form.submit();
        }


    </script>
@endsection







