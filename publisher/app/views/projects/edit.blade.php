@extends('layouts.master')
@section('title')
<?php if($project):?> 编辑项目－<?php echo $project->title; ?> <?php else:?> 新增项目－<?php endif;?> @parent @stop
@section('sidebar')
    @include('sidebar', array('currpage'=>'projects'))
@stop
@section('content') 
<?php if($project):?>
{{ Form::model($project, array('url' => '/projects/edit' ,'class' => 'uk-form uk-form-horizontal' )) }}
    <div class="uk-form-row">
        <label class="uk-form-label">项目ID</label>
        <div class="uk-form-controls"><?php echo $project->id;?><?php echo Form::hidden('id',$project->id);?></div>
    </div>
<?php else: ?>
{{ Form::open(array('url' => '/projects/add' ,'class' => 'uk-form uk-form-horizontal' )) }}
<?php endif;?>
    <div class="uk-form-row">
        {{ Form::label('title','项目名',array('class' => 'uk-form-label')) }}
        <div class="uk-form-controls">
        {{ Form::text('title') }}
        </div>
    </div>
    <div class="uk-form-row">
        {{ Form::label('manager','项目管理员',array('class' => 'uk-form-label')) }}
        <div class="uk-form-controls">
        {{ Form::text('manager') }}
        </div>
    </div>
    <div class="uk-form-row">
        {{ Form::label('vcs_type','版本管理工具',array('class' => 'uk-form-label')) }}
        <div class="uk-form-controls">
        {{ Form::select('vcs_type',Project::$vcs_types) }}
        </div>
    </div>
    <div class="uk-form-row">
        {{ Form::label('src_addr','源码地址',array('class' => 'uk-form-label')) }}
        <div class="uk-form-controls">
        {{ Form::text('src_addr',null,array('class'=>'uk-form-width-large')) }}
        </div>
    </div>
    <?php if($project):?>
    <div class="uk-form-row">
        {{ Form::label('current_version','当前版本',array('class' => 'uk-form-label')) }}
        <div class="uk-form-controls">
        {{ $project->current_version }}
        </div>
    </div>
    <?php endif;?>
    <div class="uk-form-row">
        {{ Form::label('ignore_files','同步时忽略',array('class' => 'uk-form-label')) }}
        <div class="uk-form-controls">
        {{ Form::textarea('ignore_files',null,array('rows'=>3)) }}
        </div>
    </div>
    <div class="uk-form-row">
        {{ Form::label('comments','备注',array('class' => 'uk-form-label')) }}
        <div class="uk-form-controls">
        {{ Form::textarea('comments',null,array('rows'=>3)) }}
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