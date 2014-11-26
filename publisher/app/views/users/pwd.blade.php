@extends('layouts.master')
@section('title') 修改密码 @parent @stop
@section('sidebar')
    @include('sidebar', array('currpage'=>'pwd'))
@stop
@section('content') 
{{ Form::open(array('url' => '/users/password' ,'class' => 'uk-form uk-form-horizontal' )) }}
    <div class="uk-form-row">
        {{ Form::label('oldpwd','旧密码',array('class' => 'uk-form-label')) }}
        <div class="uk-form-controls">
        {{ Form::password('oldpwd') }}
        </div>
    </div>
    <div class="uk-form-row">
        {{ Form::label('newpwd','新密码',array('class' => 'uk-form-label')) }}
        <div class="uk-form-controls">
        {{ Form::password('newpwd') }}
        </div>
    </div>
    <div class="uk-form-row">
        {{ Form::label('repwd','重复新密码',array('class' => 'uk-form-label')) }}
        <div class="uk-form-controls">
        {{ Form::password('repwd') }}
        </div>
    </div>
    <?php if($error):?>
    <div class="uk-alert uk-alert-danger">{{ $error }}</div>
    <?php endif;?>
    <div class="uk-form-row">
        {{ Form::button('提交',array('class'=>'uk-button uk-button-primary','type' => 'submit')) }}
    </div>
{{ Form::close() }}
@stop