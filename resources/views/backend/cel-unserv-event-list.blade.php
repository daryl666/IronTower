@extends('layouts.app')

@section('content')
    <script type="text/javascript">
        $().ready(function() {

            $('#menu_unserv').addClass("current");

            // 重绘尺寸
            $(window).resize(function() {
                var width = $(window).width();
                if($("#tree").is(":hidden")){
                    $("#isShowArea").val("false");
                    $("#listTable").css("width", width);
                } else{
                    $("#isShowArea").val("true");
                    $("#listTable").css("width", width - 200);
                }
            });

            // 地区选择
            $("#areaButton").click(function() {
                $("#tree").toggle();
                var width = $(window).width();
                if($("#tree").is(":hidden")){
                    $("#isShowArea").val("false");
                    $("#listTable").css("width", width);
                } else{
                    $("#isShowArea").val("true");
                    $("#listTable").css("width", width - 200);
                }
            });

//            <#if isShowArea?? && isShowArea == 'false'>
//            $("#tree").hide();
//            var width = $(window).width();
//            $("#listTable").css("width", width);
//            </#if>

            // 查询
            $("#searchButton").click(function() {
                // 更改Form访问地址Action
                $("#listForm").attr("action","{{url('/backend/part1')}}");

                // 获取地区选择条件
                $("#areaInfoCondition").val(getCondition());
                $("#areaInfoIdCondition").val(getConditionForId());

                // 表单提交
//                $("#listForm").submit();

                // loading
                $("#waitingBody").waiting({ fixed: true });
            });
        });
    </script>
<div class="list" id="waitingBody">
    <div class="body">
        <form id="listForm" action="" method="post">
            {{ csrf_field() }}
            <div class="listBar">
                <!-- <label>【查询】: </label> -->
                <table>
                    <tr>
                        <td>
                            统计起始时间:
                            <input type="text" id="beginDate" name="beginDate" style="width:130px;padding-left:5px"
                                   readonly="true" value="{{$begin_date}}" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:00:00'})" />
                            ~
                            统计结束时间:
                            <input type="text" id="endDate" name="endDate" style="width:130px;padding-left:5px"
                                   readonly="true" value="{{$end_date}}" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:00:00'})" />
                            &nbsp;&nbsp;
                            地区选择：
                            <a href="javascript:void(0);" id="areaButton">
                                <input type="button"  value="..." hidefocus />
                            </a>
                        </td>
                        <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="button" id="searchButton" class="formButton"  value="搜 索" />
                            <input type="hidden" id="areaInfoCondition" name="areaInfoCondition" value=""  />
                            <input type="hidden" id="areaInfoIdCondition" name="areaInfoIdCondition" value=''/>
                            <input type="hidden" id="isShowArea" name="isShowArea" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>
							<span>
								当前查询条件：
								时间：&nbsp;&nbsp;
                                地区：全部地区&nbsp;&nbsp;
							</span>
                            &nbsp;总记录数: {{$total_count}} (共{{$page_count}}页)
                        </td>
                        <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="button" id="exportButton" class="formButton" value="导 出"/>
                        </td>

                    </tr>
                </table>
            </div>
            <div style="height:765px">
                <table width="100%" style="white-space:nowrap;">
                    <tr>
                        <td id="tree" style="border:1px solid silver">
                            @include('backend.area')
                        </td>
                        <td style="vertical-align:top">
                            <div id="listTable" style="overflow-x:scroll;">
                                <script>
                                    var width = $(window).width();
                                    $("#listTable").css("width", width - 200);
                                </script>
                                <table class="listTable" style="white-space:nowrap;">
                                    <tr>
                                        <th>
                                            <a href="#" hidefocus>省/市/区</a>
                                        </th>
                                        <th>
                                            <a href="#" class="sort" name="userlabel" hidefocus>小区名称</a>
                                        </th>
                                        <th>
                                            <a href="#" class="sort" name="relatedEnbId" hidefocus>基站编号</a>
                                        </th>
                                        <th>
                                            <a href="#" class="sort" name="celId" hidefocus>小区编号</a>
                                        </th>
                                        <th>
                                            <a href="#" class="sort" name="towerId" hidefocus>铁塔站址编码</a>
                                        </th>
                                        <th>
                                            <a href="#" class="sort" name="towerName" hidefocus>铁塔站址名称</a>
                                        </th>
                                        <th>
                                            <a href="#" class="sort" name="cellUnservTime" hidefocus>退服时长（s）</a>
                                        </th>
                                        <th>
                                            <a href="#" class="sort" name="judgeThreshold" hidefocus>退服阈值（s）</a>
                                        </th>
                                        <th>
                                            <a href="#" class="sort" name="scanStartTime" hidefocus>统计开始时间</a>
                                        </th>
                                        <th>
                                            <a href="#" class="sort" name="scanStopTime" hidefocus>统计结束时间</a>
                                        </th>
                                    </tr>
                                    @foreach($list as $data)
                                    <tr>
                                        <td>{{$data->title}}</td>
                                        <td>{{$data->body}}</td>
                                        <td>{{$data->created_at}}</td>
                                        <td colspan="7"></td>
                                    </tr>
                                    @endforeach
                                    @if($total_count == 0)
                                        <tr>
                                            <td colspan="10" style="text-align:center;color:red">暂无记录</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="pagerBar">
                <div class="pager">
                    @include('backend.pager')
                </div>
            <div>

        </form>
    </div>
</div>

@endsection