@extends('layouts.app')

@section('header')
    <title>4G性能数据报表分析系统</title>
@endsection

@section('content')
<script type="text/javascript">
    $().ready(function() {

        $('#menu_index').addClass("current");
    });
</script>
<div class="index">
    <div id="indexBar" class="bar">
        欢迎使用4G性能数据报表分析系统！首页
    </div>
</div>
@endsection