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
                <ul class="nav nav-tabs">
                    <li class="inactive">
                        <a href="{{url('backend/servBill')}}">账单管理</a>
                    </li>
                    <li class="active">
                        <a href="{{url('backend/servBill/irontowerBillImportPage')}}">铁塔详单导入</a>
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/servBill/billCheck')}}">账单稽查</a>
                    </li>
                    <li class="inactive">
                        <a href="{{url('backend/siteStats/')}}">铁塔详单统计</a>
                    </li>
                </ul>
                <ul class="breadcrumb" style="margin-bottom: 0;background-color: #F5F5F5">
                    当前位置：
                    <li>
                        <a href="{{url('backend/servBill')}}">账单管理</a>
                    </li>
                    <li class="active">
                        <a href="#">铁塔详单导入</a>
                    </li>
                </ul>
            </div>
        </div>

    </div>




    <div class="list">
        <div class="body">
            <form id="listForm" method="post" action="{{url('backend/siteInfo/')}}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="siteStats" @if(isset($filter)) value="1" @endif>
                <div class="input managerInfo">
                    <div class="bar">
                        铁塔详单导入
                    </div>
                    <table class="inputTable tabContent">
                        <tr>
                            <td>
                                <input id="billDetailFile" name="billDetailFile" style="width: 170px" type="file">
                                <input class="formButton" onclick="doImport()" type="button" value="导入">
                            </td>
                        </tr>
                    </table>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('script_footer')
    <script type="text/javascript">
        $().ready(function () {
            $('#menu_bill').addClass("current");

        });
        function doImport() {
            var billDetailFile = document.getElementById('billDetailFile');
            if (billDetailFile.value == "") {
                alert('请选择需要导入的文件');
                return;
            }
            var form = new FormData(document.getElementById("listForm"));
//             var req = new XMLHttpRequest();
//             req.open("post", "${pageContext.request.contextPath}/public/testupload", false);
//             req.send(form);
            $.ajax({
                url:"{{url('backend/siteStats/import')}}",
                type:"post",
                data:form,
                processData:false,
                contentType:false,
                success:function(data){
//                    window.clearInterval(timer);
                    if (data.code == 1) {
                        alert("上传成功！");
                    }else {
                        alert('上传失败！');
                    }

                },
                error:function(e){
                    alert("上传失败！");
//                    window.clearInterval(timer);
                }
            });
        }


    </script>
@endsection