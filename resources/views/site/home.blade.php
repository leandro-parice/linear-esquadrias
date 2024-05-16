@extends('layouts.site')

@section('title', 'Linear Esquadrias')

@section('content')

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

	<div class="home-section">
		<h2>Padrão elevado de qualidade e tecnologia.</h2>
		<p>A Linear oferece a melhor solução em projetos residenciais e comerciais com inovação, modernidade, ousadia e design diferenciado.</p>
	</div>

	<div class="divisor"></div>

	<div class="content center">
		@foreach ($products->chunk(3) as $chunk)
		    <div class="home-grid">
		        @foreach ($chunk as $product)
					<a href="{{ route('gallery', $product->slug) }}">
						<div style="background-image: url('{{ asset($product->path.$product->image) }}');"></div>
						<span></span>
					</a>
		        @endforeach
		    </div>
		@endforeach
	</div>
@stop
