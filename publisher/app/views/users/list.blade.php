@extends('layouts.master')
@section('title')
管理员列表 @parent @stop
@section('sidebar')
	@include('sidebar', array('currpage'=>'users'))
@stop

@section('content') 
<table class="uk-table">
    <caption>所有管理员&nbsp;&nbsp;<a href="/users/add" class="uk-button uk-button-primary">添加管理员</a></caption>
    <thead>
        <tr>
            <th>登录名</th>
            <th>最后登录IP</th>
            <th>超级管理员</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($users as $row):?>
        <tr>
            <td><?php echo $row->username;?></td>
            <td><?php echo $row->login_ip;?></td>
            <td><?php echo $row->is_superadmin ? '是':'否';?></td>
            <td>
                <a href="/users/edit?id=<?php echo $row->id;?>" class="uk-button">编辑</a>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
@stop