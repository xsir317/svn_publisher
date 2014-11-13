@extends('layouts.master')
@section('title')
项目列表 @parent @stop
@section('sidebar')
	@include('sidebar', array('currpage'=>'projects'))
@stop

@section('content') 
<!--显示项目详情、选版本按钮-->
<div class="uk-panel">
    <h3 class="uk-panel-title">{{{ $project->title }}} 详情</h3>
    <table class="uk-table">
        <tbody>
            <tr><th>负责人</th><td>{{{ $project->manager }}}</td></tr>
            <tr><th>VCS系统</th><td>{{{ $project->vcs_type }}}</td></tr>
            <tr><th>源码地址</th><td>{{{ $project->src_addr }}}</td></tr>
            <tr><th>当前版本</th><td>{{{ $project->current_version }}}</td></tr>
            <tr><th>备注</th><td>{{{ $project->comments }}}</td></tr>
            <tr><th>操作</th>
                <td>
                    <button class="uk-button" id="version_select">版本选择</button>
                </td>
            </tr>
        </tbody>
    </table>
    
</div>
<?php if(!empty($project->servers)):?>
<!--服务器列表-->
<table class="uk-table">
    <caption>所有服务器&nbsp;&nbsp;<a href="/servers/add?project_id=<?php echo $project->id;?>" class="uk-button uk-button-primary">添加服务器</a></caption>
    <thead>
        <tr>
            <th>选择</th>
            <th>服务器</th>
            <th>IP</th>
            <th>版本</th>
            <th>同步状态</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($project->servers as $row):?>
        <tr>
            <td><?php echo Form::checkbox("publish_box",$row->id);?></td>
            <td><?php echo $row->title;?></td>
            <td><?php echo $row->ip;?></td>
            <td><?php echo $row->current_version;?></td>
            <td>--</td>
            <td>
                <a href="/servers/edit?id=<?php echo $row->id;?>" class="uk-button">修改</a>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
<!--文件对比-->
<div class="uk-panel">
    <h3 class="uk-panel-title">待同步文件列表</h3>
</div>
<!--操作按钮-->
<div class="uk-panel">
   <button class="uk-button" id="dosync">同步</button>
</div>
<?php endif;?>
@stop

@section('js')
@parent
<script type="text/javascript">
var project_id = <?php echo intval($project->id);?>;
//版本选择
$("#version_select").click(function(){

});

//操作同步
$("#dosync").click(function(){
    //将选中的服务器提交给服务端
    //获得返回的 服务器id=>任务
});

//查询任务完成情况
</script>
@stop
