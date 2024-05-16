@extends('adminlte::page')

@section('title', 'Banners')

@section('content_header')
<h1>Banners</h1>
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

				@if($banner->id)
					<form method="POST" action="{{ route('admin.banner.update', $banner->id) }}" enctype="multipart/form-data">
					{{ method_field('PUT') }}
				@else
					<form method="POST" action="{{ route('admin.banner.store') }}" enctype="multipart/form-data">
				@endif

					{{ csrf_field() }}

					<div class="row">

						<div class="col-xs-12 col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
								<label for="name">*Nome</label>
								<input type="text" class="form-control" name="name" id="name" value="{{ old('name', $banner->name) }}" required autofocus>
								@if ($errors->has('name'))
									<span class="help-block">
										{{ $errors->first('name') }}
									</span>
								@endif
							</div>
						</div>

						<div class="col-xs-12 col-md-4">
							<div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
								<label for="url">Link</label>
								<input type="text" class="form-control url-field" name="url" id="url" value="{{ old('url', $banner->url) }}">
								@if ($errors->has('url'))
									<span class="help-block">
										{{ $errors->first('url') }}
									</span>
								@endif
							</div>
						</div>

						<div class="col-xs-12 col-md-4">
							<div class="form-group {{ $errors->has('position') ? 'has-error' : '' }}">
								<label for="position">*Posição</label>
								<input type="text" class="form-control" name="position" id="position" required value="{{ old('position', $banner->position) }}">
								@if ($errors->has('position'))
									<span class="help-block">
										{{ $errors->first('position') }}
									</span>
								@endif
							</div>
						</div>

					</div>
					<div class="row">

						<div class="col-xs-12 col-md-4">
							<div class="form-group {{ $errors->has('start') ? 'has-error' : '' }}">
				                <label for="start">Início</label>
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									@if( old('start') )
										<input type="text" class="form-control pull-right datepicker" name="start" id="start" value="{{ old('start') }}">				
									@elseif($banner->start)
										<input type="text" class="form-control pull-right datepicker" name="start" id="start" value="{{ $banner->start->format('d/m/Y') }}">
									@else
										<input type="text" class="form-control pull-right datepicker" name="start" id="start">
									@endif
				                </div>
								@if ($errors->has('start'))
									<span class="help-block">
										{{ $errors->first('start') }}
									</span>
								@endif
							</div>
						</div>

						<div class="col-xs-12 col-md-4">
							<div class="form-group {{ $errors->has('end') ? 'has-error' : '' }}">
				                <label for="end">Fim</label>
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control pull-right datepicker" name="end" id="end" value="{{ ($banner->end) ? $banner->end->format('d/m/Y') : '' }}">
				                </div>
								@if ($errors->has('end'))
									<span class="help-block">
										{{ $errors->first('end') }}
									</span>
								@endif
							</div>
						</div>

						<div class="col-xs-12 col-md-4">
							<div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
								<label for="status">*Status</label>
								<select name="status" id="status" class="form-control" required>
									<option value="1" {{ old('status', $banner->status) ? 'selected' : '' }}>Ativo</option>
									<option value="0" {{ old('status', $banner->status) ? '' : 'selected' }}>Inativo</option>
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
							<div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
								<label for="image">*Imagem ({{ $banner->width }}x{{ $banner->height }})</label>
								<input type="file" class="form-control" name="image" id="image" {{ ($banner->id) ? '' : 'required' }}>
								@if ($errors->has('image'))
									<span class="help-block">{{ $errors->first('image') }}</span>
								@endif

								@if(!empty($banner->image))
								<br>
								<img src="{{ asset($banner->path.$banner->image) }}" style="display: block; width: 100%; max-width: 300px; height: auto;">
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

@section('css')
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
@stop

@section('js')
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<script>
	$( function() {
		$('.datepicker').datepicker({
			autoclose: true,
			format: 'dd/mm/yyyy',                
    		language: 'pt-BR'
		});

		$('.url-field').blur(function(){
			var value = $(this).val();
			if(value != '')
			{
				var prefix = 'http://';
				if (value.substr(0, prefix.length) !== prefix)
				{
				    value = prefix + value;
				}
			}
			$(this).val(value);
		});
	});
</script>
@stop