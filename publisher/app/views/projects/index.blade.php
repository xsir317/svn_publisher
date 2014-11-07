@extends('layouts.master')
@section('title')
项目列表 @parent @stop
@section('sidebar')
	@include('sidebar', array('currpage'=>'projects'))
@stop

@section('content')
	<?php foreach($projects as $row):?>
		<?php echo $row->title;?>
	<?php endforeach;?>
@stop