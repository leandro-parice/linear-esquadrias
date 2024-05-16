@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
<h1>Usuários</h1>
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

				@if($user->id)
					<form method="POST" action="{{ route('admin.user.update', $user->id) }}">
					{{ method_field('PUT') }}
				@else
					<form method="POST" action="{{ route('admin.user.store') }}">
				@endif

					{{ csrf_field() }}

					<div class="row">

						<div class="col-xs-12 col-md-6">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
								<label for="name">*Nome</label>
								<input type="text" class="form-control" name="name" id="name" value="{{ old('name', $user->name) }}" required autofocus>
								@if ($errors->has('name'))
									<span class="help-block">
										{{ $errors->first('name') }}
									</span>
								@endif
							</div>
						</div>

						<div class="col-xs-12 col-md-6">
							<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
								<label for="email">*E-mail</label>
								<input type="email" class="form-control" name="email" id="email" value="{{ old('email', $user->email) }}" required>
								@if ($errors->has('email'))
									<span class="help-block">
										{{ $errors->first('email') }}
									</span>
								@endif
							</div>
						</div>

					</div>
					<div class="row">

						<div class="col-xs-12 col-md-6">
							<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
								<label for="password">Senha</label>
								<input type="password" class="form-control" name="password" id="password">
								@if ($errors->has('password'))
									<span class="help-block">
										{{ $errors->first('password') }}
									</span>
								@endif
							</div>
						</div>

						<div class="col-xs-12 col-md-6">
							<div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
								<label for="password_confirmation">Confirmação de senha</label>
								<input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
								@if ($errors->has('password_confirmation'))
									<span class="help-block">
										{{ $errors->first('password_confirmation') }}
									</span>
								@endif
							</div>
						</div>

					</div>
					<div class="row">

						<div class="col-xs-12 col-md-6">
							<div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
								<label for="type">*Tipo</label>
								<select name="type" id="type" class="form-control" required>
									<option value="admin" {{ old('type', $user->type == 'admin') ? 'selected' : '' }}>Administrador</option>
									<option value="superadmin" {{ old('type', $user->type == 'superadmin') ? 'selected' : '' }}>Superadministrador</option>
								</select>
								@if ($errors->has('type'))
									<span class="help-block">
										{{ $errors->first('type') }}
									</span>
								@endif
							</div>
						</div>

						<div class="col-xs-12 col-md-6">
							<div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
								<label for="status">*Status</label>
								<select name="status" id="status" class="form-control" required>
									<option value="1" {{ old('status', $user->status) ? 'selected' : '' }}>Ativo</option>
									<option value="0" {{ old('status', $user->status) ? '' : 'selected' }}>Inativo</option>
								</select>
								@if ($errors->has('status'))
									<span class="help-block">
										{{ $errors->first('status') }}
									</span>
								@endif
							</div>
						</div>

						<div class="col-xs-12 col-md-6">
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