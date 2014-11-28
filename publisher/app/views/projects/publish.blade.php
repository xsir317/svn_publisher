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
                <td style="line-height: 30px;">
                    <button class="uk-button" id="version_select">版本选择</button>
                    &nbsp;已经选择版本：<span id="show_selected_version">--</span>
                    &nbsp;更新情况：<span id="show_update_status">--</span>
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
            <button class="uk-button uk-button-success" id="next_page_btn">后十项 &gt;</button>
        </div>
    </div>
</div>
<?php if(!empty($project->servers)):?>
<!--服务器列表-->
{{ Form::open(array("id"=>"publish_form","url"=>"/projects/dopublish","onsubmit"=>"return false;")) }}
{{ Form::hidden("project_select_version","") }}
{{ Form::hidden("id",$project->id) }}
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
        <tr class="server_row server_<?php echo $row->id;?>">
            <td><?php echo Form::checkbox("publish_box[]",$row->id);?></td>
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
   <button class="uk-button" id="dosync">发布</button>
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
    version_log_box.empty();
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
            //由于js的for in 问题，临时采用数组处理这个排序问题
            var _order = [];
            for (var _key in _data.logs ) _order[_order.length] = _key;
            _order.reverse();
            for (var _key in _order ) {
                $("<label/>").append(
                    $("<input/>").attr({
                        type: 'radio',
                        value: _order[_key],
                        name: "version_select"
                    })).append("version:"+_order[_key] + " " + _data.logs[_order[_key]])
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

$("#next_page_btn").click(function(){
    version_log_box.html('');
    load_log_data();
});
//操作同步
$("#dosync").click(function(){
    if(!$("input[name='project_select_version']").val())
    {
        alert("请选择有效的版本");
        return false;
    }
    if(0 == $("input[name='publish_box[]']:checked").length)
    {
        alert("请选择发布的服务器");
        return false;
    }
    var _confirm = "您是否确认将版本"+$("input[name='project_select_version']").val()+"发布到\n";
    $(".server_row").each(function(){
        if($(this).find($("input[name='publish_box[]']:checked")).length > 0)
        {
            _confirm += "\n" + $(this).find("td:eq(1)").html();
        }
    });
    if(window.confirm(_confirm))
    {
        //提交
        $.post($("#publish_form").attr("action"),$("#publish_form").serialize(),function(_data){
            if(!_data.result)
            {
                alert(_data.msg);
                return false;
            }
            var _task_ids = new Array;
            //绑定显示元素和任务之间的关系
            if(typeof(_data.tasks.upd_prj) != 'undefined')
            {
                $("#show_update_status").addClass("task_id_"+_data.tasks.upd_prj);
                _task_ids.push(parseInt(_data.tasks.upd_prj));
            }
            if(typeof(_data.tasks.sync_svr) != 'undefined')
            {
                for(var _key in _data.tasks.sync_svr)
                {
                    $(".server_"+_key).find("td:eq(4)").addClass("task_id_"+_data.tasks.sync_svr[_key]);
                    _task_ids.push(parseInt(_data.tasks.sync_svr[_key]));
                }
            }
            setTimeout(function(){update_task_status(_task_ids);},3000);
        },'json');
    }
});

var update_task_status = function(_tasks){
    var __tasks = _tasks;
    $.post("/projects/querystatus",{ids:_tasks},function(_return){
        var _done_tasks = new Array;
        for(var _key in _return)
        {
            var _class = '';
            switch(_return[_key])
            {
                case 'created':
                    continue;
                case 'execute':
                    _class = 'uk-icon-spinner uk-icon-spin uk-icon-small';
                    break;
                case 'success':
                    _class = 'uk-icon-check-circle-o uk-icon-small';
                    break;
                case 'failed':
                    _class = 'uk-icon-times-circle-o uk-icon-small';
                    break;
            }
            $(".task_id_"+_key).empty().append($("<i>").attr('class', _class));
            if(_return[_key] == 'success' || _return[_key] == 'failed')
            {
                //从__tasks里面删除
                _index = $.inArray(parseInt(_key), __tasks);
                if(_index != -1)
                {
                    __tasks.splice(_index,1);
                }
            }
        }
        if($.isEmptyObject(__tasks))
        {
            alert("发布成功");
        }
        else
        {
            setTimeout(function(){update_task_status(__tasks);},3000);
        }
    },'json');
}
</script>
@stop
