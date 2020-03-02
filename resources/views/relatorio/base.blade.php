<!DOCTYPE html>
<html lang="pt-br">
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> @yield('titulo') </title>
        <link href="{{public_path()}}/img/favicon.png" rel="shortcut icon" />
        <link href="{{public_path()}}/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="{{public_path()}}/css/print.css" rel="stylesheet" type="text/css">
        <link href="{{public_path()}}/css/estilo.css" rel="stylesheet" type="text/css">

	</head>
	<body>

        <div class="container">
            <header class="row">
                @if(Auth::user()->acesso == 4)
                    <nav class="navbar nav-justified center well-sm">
                        <div class="container-fluid col-md-4 col-xs-offset-4" >
                           <a><img src="{{public_path()}}/img/sisfre.png" class="img-responsive"></a>
                        </div>
                    </nav>
                
                    <div class="container-fluid col-md-5 col-xs-offset-4 text-uppercase" style="vertical-align: center;padding-bottom: 1.0em">

                            <p>
                                 <b> Curso: </b> {{Auth::user()->professor->curso->nome}}<br>
                                 <b>Coordenador: </b> {{Auth::user()->professor->usuario->username}}<br>
                                 <b>Semestre: </b> @yield('semestre')
                            </p>
                    </div>

                @else
                    <nav class="navbar nav-justified">
                        <div class="row">
                            <div class="col-xs-5 col-xs-offset-2">
                               <a><img src="{{public_path()}}/img/sisfre.png" class="img-responsive" style="width: 10em"></a>
                            </div>
                            <div class="col-xs-4" style="vertical-align: middle;">
                                <b>    
                                    @if($dia == 1)
                                        SEGUNDA-FEIRA
                                    @elseif($dia == 2)
                                        TERÇA-FEIRA
                                    @elseif($dia == 3)
                                        QUARTA-FEIRA
                                    @elseif($dia == 4)
                                        QUINTA-FEIRA
                                    @elseif($dia == 5)
                                        SEXTA-FEIRA
                                    @endif
                                    |
                                    @if($turno == 'M')
                                        MANHÃ
                                    @elseif($turno == 'T')
                                        TARDE
                                    @elseif($turno == 'N')
                                        NOITE
                                    @endif
                                    | {{$hoje->format('d/m/Y')}}
                                </b> 
                            </div>
                    </div>
                    </nav>
                @endif
            </header>

            <div class="row">
                @yield('conteudo')
            </div>
            
        </div>

	</body>
</html>