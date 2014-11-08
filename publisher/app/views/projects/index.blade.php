@extends('layouts.master')
@section('title')
项目列表 @parent @stop
@section('sidebar')
	@include('sidebar', array('currpage'=>'projects'))
@stop

@section('content') 
<table class="uk-table">
    <caption>所有项目&nbsp;&nbsp;<a href="/projects/add" class="uk-button uk-button-primary">添加项目</a></caption>
    <thead>
        <tr>
            <th>项目</th>
            <th>负责人</th>
            <th>当前版本</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($projects as $row):?>
        <tr>
            <td><?php echo $row->title;?></td>
            <td><?php echo $row->manager;?></td>
            <td><?php echo $row->current_version;?></td>
            <td>
                <a href="/projects/edit/id/<?php echo $row->id;?>" class="uk-button">详细</a>
                <a href="/servers/project_id/<?php echo $row->id;?>" class="uk-button">发布</a>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
@stop