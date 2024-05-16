@extends('adminlte::page')

@section('title', 'Categorias')

@section('content_header')
<h1>Categorias</h1>
@stop

@section('content')

<div class="row">
	<div class="col-xs-12">

		@if (session('success'))
			<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				{{ session('success') }}
			</div>
		@endif

		<div class="box">
			<div class="box-body">

				@if($category->id)
					<form method="POST" action="{{ route('admin.category.update', $category->id) }}" enctype="multipart/form-data">
					{{ method_field('PUT') }}
				@else
					<form method="POST" action="{{ route('admin.category.store') }}" enctype="multipart/form-data">
				@endif

					{{ csrf_field() }}

					<div class="row">

						<div class="col-xs-12 col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
								<label for="name">*Nome</label>
								<input type="text" class="form-control slug-field" data-slug="slug" name="name" id="name" value="{{ old('name', $category->name) }}" required autofocus>
								@if ($errors->has('name'))
									<span class="help-block">
										{{ $errors->first('name') }}
									</span>
								@endif
							</div>
						</div>

						<div class="col-xs-12 col-md-4">
							<div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
								<label for="slug">*URL</label>
								<input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug', $category->slug) }}" required>
								@if ($errors->has('slug'))
									<span class="help-block">
										{{ $errors->first('slug') }}
									</span>
								@endif
							</div>
						</div>

						<div class="col-xs-12 col-md-4">
							<div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
								<label for="status">*Status</label>
								<select name="status" id="status" class="form-control" required>
									<option value="1" {{ old('status', $category->status) ? 'selected' : '' }}>Ativo</option>
									<option value="0" {{ old('status', $category->status) ? '' : 'selected' }}>Inativo</option>
								</select>
								@if ($errors->has('status'))
									<span class="help-block">
										{{ $errors->first('status') }}
									</span>
								@endif
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
								<label for="description">Descrição</label>
								<textarea class="form-control" name="description" id="description" rows="5">{{ old('description', $category->description) }}</textarea>
								@if ($errors->has('description'))
									<span class="help-block">
										{{ $errors->first('description') }}
									</span>
								@endif					
							</div>
						</div>
					</div>
					<div class="row">

						<div class="col-xs-12">
							<div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
								<label for="image">*Imagem ({{ $category->width }}x{{ $category->height }})</label>
								<input type="file" class="form-control" name="image" id="image" {{ ($category->id) ? '' : 'required' }}>
								@if ($errors->has('image'))
									<span class="help-block">{{ $errors->first('image') }}</span>
								@endif

								@if(!empty($category->image))
								<br>
								<img src="{{ asset($category->path.$category->image) }}" style="display: block; width: 100%; max-width: 300px; height: auto;">
								@endif
							</div>
						</div>

					</div>
					<div class="row">

						<div class="col-xs-12">
							<span class="help-block">* Campos obrigatórios</span>
							<button type="submit" class="btn btn-success">Salvar alterações</button>
						</div>
					
					</div>

				</form>
			</div>
		</div>

	</div>
</div>
@stop

@section('js')
<script src="{{ asset('vendor/node-slug/slug.js') }}"></script>
<script>
	$( function() {
		$('.slug-field').blur(function(){
			var value = $(this).val();
			var element = $(this).attr('data-slug');
			changeSlug(value, element)
		});
	});

	function changeSlug(value, element)
	{
		if(value != ''){
			if( $('#'+element).hasClass('editing') || $('#'+element).val() == '' )
			{
				var newValue = slug( value, {lower: true} );
				$('#'+element).addClass('editing').val(newValue);
			}
		}
	}
</script>
@stop