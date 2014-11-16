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
                    <button class="uk-button" id="version_select">版本选择</button>&nbsp;已经选择版本：<span id="show_selected_version"></span>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div id="version_box" class="uk-modal">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="modal_content"></div>
        <div class="uk-panel uk-panel-box">
            <button class="uk-button uk-button-success" id="select_version_btn">确定</button>
        </div>
    </div>
</div>
<?php if(!empty($project->servers)):?>
<!--服务器列表-->
{{ Form::open(array("id"=>"publish_form")) }}
{{ Form::hidden("project_select_version","") }}
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
{{ Form::close() }}
<?php endif;?>
@stop

@section('js')
@parent
<script type="text/javascript">
//当前展示的项目id
var project_id = <?php echo intval($project->id);?>;
//看log历史翻页用的最后版本
var lastlog = '';
//版本选择
var version_log_box = $("#version_box .modal_content");
var modal = $.UIkit.modal("#version_box");
$("#version_select").click(function(){
    var thisbtn = $(this);
    thisbtn.attr("disabled","disabled").html("载入中...");
    //清理所有已经载入的页
    lastlog = '';
    version_log_box.html('');
    load_log_data(function(){thisbtn.removeAttr("disabled").html("版本选择");});
});

load_log_data = function(__callback){
    $.getJSON("/projects/srclog",{id:project_id, limit:10, last:lastlog},function(_data){
        if(!_data.last || _data.last == lastlog)
        {
            alert("没有更多数据了");
        }
        else
        {
            lastlog = _data.last;
            //如果没有ul就增加一个
            if(version_log_box.find("ul").length == 0)
            {
                $('<ul class="uk-list"></ul>').appendTo(version_log_box);
            }
            var _ul = version_log_box.find("ul");
            for (var _key in _data.logs ) {
                $("<label/>").append(
                    $("<input/>").attr({
                        type: 'radio',
                        value: _key,
                        name: "version_select"
                    })).append(_data.logs[_key])
                    .appendTo($("<li/>")
                        .appendTo(_ul));
            }
            modal.show();
        }
        if(typeof(__callback) == 'function')
        {
            __callback();
        }
    });
}

$("#select_version_btn").click(function(event) {
    var selected = $("input[name='version_select']:checked").val();
    if(!selected) 
    {
        alert("请选择有效的版本");
        return false;
    }
    $("#show_selected_version").html(selected);
    $("input[name='project_select_version']").val(selected);
    modal.hide();
});
//操作同步
$("#dosync").click(function(){
    //将选中的服务器提交给服务端
    //包括选择的更新版本、选择的服务器
    //服务器接受项目id，更新的目标版本，服务器id
    //服务器设定更新项目，同步的一系列先后任务
    //返回给前端展示
});

//查询任务完成情况
</script>
@stop
