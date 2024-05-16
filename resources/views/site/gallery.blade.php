@extends('layouts.site')

@section('title', $product->name.' - Linear Esquadrias')

@section('content')

	<h1>Geleria de fotos</h1>
	<div class="divisor divisor-header"></div>

	<div class="content center">
		<div class="owl-carousel owl-theme owl-gallery-target gallery-target" id="gallery">
			<div class="image" style="background-image: url('{{ asset($product->path.$product->image) }}');" alt="{{ $product->name }}"></div>
			@foreach($images as $index => $image)
			<div class="image" style="background-image: url('{{ asset($image->path.$image->image) }}');" alt="{{ $product->name }}"></div>
			@endforeach
		</div>

		<div class="owl-carousel owl-theme owl-gallery-thumb gallery-thumb">
			<a href="javascript: chageImageGallery('0');" alt="{{ $product->name }}">
				<img src="{{ asset($product->path.$product->image) }}" alt="$product->name" class="thumb">
			</a>
			@foreach($images as $index => $image)
			<a href="javascript: chageImageGallery('{{ $index+1 }}');">
				<img src="{{ asset($image->path.$image->image) }}" alt="{{ $product->name }}" class="thumb">
			</a>
			@endforeach
		</div>
	</div>

	<div class="divisor"></div>

@stop

@section('js')]
<script>
	function chageImageGallery(img)
	{
	    $('#gallery').trigger('to.owl.carousel',img);
	}
</script>
@stop
