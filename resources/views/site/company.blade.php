@extends('layouts.site')

@section('title', 'Linear - Linear Esquadrias')

@section('content')
	<h1>Linear</h1>

	<div class="divisor divisor-header"></div>

	<div class="content center">

		<img src="{{ asset('images/linear-top.jpg') }}" alt="Linear">

		<div class="divisor"></div>

		<br>

		<p class="company-text">A LINEAR - Esquadrias de Alumínio é uma empresa do ramo de construção civil formada por profissionais que somam mais de 15 anos de experiência no mercado.</p>
		<p class="company-text">Mantemos uma comunicação aberta com nossos clientes. Durante todo o contato com a empresa, você notará que seguimos uma mesma linha de excelência para o atendimento, produção e entrega.</p>
		<p class="company-text">As esquadrias da linear cumprem todas as normas técnicas propostas pela <a href="http://www.abnt.org.br/" target="_blank">ABNT</a> (Associação Brasileira de Normas Técnicas), o que garante padronização, economia, proteção e qualidade ao consumidor. Além disso nossos produtos são entregues com manual de instalação, recomendações de cuidados e limpeza.</p>
		<p class="company-text">Nosso foco é inovar e trazer soluções viáveis para atender os projetos dos mais econômicos aos mais sofisticados.</p>
		<p class="company-text">Do seu projeto à solução, o melhor caminho entre os dois pontos é LINEAR.</p>

		<br>

		<div class="divisor"></div>

		<div class="flex company-images">
			<img src="{{ asset('images/linear-1.jpg') }}" alt="Linear">
			<img src="{{ asset('images/linear-2.jpg') }}" alt="Linear">
		</div>

		<div class="divisor"></div>

	</div>
@stop
