@extends('layouts.site')

@section('title', 'Projetos - Linear Esquadrias')

@section('content')
	<h1>Projetos</h1>

	<div class="owl-carousel owl-theme owl-banners">
		@foreach($banners as $banner)
			@if($banner->url)
				<a href="{{ $banner->url }}" {!! (strpos($banner->url, 'linear.com.br') === false) ? 'target="_blank"' : '' !!} class="item" style="background-image: url('{{ asset($banner->path.$banner->image) }}');"></a>
			@else
				<div class="item" style="background-image: url('{{ asset($banner->path.$banner->image) }}');"></div>
			@endif
		@endforeach
	</div>

	<div class="divisor"></div>

	<div class="content center">

		<div class="flex projects-grid">
			@foreach($categories as $category)
			<a href="{{ route('project', $category->slug) }}">
				<div class="image" style="background-image: url('{{ asset($category->path.$category->image) }}"></div>
				<p>{{ $category->name }}<br><span></span></p>

			</a>
			@endforeach
		</div>

	</div>

	<div class="divisor"></div>
@stop
