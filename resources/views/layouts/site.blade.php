<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>@yield('title')</title>
	@yield('css')
	<link rel="stylesheet" href="{{ asset('css/site.css?v=1.2') }}">
</head>
<body>
	
	<header>
		<div class="content center">
			<a href="{{ route('home') }}" id="btn-header-mobile"><img src="{{ asset('images/linear-white.png') }}" alt="Linear"></a>
			<nav class="nav">
				<ul>
					<li><a href="{{ route('home') }}">Home</a></li>
					<li><a href="{{ route('company') }}">Linear</a></li>
					<li><a href="{{ route('projects') }}">Projetos</a></li>
					<li><a href="{{ route('budget') }}">Orçamentos</a></li>
					<li><a href="{{ route('contact') }}">Contato</a></li>
				</ul>
			</nav>
		</div>
	</header>
	<div class="header-logo">
		<a href="{{ route('home') }}" id="btn-header"><img src="{{ asset('images/linear.png') }}" alt="Linear"></a>
	</div>

	<button id="open-menu"><i class="fa fa-bars" aria-hidden="true"></i></button>
	<nav id="menu-mobile">
		<button id="close-menu" ><i class="fa fa-times" aria-hidden="true"></i></button>
		<ul>
			<li><a href="{{ route('home') }}">Home</a></li>
			<li><a href="{{ route('company') }}">Linear</a></li>
			<li><a href="{{ route('projects') }}">Projetos</a></li>
			<li><a href="{{ route('budget') }}">Orçamentos</a></li>
			<li><a href="{{ route('contact') }}">Contato</a></li>
		</ul>
	</nav>


    @yield('content')

    <footer>
    	<div class="content center">
    		<div class="flex">
    			<div class="logo">
					<a href="{{ route('home') }}"><img src="{{ asset('images/linear-white.png') }}" alt="Linear"></a>
				</div>
				<div class="text">
					<p>(19) 3371-5491<br>
					Av. Pasteur, 176 - Piracicaba/SP<br>
					comercial@linearesquadrias.com.br</p>
					<br>
					<p><a href="https://www.facebook.com/LinearEsquadriasDeAluminio/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a> <a href="https://www.instagram.com/linearesquadriasdealuminio/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></p>
				</div>
				<div class="personna">
					<a href="http://personnaassociadas.com.br/" target="_blank"><img src="{{ asset('images/personna.png') }}" alt="Personna"></a>
				</div>
    		</div>
       </div>
       <p>Copyright © {{ date('Y') }} | Linear Esquadrias de Alumínio | Todos os direitos reservados</p>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset('js/site.js?v=1.2') }}"></script>
    @yield('js')

</body>
</html>
