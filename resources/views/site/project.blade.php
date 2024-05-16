@extends('layouts.site')

@section('title', $category->name.' - Linear Esquadrias')

@section('content')

	<h1>Projeto</h1>
	<div class="divisor divisor-header"></div>

	<div class="content center">

		<div class="flex project-header">
			<div class="image" style="background-image: url('{{ asset($category->path.$category->image) }}');"></div>
			<div class="text">
				<div class="text-content">
					<p>{!! nl2br($category->description) !!}</p>
				</div>
			</div>
		</div>

		<div class="owl-carousel owl-theme project-footer">
			@foreach($galleries as $gallery)
			<a href="{{ route('gallery', $gallery['url']) }}">
				<img src="{{ asset($gallery['image']) }}" alt="{{ $category->name }}" class="thumb">
			</a>
			@endforeach
		</div>

	</div>

	<div class="divisor"></div>

@stop

@section('css')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css">
@stop

@section('js')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
@stop
