@extends('layouts.app')

@section('header')
    <title>站址信息新增</title>
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
                        <li class="inactive">
                            <a href="{{url('backend/servCost')}}">服务费用填报</a>
                        </li>
                        <li class="inactive">
                            <a href="{{url('backend/gnrRec')}}">发电记录填报</a>
                        </li>
                        <li class="active">
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
        <form id="listForm" method="post" action="{{url('backend/otherCost/')}}" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="listBar">
                <td>
                    请选择地市来查看站址其他费用：
                </td>
                <td>
                    @if(Auth::user()->area_level == '湖北省' || Auth::user()->area_level == 'admin')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='湖北省') selected="selected" @endif value="湖北省">湖北省</option>
                            <option @if(isset($filter['region']) && $filter['region']=='武汉') selected="selected" @endif value="武汉">武汉</option>
                            <option @if(isset($filter['region']) && $filter['region']=='黄石') selected="selected" @endif value="黄石">黄石</option>
                            <option @if(isset($filter['region']) && $filter['region']=='十堰') selected="selected" @endif value="十堰">十堰</option>
                            <option @if(isset($filter['region']) && $filter['region']=='宜昌') selected="selected" @endif value="宜昌">宜昌</option>
                            <option @if(isset($filter['region']) && $filter['region']=='襄阳') selected="selected" @endif value="襄阳">襄阳</option>
                            <option @if(isset($filter['region']) && $filter['region']=='鄂州') selected="selected" @endif value="鄂州">鄂州</option>
                            <option @if(isset($filter['region']) && $filter['region']=='荆门') selected="selected" @endif value="荆门">荆门</option>
                            <option @if(isset($filter['region']) && $filter['region']=='孝感') selected="selected" @endif value="孝感">孝感</option>
                            <option @if(isset($filter['region']) && $filter['region']=='荆州') selected="selected" @endif value="荆州">荆州</option>
                            <option @if(isset($filter['region']) && $filter['region']=='黄冈') selected="selected" @endif value="黄冈">黄冈</option>
                            <option @if(isset($filter['region']) && $filter['region']=='咸宁') selected="selected" @endif value="咸宁">咸宁</option>
                            <option @if(isset($filter['region']) && $filter['region']=='随州') selected="selected" @endif value="随州">随州</option>
                            <option @if(isset($filter['region']) && $filter['region']=='恩施') selected="selected" @endif value="恩施">恩施</option>
                            <option @if(isset($filter['region']) && $filter['region']=='仙桃') selected="selected" @endif value="仙桃">仙桃</option>
                            <option @if(isset($filter['region']) && $filter['region']=='潜江') selected="selected" @endif value="潜江">潜江</option>
                            <option @if(isset($filter['region']) && $filter['region']=='天门') selected="selected" @endif value="天门">天门</option>
                            <option @if(isset($filter['region']) && $filter['region']=='林区') selected="selected" @endif value="林区">林区</option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '武汉')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='武汉') selected="selected" @endif value="武汉">武汉</option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '黄石')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='黄石') selected="selected" @endif value="黄石">黄石</option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '十堰')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='十堰') selected="selected" @endif value="十堰">十堰</option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '宜昌')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='宜昌') selected="selected" @endif value="宜昌">宜昌</option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '襄阳')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='襄阳') selected="selected" @endif value="襄阳">襄阳</option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '鄂州')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='鄂州') selected="selected" @endif value="鄂州">鄂州</option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '荆门')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='荆门') selected="selected" @endif value="荆门">荆门</option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '孝感')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='孝感') selected="selected" @endif value="孝感">孝感</option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '荆州')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='荆州') selected="selected" @endif value="荆州">荆州</option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '黄冈')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='黄冈') selected="selected" @endif value="黄冈">黄冈</option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '咸宁')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='咸宁') selected="selected" @endif value="咸宁">咸宁</option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '随州')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='随州') selected="selected" @endif value="随州">随州</option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '恩施')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='恩施') selected="selected" @endif value="恩施">恩施</option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '仙桃')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='仙桃') selected="selected" @endif value="仙桃">仙桃</option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '潜江')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='潜江') selected="selected" @endif value="潜江">潜江</option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '天门')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='天门') selected="selected" @endif value="天门">天门</option>
                        </select>
                    @endif

                    @if(Auth::user()->area_level == '林区')
                        <select name="region" id="region">
                            <option @if(isset($filter['region']) && $filter['region']=='林区') selected="selected" @endif value="林区">林区</option>
                        </select>
                    @endif
                </td>




                <td>
                    &nbsp;&nbsp;&nbsp;
                    <input type="button" id="viewBtn" class="formButton" value="查询" hidefocus onclick="doSearch()"/>
                </td>

                <td style="float:left;margin-right:30px;">
                    <input type="button" class="formButton" value="新增费用" id="addBtn" style="float: right;" onclick="doAddPage()"/>
                </td>



            </div>
        </form>
        </div>
        <div>
            <table class="listTable" style="white-space:nowrap;font-size:12px;">

                <tr>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>操作</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>站址编码</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>地市</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>wlan费用(元/月)</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>微波费用(元/月)</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>超过10%高等级服务站址额外维护服务费(元/月)</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>蓄电池额外保障费(元/月)</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>bbu安装在铁塔机房费(元/月)</a>
                    </th>

                </tr>
                @if(isset($otherCosts))
                    @foreach($otherCosts as $otherCost)
                        <tr>
                            <td><a href="javascript:void(0)" onclick="doEditPage({{$otherCost->id}})">编辑</a></td>
                            <td>{{$otherCost->site_code}}</td>
                            <td>{{$otherCost->region_name}}</td>
                            <td>{{$otherCost->fee_wlan}}</td>
                            <td>{{$otherCost->fee_microwave}}</td>
                            <td>{{$otherCost->fee_add}}</td>
                            <td>{{$otherCost->fee_battery}}</td>
                            <td>{{$otherCost->fee_bbu}}</td>


                        </tr>
                    @endforeach

                @endif


            </table>



        </div>
    </div>

    </body>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {
            $('#menu_business').addClass("current");
        });

         function doSearch(){
             var form = document.getElementById('listForm');
             form.submit();
         }

         function doAddPage(){
             var form = document.getElementById('listForm');
             form.action = "{{url('backend/otherCost/addPage')}}";
             form.submit();
         }

         function doEditPage(id){
             var region = $('#region').val();
             var form = document.getElementById('listForm');
             var url = "{{url('backend/otherCost/editPage')}}" + '/' + id + '/' + region;
             form.action = url;
             form.submit();
         }

    </script>
@endsection







