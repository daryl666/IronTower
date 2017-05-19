@extends('layouts.app')

@section('header')
<title>用户管理</title>
@endsection

@section('content')
<div class="container" style="width:100% ">
    <div class="row clearfix">
        <div class="col-md-12 column" style="padding: 0">
            {{-- <div class="collapse navbar-collapse" id="example-navbar-collapse"> --}}
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="{{url('backend/userManage')}}">用户管理</a>
                </li>
                <li class="inactive">
                    <a href="{{url('backend/eventLog?region=').Auth::user()->area_level.'&beginDate=&endDate='}}">日志管理</a>
                </li>
                <li class="inactive">
                    <a href="{{url('backend/rentStd')}}">计费标准管理</a>
                </li>

            </ul>
            <ul class="breadcrumb" style="margin-bottom: 0;background-color: #F5F5F5">
                当前位置：
                <li>
                    <a href="{{url('backend/userManage')}}">系统管理</a>
                </li>
                <li class="active">
                    <a href="#">用户管理</a>
                </li>
            </ul>
            {{-- </div> --}}

        </div>
    </div>

</div>
<div class="list">
    <div class="body">
        <form id="listForm" method="post" action="{{url('backend/userManage/update')}}"
        enctype="multipart/form-data">
        {!! csrf_field() !!}
        <table class="listTable" style="white-space:nowrap;font-size:12px;">
            <tr>
                <th>
                    <a href="#" class="sort" name="" hidefocus>用户级别</a>
                </th>
                <th>
                    <a href="#" class="sort" name="" hidefocus>用户名</a>
                </th>
                <th>
                    <a href="#" class="sort" name="" hidefocus>权限</a>
                </th>
                <th>
                    <a href="#" class="sort" name="" hidefocus>状态</a>
                </th>
                <th class="scanStopTime">
                    <a href="#" class="sort" name="" hidefocus>操作</a>
                </th>
            </tr>
            @if(isset($users))
            @foreach($users as $user)
            @if($user->area_level != 'admin')
            <tr>
                <td>{{$user->area_level}}</td>
                <td>{{$user->name}}</td>
                <td>
                  <input type="checkbox" name="permission_{{$user->id}}[]" value="site_add"
                  @if($user->site_add == 1) checked="checked"@endif>站址新增
                  <input type="checkbox" name="permission_{{$user->id}}[]" value="site_view_basic"
                  @if($user->site_view_basic == 1) checked="checked"@endif>查看站址基础信息
                  <input type="checkbox" name="permission_{{$user->id}}[]" value="site_view_advance"
                  @if($user->site_view_advance == 1) checked="checked"@endif>查看站址价格相关信息
                  <input type="checkbox" name="permission_{{$user->id}}[]" value="site_modify"
                  @if($user->site_modify == 1) checked="checked"@endif>站址属性修改
                  <input type="checkbox" name="permission_{{$user->id}}[]" value="site_delete"
                  @if($user->site_delete == 1) checked="checked"@endif>站址删除
                  <input type="checkbox" name="permission_{{$user->id}}[]" value="site_batch_import"
                  @if($user->site_batch_import == 1) checked="checked"@endif>站址批量导入
                  <input type="checkbox" name="permission_{{$user->id}}[]" value="site_batch_export"
                  @if($user->site_batch_export == 1) checked="checked"@endif>站址批量导出
                  <input type="checkbox" name="permission_{{$user->id}}[]" value="bill_view"
                  @if($user->bill_view == 1) checked="checked"@endif>查看账单
                  <input type="checkbox" name="permission_{{$user->id}}[]" value="bill_out"
                  @if($user->bill_out == 1) checked="checked"@endif>出账
                  <input type="checkbox" name="permission_{{$user->id}}[]" value="gnr_manage"
                  @if($user->gnr_manage == 1) checked="checked"@endif>发电记录管理
                  <input type="checkbox" name="permission_{{$user->id}}[]" value="site_check_manage"
                  @if($user->site_check_manage == 1) checked="checked"@endif>上站记录管理
                  <input type="checkbox" name="permission_{{$user->id}}[]" value="site_shield_manage"
                  @if($user->site_shield_manage == 1) checked="checked"@endif>屏蔽记录管理
                  <input type="checkbox" name="permission_{{$user->id}}[]" value="os_reason_manage"
                  @if($user->os_reason_manage == 1) checked="checked"@endif>退服原因管理
              </td>
              <td>
                @if($user->is_verified == 1)已审核@endif
                @if($user->is_verified == 0)待审核@endif
            </td>
            <td>
                @if($user->is_verified == 1)
                <button class="buttonNextStep" onclick="doUpdate({{$user->id}})">修改权限
                </button>
                @endif
                @if($user->is_verified == 0)
                <button class="buttonNextStep" onclick="doVerify({{$user->id}})">审核通过
                </button>
                @endif
            </td>
        </tr>
        @endif
        @endforeach
        @endif


    </table>
</form>
</div>
</div>
@endsection

@section('script_footer')
<script type="text/javascript">
$().ready(function () {

    $('#menu_sys').addClass("current");
});

function doVerify(id) {
    var listForm = document.getElementById('listForm');
    var url = "{{url('backend/userManage/verify')}}" + '/' + id;
    listForm.action = url;
    listForm.submit();
}
function doUpdate(id) {
    var listForm = document.getElementById('listForm');
    var url = "{{url('backend/userManage/update')}}" + '/' + id;
    listForm.action = url;
    listForm.submit();
}

</script>
@endsection







