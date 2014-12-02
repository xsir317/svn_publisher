@extends('layouts.master')
@section('title')
<?php if($user):?> 编辑用户－<?php echo $user->username; ?> <?php else:?> 新增用户－<?php endif;?> @parent @stop
@section('sidebar')
    @include('sidebar', array('currpage'=>'users'))
@stop
@section('content') 
<?php if($user):?>
{{ Form::model($user, array('url' => '/users/edit' ,'class' => 'uk-form uk-form-horizontal' )) }}
    <div class="uk-form-row">
        <label class="uk-form-label">用户ID</label>
        <div class="uk-form-controls"><?php echo $user->id;?><?php echo Form::hidden('id',$user->id);?></div>
    </div>
    <div class="uk-form-row">
        {{ Form::label('username','用户名',array('class' => 'uk-form-label')) }}
        <div class="uk-form-controls">
        {{ $user->username }}
        </div>
    </div>
<?php else: ?>
{{ Form::open(array('url' => '/users/add' ,'class' => 'uk-form uk-form-horizontal' )) }}
    <div class="uk-form-row">
        {{ Form::label('username','用户名',array('class' => 'uk-form-label')) }}
        <div class="uk-form-controls">
        {{ Form::text('username') }}
        </div>
    </div>
<?php endif;?>
    <div class="uk-form-row">
        {{ Form::label('password','密码',array('class' => 'uk-form-label')) }}
        <div class="uk-form-controls">
        {{ Form::password('password') }}
        </div>
    </div>
    <div class="uk-form-row">
        {{ Form::label('is_superadmin','超级管理员',array('class' => 'uk-form-label')) }}
        <div class="uk-form-controls">
        {{ Form::checkbox('is_superadmin','1',($user && $user->is_superadmin)) }}
        </div>
    </div>
    <?php if(!$user || !$user->is_superadmin):?>
    <div class="uk-form-row">
        {{ Form::label('','项目',array('class' => 'uk-form-label')) }}
        <div class="uk-form-controls">
        <ul class="uk-list">
            <?php foreach($projects as $_row):?>
            <li>
                {{ Form::checkbox('project[]',$_row->id,($user && in_array($_row->id,$user->pj_ids()))) }} {{ $_row->title }}
            </li>
            <?php endforeach;?>

        </ul>
        </div>
    </div>
    <?php endif;?>
    <?php if($error):?>
    <div class="uk-alert uk-alert-danger">{{ $error }}</div>
    <?php endif;?>
    <div class="uk-form-row">
        {{ Form::submit('提交',array('class'=>'uk-button uk-button-primary')) }}
    </div>
{{ Form::close() }}
@stop