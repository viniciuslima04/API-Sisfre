@extends('layout.base')

@section('titulo','Editar Horário')

@section('scripts')
    @include('scripts.horario')
    @include('scripts.validation-horario')
    @include('scripts.outros')
@endsection

@section('conteudo')
<div class="col-md-12 col-md-offset-0">
    <div class="panel panel-default">
        <div class="panel-heading">Editar Horário</div>
        <div class="panel-body">
            <form class="form-horizontal editar" id="CadHora" role="form" method="POST" action="{{route('horario.update',$turma->id)}}">
                
                @include('layout.flash')

                <div class="row col-md-12">
                    <div class="form-group col-md-10 {{ $errors->has('turma') ? ' has-error' : '' }}">
                        <label for="turma" class="col-md-4 control-label">Turma:</label>
                        <div class="col-md-8">
                            <select class="selectpicker form-control select-center" name="turma" id="turma" data-status="200" readonly>
                                <option data-tokens="ketchup mustard" value="{{$turma->id}}" selected> {{$turma->descricao}} </option>
                            </select>

                            @if ($errors->has('turma'))
                                <span class="help-block">
                                     <strong>{{ $errors->first('turma') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                </div>

                <div id="tabela" class="row col-md-12 col-md-offset-0">
                    @if(isset($disciplinas) && $disciplinas->count() != 0)

                        <div class="row col-md-8 col-md-offset-2" style="margin-top: 2em; margin-bottom: -1em">
                            <div id="titulo" class="titulo" data-qtd_disciplina="{{$disciplinas->count()}}" data-total="{{$total_aulas}}" data-turno="{{$turma->turno}}"> 
                                <h4 class="text-center text-uppercase">
                                    <strong> HORÁRIO 
                                        @if($turma->turno == 'M' || $turma->turno == 'D') DA MANHÃ:
                                        @elseif($turma->turno == 'T') DA TARDE:
                                        @elseif($turma->turno == 'N') DA NOITE:
                                        @endif
                                    </strong>
                                </h4>
                            </div>
                        </div>

                        <div class="table-responsive col-md-12">
                            <table class="table table-striped bunitu">
                                <thead class="btn-primary">
                                    <tr class="row text-uppercase">
                                        <th class="text-center">AULA</th>
                                        <th class="text-center">SEGUNDA</th>
                                        <th class="text-center">TERÇA</th>
                                        <th class="text-center">QUARTA</th>
                                        <th class="text-center">QUINTA</th>
                                        <th class="text-center">SEXTA</th>
                                    </tr>
                                </thead>
                                @if($turma->turno == 'M' || $turma->turno == 'D')
                                    @for($aula = 1; $aula <= 4; $aula++ )
                                        <tr class="row text-uppercase">
                                            <td class="text-center" style="vertical-align: middle;"> {{$aula}}ª AULA </td>
                                            @for($dia = 1; $dia <= 5; $dia++)
                                                <td class="text-center form-group">
                                                    <select class="selectpicker form-control select-center" id="horario{{$aula}}{{$dia}}" name="horario[{{$aula}}][{{$dia}}]">
                                                        <option data-tokens="ketchup mustard" data-nome="AULA VAGA" data-ch="0" value="0" selected> AULA VAGA </option>
                                                        @foreach($disciplinas as $disc)
                                                            @foreach($turma->aulas as $aul)
                                                                @if($aul->posicao == $aula && $aul->dia == $dia && $aul->disciplina_id == $disc->id)
                                                                    <option data-tokens="ketchup mustard" data-nome="{{$disc->nome}}" data-ch="{{$disc->aula_semanal}}" value="{{$disc->id}}" selected> {{ $disc->sigla }} </option>
                                                                @endif
                                                            @endforeach
                                                            <option data-tokens="ketchup mustard" data-nome="{{$disc->nome}}" data-ch="{{$disc->aula_semanal}}" value="{{$disc->id}}">{{ $disc->sigla }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            @endfor
                                        </tr>
                                    @endfor
                                @elseif($turma->turno == 'T')
                                    @for($aula = 5; $aula <= 8; $aula++ )
                                        <tr class="row text-uppercase">
                                            <td class="text-center" style="vertical-align: middle;"> {{$aula - 4}}ª AULA </td>
                                            @for($dia = 1; $dia <= 5; $dia++)
                                                <td class="text-center">
                                                    <select class="selectpicker form-control select-center" id="horario{{$aula}}{{$dia}}" name="horario[{{$aula}}][{{$dia}}]">
                                                        <option data-tokens="ketchup mustard" data-nome="AULA VAGA" data-ch="0" value="0" selected> AULA VAGA </option>
                                                        @foreach($disciplinas as $disc)
                                                            @foreach($turma->aulas as $aul)
                                                                @if($aul->posicao == $aula && $aul->dia == $dia && $aul->disciplina_id == $disc->id)
                                                                    <option data-tokens="ketchup mustard" data-nome="{{$disc->nome}}" data-ch="{{$disc->aula_semanal}}" value="{{$disc->id}}" selected> {{ $disc->sigla }} </option>
                                                                @endif
                                                            @endforeach
                                                            <option data-tokens="ketchup mustard" data-nome="{{$disc->nome}}" data-ch="{{$disc->aula_semanal}}" value="{{$disc->id}}">{{ $disc->sigla }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            @endfor
                                        </tr>
                                    @endfor
                                @elseif($turma->turno == 'N')
                                    @for($aula = 9; $aula <= 12; $aula++ )
                                        <tr class="row text-uppercase">
                                            <td class="text-center" style="vertical-align: middle;"> {{$aula - 8}}ª AULA </td>
                                            @for($dia = 1; $dia <= 5; $dia++)
                                                <td class="text-center">
                                                    <select class="selectpicker form-control select-center" id="horario{{$aula}}{{$dia}}" name="horario[{{$aula}}][{{$dia}}]">
                                                        <option data-tokens="ketchup mustard" data-nome="AULA VAGA" data-ch="0" value="0" selected> AULA VAGA </option>
                                                        @foreach($disciplinas as $disc)
                                                            @foreach($turma->aulas as $aul)
                                                                @if($aul->posicao == $aula && $aul->dia == $dia && $aul->disciplina_id == $disc->id)
                                                                    <option data-tokens="ketchup mustard" data-nome="{{$disc->nome}}" data-ch="{{$disc->aula_semanal}}" value="{{$disc->id}}" selected> {{ $disc->sigla }} </option>
                                                                @endif
                                                            @endforeach
                                                            <option data-tokens="ketchup mustard" data-nome="{{$disc->nome}}" data-ch="{{$disc->aula_semanal}}" value="{{$disc->id}}">{{ $disc->sigla }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            @endfor
                                        </tr>
                                    @endfor
                                @endif
                            </table>
                        </div>

                        <div class="row col-md-8 col-md-offset-2" style="margin-top: -2em">
                           <span class="help-block text-center" ">
                               <strong id="table-1"></strong>
                           </span>
                        </div>

                        @if($turma->turno == 'D')
                            <div class="row col-md-8 col-md-offset-2" style="margin-top: 2em">
                                <div class="titulo"> 
                                    <h4 class="text-center text-uppercase">
                                        <strong> HORÁRIO DA TARDE: </strong>
                                    </h4>
                                </div>
                            </div>

                            <div class="table-responsive col-md-12">
                                <table class="table table-striped bunitu">
                                    <thead class="btn-primary">
                                        <tr class="row text-uppercase">
                                            <th class="text-center">AULA</th>
                                            <th class="text-center">SEGUNDA</th>
                                            <th class="text-center">TERÇA</th>
                                            <th class="text-center">QUARTA</th>
                                            <th class="text-center">QUINTA</th>
                                            <th class="text-center">SEXTA</th>
                                        </tr>
                                    </thead>

                                    @for($aula = 5; $aula <= 8; $aula++ )
                                        <tr class="row text-uppercase">
                                            <td class="text-center" style="vertical-align: middle;"> {{$aula - 4}}ª AULA </td>
                                            @for($dia = 1; $dia <= 5; $dia++)
                                                <td class="text-center">
                                                    <select class="selectpicker form-control select-center" id="horario{{$aula}}{{$dia}}" name="horario[{{$aula}}][{{$dia}}]">
                                                        <option data-tokens="ketchup mustard" data-nome="AULA VAGA" data-ch="0" value="0" selected> AULA VAGA </option>
                                                        @foreach($disciplinas as $disc)
                                                            @foreach($turma->aulas as $aul)
                                                                @if($aul->posicao == $aula && $aul->dia == $dia && $aul->disciplina_id == $disc->id)
                                                                    <option data-tokens="ketchup mustard" data-nome="{{$disc->nome}}" data-ch="{{$disc->aula_semanal}}" value="{{$disc->id}}" selected> {{ $disc->sigla }} </option>
                                                                @endif
                                                            @endforeach
                                                        <option data-tokens="ketchup mustard" data-nome="{{$disc->nome}}" data-ch="{{$disc->aula_semanal}}" value="{{$disc->id}}">{{ $disc->sigla }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            @endfor
                                        </tr>
                                    @endfor
                                </table>
                            </div>

                            <div class="row col-md-8 col-md-offset-2" style="margin-top: -2em">
                               <span class="help-block text-center" ">
                                   <strong id="table-2"></strong>
                               </span>
                            </div>
                        @endif

                        <div class="row col-md-12">

                            <div class="row col-md-8 col-md-offset-2" style="margin-bottom: 2em">
                                <div id="tituloDisciplina" class="titulo" data-disciplinas="{{$disciplinas->count()}}"> 
                                    <h4 class="text-center text-uppercase">
                                        <strong> Disciplinas: </strong>
                                    </h4>
                                </div>
                            </div>
                          
                            @foreach($disciplinas as $disc)
                               <div class="row col-md-12">
                                    <div class="form-group col-md-6 disciplina{{$disc->id}}">
                                        <div class="col-md-12">
                                            <input id="disciplina{{$loop->iteration}}" name="disciplina[{{$disc->id}}]" maxlength="160" value="{{$disc->sigla}} - {{$disc->nome}}" data-id="{{$disc->id}}" data-nome="{{$disc->nome}}" data-ch="{{$disc->aula_semanal}}" class="form-control input-md" type="text" readonly>

                                            <span class="help-block text-center">
                                               <strong id="disciplina{{$disc->id}}{{$disc->id}}"></strong>
                                           </span>
                                        </div>

                                    </div>

                                    <div class="form-group col-md-6 professor{{$disc->id}}">
                                        <label class="col-md-3 control-label" for="professor">Professor:</label>
                                        <div class="col-md-9">

                                            <select class="selectpicker form-control text-uppercase" id="professor{{$disc->id}}" name="professor[{{$disc->id}}]">
                                                @if(empty($disc->professor_id))
                                                    <option data-tokens="ketchup mustard" value="0" selected> -- SELECIONE O PROFESSOR --</option>
                                                @endif

                                                 @foreach($professores as $prof)
                                                    @if($prof->id == $disc->professor_id)
                                                        <option data-tokens="ketchup mustard" value="{{$prof->id}}" selected>{{$prof->usuario->username}}</option>
                                                    @endif
                                                    <option data-tokens="ketchup mustard" value="{{$prof->id}}">{{$prof->usuario->username}}</option>
                                                @endforeach 
                                            </select>

                                           <span class="help-block text-center" ">
                                               <strong id="professor{{$disc->id}}{{$disc->id}}"></strong>
                                           </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group col-md-12" ></div>
                        <div class="form-group col-md-12" ></div>

                        <div class="row col-md-7 col-md-offset-3">
                            <div class="form-group col-md-5">
                                <button id="Editar" type="submit" class="btn btn-block btn-lg btn-success">
                                    Salvar
                                </button>     
                            </div>

                            <div class="form-group col-md-2" ></div>

                            <div class="form-group col-md-5">
                                <a href="{{route('turma.show')}}" class="btn btn-block btn-lg btn-danger">
                                    Cancelar
                                </a>   
                            </div>
                        </div>

                        <div class="row col-md-8 col-md-offset-2">
                            <div id="alert" class="text-center alert alert-danger alert-block" style="display: none">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong id="mensagem"></strong>
                            </div>
                        </div>

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="put">
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection