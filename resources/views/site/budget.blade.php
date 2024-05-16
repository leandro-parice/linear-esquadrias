@extends('layouts.site')

@section('title', 'Orçamentos - Linear Esquadrias')

@section('content')

	<h1>Orçamentos</h1>
	<div class="divisor divisor-header"></div>

	<div class="content center">

		<p class="mobile-padding">Solicite seu orçamento</p>
		<br>

		@if ($errors->any())
			<p style="color: tomato; font-size: 14px;">
			@foreach ($errors->all() as $error)
				{{ $error }}<br>
			@endforeach
			<br>
			</p>
		@endif

		@if(isset($response))
			<p class="mobile-padding">{{ $response }}</p>
			<br>
		@endif

		<form action="{{ route('budget.send') }}" method="post">
			{{ csrf_field() }}
			<input type="text" name="name" id="name" placeholder="Nome" required>
			<input type="text" name="phone" id="phone" placeholder="Telefone" required class="w-50 phone">
			<input type="text" name="mobile" id="mobile" placeholder="Celular" required class="w-50 phone">
			<input type="email" name="email" id="email" placeholder="E-mail" required>
			<input type="text" name="subject" id="subject" placeholder="Assunto" required class="w-50">
			<input type="text" name="city" id="city" placeholder="Cidade/Estado" required class="w-50">
			<textarea name="msg" id="msg" placeholder="Mensagem" required></textarea>
			<div class="form-footer">
				<button>Enviar</button>
			</div>
		</form>

	<div class="divisor"></div>

	</div>
@stop

@section('js')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
	<script>
		$(document).ready(function(){
			$(".phone")
			.focus(function (event) {
				var target, phone, element;
				target = (event.currentTarget) ? event.currentTarget : event.srcElement;
				phone = target.value.replace(/\D/g, '');
				element = $(target);
				element.unmask();
				if(phone.length > 10) {
					element.mask("(99)99999-999?9",{placeholder:" "});
				} else {
					element.mask("(99)9999-9999?9",{placeholder:" "});
				}
			})
			.focusout(function (event) {
				var target, phone, element;
				target = (event.currentTarget) ? event.currentTarget : event.srcElement;
				phone = target.value.replace(/\D/g, '');
				element = $(target);
				element.unmask();
				if(phone.length > 10) {
					element.mask("(99)99999-999?9",{placeholder:" "});
				} else {
					element.mask("(99)9999-9999?9",{placeholder:" "});
				}
			});
		});
  </script>
 @stop
