@extends('layouts.master')
@section('title')
<?php if($server):?> 编辑服务器－<?php echo $server->title; ?> <?php else:?> 新增项目－<?php endif;?> @parent @stop
@section('sidebar')
    @include('sidebar', array('currpage'=>'projects'))
@stop
@section('content') 
<?php if($server):?>
{{ Form::model($server, array('url' => '/servers/edit' ,'class' => 'uk-form uk-form-horizontal' )) }}
    <div class="uk-form-row">
        <label class="uk-form-label">服务器ID</label>
        <div class="uk-form-controls"><?php echo $server->id;?><?php echo Form::hidden('id',$server->id);?></div>
    </div>
<?php else: ?>
{{ Form::open(array('url' => '/servers/add' ,'class' => 'uk-form uk-form-horizontal' )) }}
<?php endif;?>
    <div class="uk-form-row">
        {{ Form::label('title','服务器名称',array('class' => 'uk-form-label')) }}
        <div class="uk-form-controls">
        {{ Form::text('title') }}
        </div>
    </div>
    <div class="uk-form-row">
        {{ Form::label('project_id','所属项目',array('class' => 'uk-form-label')) }}
        <div class="uk-form-controls">
        {{ Form::select('project_id',$projects,($project_id ? $project_id : null)) }}
        </div>
    </div>
    <div class="uk-form-row">
        {{ Form::label('ip','服务器ip',array('class' => 'uk-form-label')) }}
        <div class="uk-form-controls">
        {{ Form::text('ip') }}
        </div>
    </div>
    <div class="uk-form-row">
        {{ Form::label('rsync_name','rsync模块名',array('class' => 'uk-form-label')) }}
        <div class="uk-form-controls">
        {{ Form::text('rsync_name') }}
        </div>
    </div>
    <div class="uk-form-row">
        {{ Form::label('comment','备注',array('class' => 'uk-form-label')) }}
        <div class="uk-form-controls">
        {{ Form::textarea('comment',null,array('rows'=>3)) }}
        </div>
    </div>
    <?php if($error):?>
    <div class="uk-alert uk-alert-danger">{{ $error }}</div>
    <?php endif;?>
    <div class="uk-form-row">
        {{ Form::submit('提交',array('class'=>'uk-button uk-button-primary')) }}
    </div>
{{ Form::close() }}
@stop