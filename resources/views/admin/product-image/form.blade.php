@extends('adminlte::page')

@section('title', 'Imagem')

@section('content_header')
<h1>Imagem</h1>
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

				@if($productImage->id)
					<form method="POST" action="{{ route('admin.product.image.update', [$productImage->product_id, $productImage->id]) }}" enctype="multipart/form-data" autocomplete="off">
					{{ method_field('PUT') }}
				@else
					<form method="POST" action="{{ route('admin.product.image.store', $productImage->product_id) }}" enctype="multipart/form-data">
				@endif

					{{ csrf_field() }}
					<input type="hidden" name="product_id" value="{{ $productImage->product_id }}">

					<div class="row">

						<div class="col-xs-12">
							<div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
								<label for="image">*Imagem</label>
								<input type="file" class="form-control" name="image" id="image" {{ ($productImage->id) ? '' : 'required' }}>
								@if ($errors->has('image'))
									<span class="help-block">{{ $errors->first('image') }}</span>
								@endif

								@if(!empty($productImage->image))
								<br>
								<img src="{{ asset($productImage->imagePath.$productImage->image) }}" style="display: block; width: 100%; max-width: 300px; height: auto;">
								@endif
							</div>
						</div>

					</div>

					<div class="row">

						<div class="col-xs-12 col-md-6">
							<div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
								<label for="status">*Status</label>
								<select name="status" id="status" class="form-control" required>
									<option value="1" {{ old('status', $productImage->status) ? 'selected' : '' }}>Ativo</option>
									<option value="0" {{ old('status', $productImage->status) ? '' : 'selected' }}>Inativo</option>
								</select>
								@if ($errors->has('status'))
									<span class="help-block">
										{{ $errors->first('status') }}
									</span>
								@endif
							</div>
						</div>

						<div class="col-xs-12 col-md-6">
							<div class="form-group {{ $errors->has('order') ? 'has-error' : '' }}">
								<label for="order">*Posição</label>
								<input type="text" class="form-control" name="order" id="order" required value="{{ old('order', $productImage->order) }}">
								@if ($errors->has('order'))
									<span class="help-block">
										{{ $errors->first('order') }}
									</span>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>
	<script>
		$( function() {
			$('.datepicker').datepicker({
				autoclose: true,
				format: 'dd/mm/yyyy',
				language: 'pt-BR',
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