@extends('adminlte::page')

@section('title', 'Meus dados')

@section('content_header')
<h1>Meus dados</h1>
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


		<form method="POST" action="{{ route('admin.profile.update') }}">

			{{ csrf_field() }}

			<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
				<label for="name">*Nome</label>
				<input type="text" class="form-control" name="name" id="name" value="{{ old('name', $user->name) }}" required autofocus>
				@if ($errors->has('name'))
					<span class="help-block">
						{{ $errors->first('name') }}
					</span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
				<label for="email">*E-mail</label>
				<input type="email" class="form-control" name="email" id="email" value="{{ old('email', $user->email) }}" required>
				@if ($errors->has('email'))
					<span class="help-block">
						{{ $errors->first('email') }}
					</span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
				<label for="password">Senha</label>
				<input type="password" class="form-control" name="password" id="password">
				@if ($errors->has('password'))
					<span class="help-block">
						{{ $errors->first('password') }}
					</span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
				<label for="password_confirmation">Confirmação de senha</label>
				<input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
				@if ($errors->has('password_confirmation'))
					<span class="help-block">
						{{ $errors->first('password_confirmation') }}
					</span>
				@endif
			</div>

			<span class="help-block">* Campos obrigatórios</span>
			<button type="submit" class="btn btn-default">Salvar alterações</button>
		</form>


	</div>
</div>



@stop