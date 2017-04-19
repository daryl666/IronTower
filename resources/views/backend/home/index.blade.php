@extends('layouts.app')

@section('header')
    <title>首页</title>
@endsection

@section('content')
    <div class="container" style="width:100% ">
        <div class="row clearfix">
            <div class="col-md-12 column" style="padding: 0">
                <ul class="nav nav-tabs" style="font-size: 13px">
                    <li class="active">
                        <a href="{{url('backend')}}">待办事项</a>
                    </li>
                </ul>
                <ul class="breadcrumb" style="margin-bottom: 0;background-color: #F5F5F5">
                    当前位置：
                    <li>
                        <a href="#">首页</a>
                    </li>
                    <li class="active">
                        <a href="#">待办事项</a>
                    </li>
                </ul>


            </div>
        </div>

    </div>

    <div class="list">
        <div class="body">
            <form id="listForm" method="post" action="{{url('backend/siteCheck?region=').Auth::user()->area_level.'&checkStatus=0&beginDate=&endDate='}}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </div>
        <div>
            <table class="listTable" style="white-space:nowrap;font-size:12px;">

                <tr>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>操作</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>待办事项类型</a>
                    </th>
                    <th>
                        <a href="#" class="sort" name="" hidefocus>待办事项数目</a>
                    </th>

                </tr>
                @if(Auth::user()->area_level != '湖北省')
                    @if(!empty($todoList[0]))
                        <tr>
                            <td><button class="buttonNextStep" onclick="doHandlePage(0)">前往办理</button></td>
                            <td>站址导入异常</td>
                            <td>{{count($todoList[0])}}</td>
                        </tr>
                    @endif
                    @if(!empty($todoList[1]))
                        <tr>
                            <td><button class="buttonNextStep" onclick="doHandlePage(1)">前往办理</button></td>
                            <td>发电结果填报</td>
                            <td>{{count($todoList[1])}}</td>
                        </tr>
                    @endif
                    @if(!empty($todoList[2]))
                        <tr>
                            <td><button class="buttonNextStep" onclick="doHandlePage(2)">前往办理</button></td>
                            <td>上站结果填报</td>
                            <td>{{count($todoList[2])}}</td>
                        </tr>
                    @endif
                    @if(!empty($todoList[3]))
                        <tr>
                            <td><button class="buttonNextStep" onclick="doHandlePage(3)">前往办理</button></td>
                            <td>退服原因填报</td>
                            <td>{{count($todoList[3])}}</td>
                        </tr>
                    @endif
                    @if(!empty($todoList[4]))
                        <tr>
                            <td><button class="buttonNextStep" onclick="doHandlePage(4)">前往办理</button></td>
                            <td>待出账单</td>
                            <td>{{count($todoList[4])}}</td>
                        </tr>
                    @endif
                @endif
                @if(Auth::user()->area_level == '湖北省')
                    @if(!empty($todoList[5]))
                        <tr>
                            <td><button class="buttonNextStep" onclick="doHandlePage(5)">前往办理</button></td>
                            <td>待审核屏蔽记录</td>
                            <td>{{count($todoList[5])}}</td>
                        </tr>
                    @endif
                    @if(!empty($todoList[6]))
                        <tr>
                            <td><button class="buttonNextStep" onclick="doHandlePage(6)">前往办理</button></td>
                            <td>待审核解屏蔽记录</td>
                            <td>
                                {{count($todoList[6])}}
                            </td>
                        </tr>
                    @endif
                @endif


            </table>


        </div>


    </div>
@endsection




@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {
            if (window.history && window.history.pushState) {
                $(window).on('popstate', function () {
                    window.history.forward(1);
                });
            }
            $('#menu_index').addClass("current");
        });

        function doHandlePage(id) {
            var listForm = document.getElementById('listForm');
            var url = "{{url('backend/todoHandlePage')}}" + '/' + id;
            listForm.action = url;
            listForm.submit();
        }

        function doSearch() {
            var listForm = document.getElementById('listForm');
            listForm.action = "{{url('backend')}}";
            listForm.submit();

        }
    </script>
@endsection