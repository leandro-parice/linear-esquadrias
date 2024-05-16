@extends('layouts.site')

@section('title', 'Contato - Linear Esquadrias')

@section('content')

	<h1>Contato</h1>
	<div class="divisor divisor-header"></div>

	<div class="content center">

		<p class="mobile-padding">Deixe aqui a sua mensagem</p>
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

		<form action="{{ route('contact.send') }}" method="post">
			{{ csrf_field() }}
			<input type="text" name="name" id="name" placeholder="Nome" required>
			<input type="email" name="email" id="email" placeholder="E-mail" required>
			<input type="text" name="phone" id="phone" class="phone" placeholder="Telefone" required>
			<textarea name="msg" id="msg" placeholder="Mensagem" required></textarea>
			<div class="form-footer">
				<button>Enviar</button>
			</div>
		</form>

		<div class="divisor"></div>

		<h2 class="mobile-padding">Localização</h2>
		<br>

		<div class="google-map">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3680.7001419805238!2d-47.658110784447565!3d-22.702203936311523!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94c63162a810bdbd%3A0x65fbfd27d58cff79!2sAv.+Pasteur%2C+176+-+Arei%C3%A3o%2C+Piracicaba+-+SP%2C+13414-046!5e0!3m2!1spt-BR!2sbr!4v1531336585666" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>
	</div>

	<div class="divisor"></div>
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
