<!DOCTYPE html>
<html lang="pt-br">
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> @yield('titulo') </title>
        <link href="{{ asset('img/favicon.png') }}" rel="shortcut icon" />
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/bootstrap.modif.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/bootstrap.modif.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/print-grafico.css') }}" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <noscript>
          <div class="container"> 
              <div class="alert alert-danger btn-lg col-md-8 col-md-offset-2 text-center">
                <span class="glyphicon glyphicon-remove-sign"></span>  O Javascript está desabilitado, o sistema não irá funcionar como deveria. Habilite-o!! 
              </div>
          </div>
       </noscript>

        <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap-notify.min.js') }}"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        @include('scripts.grafico')
	</head>
	<body>
        <div class="container" id="space">
            <header class="row">
                <nav class="navbar nav-justified center well-sm">
                    <div class="container-fluid col-md-4 col-xs-offset-4" >
                       <a><img src="{{ asset('img/sisfre.png') }}" class="img-responsive"></a>
                    </div>
                </nav>
                <div class="container-fluid col-md-5 col-xs-offset-4 text-uppercase" style="vertical-align: center;padding-bottom: 1.0em">
                    <p>
                         <b> Curso: </b> {{Auth::user()->professor->curso->nome}}<br>
                         <b>Coordenador: </b> {{Auth::user()->professor->usuario->username}}<br>
                         <b>Semestre: </b> @yield('semestre')
                    </p>

                </div>
            </header>

            <div id="conteudo" class="row col-md-12 col-xs-offset-0">
                @yield('conteudo')
            </div>
            
        </div>

	</body>
</html>