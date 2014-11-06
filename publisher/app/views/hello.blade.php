@extends('layouts.master')
@section('title')
欢迎！
@stop
@section('sidebar')
    @include('sidebar', array('currpage'=>'index'))
@stop

@section('content')
    <p>This is my body content.</p>
@stop