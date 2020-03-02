@extends('layout.base')

@section('titulo','Editar Disciplina')

@section('scripts')
    @include('scripts.disciplina')
    @include('scripts.validation-disciplina')
    @include('scripts.outros')
@endsection

@section('conteudo')
<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">Editar Disciplina</div>
        <div class="panel-body">
            <form id="cadDisc" class="form-horizontal editar" role="form" method="POST" action="{{route('disciplina.update',$disciplina->id)}}">
               
                <div class="row col-md-12 col-md-offset-0">
                    <div class="form-group col-md-8 disciplina {{ $errors->has('disciplina') ? ' has-error' : '' }}">
                        <label for="disciplina" class="col-md-3 control-label">Nome:</label>
                        <div class="col-md-8">
                            <input id="disciplina" type="text" class="text-uppercase form-control" name="disciplina" 
                                @if(!empty(old('disciplina'))) 
                                    value="{{ old('disciplina') }}"
                                @else 
                                    value="{{ $disciplina->nome }}" 
                                @endif
                            />

                            <span class="help-block">
                                <strong id="disciplina1"></strong>
                            </span>

                            @if ($errors->has('disciplina'))
                                <span class="help-block">
                                     <strong >{{ $errors->first('disciplina') }}</strong>
                                </span> 
                            @endif

                        </div>
                    </div>

                    <div class="form-group col-md-4 sigla {{ $errors->has('sigla') ? ' has-error' : '' }}">
                        <label for="sigla" class="col-md-3 control-label">Sigla:</label>
                        <div class="col-md-8">
                            <input id="sigla" type="text" class="text-uppercase form-control" maxlength="6" name="sigla"                                 
                                @if(!empty(old('sigla'))) 
                                    value="{{ old('sigla') }}"
                                @else 
                                    value="{{ $disciplina->sigla }}" 
                                @endif
                            />

                            <span class="help-block">
                                <strong id="sigla1"></strong>
                            </span>

                            @if ($errors->has('sigla'))
                                <span class="help-block">
                                     <strong >{{ $errors->first('sigla') }}</strong>
                                </span> 
                            @endif
                        </div>
                    </div>
                </div>

                @if(!empty($relacoes))
                    @foreach($relacoes as $curs)
                        @if($loop->iteration == 1 )
                            <div class="row col-md-12 col-md-offset-0">
                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        <h3 class="text-on-pannel text-primary"><strong class="text-uppercase"> Curso {{$loop->iteration}} </strong></h3>
                                        <div class="row col-md-12 col-md-offset-0">
                                            <div class="form-group col-md-12 curso0">
                                                <label for="curso" class="col-md-3 control-label">Curso:</label>
                                                <div class="col-md-8">
                                                    <select class="selectpicker form-control" name="curso[]" id="curso0" data-num="0" data-periodo="#periodo0" data-cursos="{{$cursos->count()}}">
                                                        <option data-tokens="ketchup mustard" value="{{$curs['id']}}" selected> {{$curs['nome']}} </option>
                                                        @foreach ($cursos as $curso)
                                                            @if(old('curso.0') == $curso->id)
                                                                <option data-tokens="ketchup mustard" value="{{$curso->id}}" selected> {{$curso->nome}} </option>
                                                            @endif
                                                            <option data-tokens="ketchup mustard" value="{{$curso->id}}"> {{$curso->nome}} </option>
                                                        @endforeach
                                                    </select>


                                                    <span class="help-block">
                                                         <strong id="curso00"></strong>
                                                    </span>

                                                </div>
                                            </div>
                                        </div>

                                        <div id="periodo0" class="row col-md-11 col-md-offset-1">
                                            <div class="titulo" id="titulo" data-duracao="{{$curs['duracao']}}"> 
                                                <h4 class="text-center">Quantidade de Aulas por Periodo:</h4>
                                            </div>
                                            @for($i = 1; $i<=$curs['duracao'];$i++)
                                                <div class="form-group col-md-4 periodo{{$curs['id']}}{{$i}}">
                                                    <label for="periodo{{$curs['id']}}{{$i}}" class="col-md-2 col-md-offset-1 control-label">S{{$i}}:</label>
                                                    <div class="col-md-8">
                                                        <input id="periodo{{$curs['id']}}{{$i}}" type="text" maxlength="2" class="form-control" name="periodo[{{$curs['id']}}][{{$i}}]"
                                                            @foreach ($curs[0] as $curso_id => $periodo) {
                                                                @foreach ($periodo as $periodo_valor => $aula) {
                                                                    @if($curso_id == $curs['id'] && $periodo_valor == $i)
                                                                        value = {{$aula}}
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        />

                                                        <label><input id="optativa{{$curs['id']}}{{$i}}" type="checkbox" name="optativa[{{$curs['id']}}][{{$i}}]"
                                                            @foreach ($curs[1] as $curso_id => $periodo) {
                                                                @foreach ($periodo as $periodo_valor => $optativa) {
                                                                    @if($curso_id == $curs['id'] && $periodo_valor == $i && $optativa == 1)
                                                                        checked
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                            > Optativa </input>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endfor

                                            <span class="form-group col-md-12 col-md-offset-1">
                                                <strong id="periodo{{$curs['id']}}{{$curs['id']}}{{$curs['id']}}"></strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row col-md-12 col-md-offset-0">
                                <div class="form-group col-md-8 {{ $errors->has('option') ? ' has-error' : '' }}">

                                    <div class="col-md-10 col-md-offset-3">
                                        <label class="checkbox-inline"><input type="checkbox" id="option" name="option" 
                                            @if($loop->count - 1 != 0)
                                                checked
                                            @endif
                                        >
                                            <b>Deseja adicionar mais cursos?</b>
                                        </label>    

                                    </div>

                                    @if ($errors->has('option'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('option') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div id="esconder" class="form-group col-md-4 qtd" 
                                    @if($loop->count == 1)
                                        style="display: none"
                                    @endif
                                >
                                    <label for="qtd" class="col-md-6 control-label">Quantidade:</label>
                                    <div class="col-md-5">
                                        <input id="qtd" type="text" class="form-control" maxlength="2" name="qtd"                                  
                                            @if(!empty(old('qtd'))) 
                                                value="{{ old('qtd') }}"
                                            @else 
                                                value="{{ $loop->count - 1 }}" 
                                            @endif
                                        />

                                        <span class="help-block">
                                            <strong id="qtd1"></strong>
                                        </span>
                                    </div>
                                </div>  
                            </div>
                            @if($loop->count == 1)
                                <div id='addCursos' class="row col-md-12 col-md-offset-0">

                                </div>
                            @endif

                        @else
                            @if($loop->iteration == 2) 
                                <div id='addCursos' class="row col-md-12 col-md-offset-0">
                            @endif
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <h3 class="text-on-pannel text-primary"><strong class="text-uppercase"> Curso {{$loop->iteration}} </strong></h3>
                                    <div class="row col-md-12 col-md-offset-0">                    
                                        <div class="form-group col-md-12 col-md-offset-0 curso{{$loop->iteration}}">
                                            <label for="curso" class="col-md-3 control-label">Curso:</label>
                                            <div class="col-md-8">
                                                <select class="selectpicker form-control" name="curso[]" id="curso{{$loop->iteration -1 }}" data-num="{{$loop->iteration - 1}}" data-periodo="#periodo{{$loop->iteration - 1}}">
                                                    <option data-tokens="ketchup mustard" value="{{$curs['id']}}" selected> {{$curs['nome']}} </option>
                                                    @foreach ($cursos as $curso)
                                                        @if(!empty(old('curso.$loop->iteration-1')))
                                                            @if(old('curso.$loop->iteration-1') == $curso->id)
                                                                <option data-tokens="ketchup mustard" value="{{$curso->id}}" selected> {{$curso->nome}} </option>
                                                            @endif
                                                        @endif
                                                        <option data-tokens="ketchup mustard" value="{{$curso->id}}"> {{$curso->nome}} </option>
                                                    @endforeach
                                                </select>


                                                <span class="help-block">
                                                     <strong id="curso{{$loop->iteration-1}}{{$loop->iteration-1}}"></strong>
                                                </span>

                                            </div>
                                        </div>
                                     
                                        <div id="periodo{{$loop->iteration-1}}" class="row col-md-11 col-md-offset-1">
                                            
                                            <div class="titulo" id="titulo" data-duracao="{{$curs['duracao']}}"> 
                                                <h4 class="text-center">Quantidade de Aulas por Periodo:</h4>
                                            </div>
                                            @for($i = 1; $i<=$curs['duracao'];$i++)
                                                <div class="form-group col-md-4 periodo{{$curs['id']}}{{$i}}">
                                                    <label for="periodo{{$curs['id']}}{{$i}}" class="col-md-2 col-md-offset-1 control-label">S{{$i}}:</label>
                                                    <div class="col-md-8">
                                                        <input id="periodo{{$curs['id']}}{{$i}}" type="text" maxlength="2" class="form-control" name="periodo[{{$curs['id']}}][{{$i}}]"
                                                            @foreach ($curs[0] as $curso_id => $periodo) {
                                                                @foreach ($periodo as $periodo_valor => $aula) {
                                                                    @if($curso_id == $curs['id'] && $periodo_valor == $i)
                                                                        value = {{$aula}}
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        />

                                                        <label><input id="optativa{{$curs['id']}}{{$i}}" type="checkbox" name="optativa[{{$curs['id']}}][{{$i}}]"
                                                            @foreach ($curs[1] as $curso_id => $periodo) {
                                                                @foreach ($periodo as $periodo_valor => $optativa) {
                                                                    @if($curso_id == $curs['id'] && $periodo_valor == $i && $optativa == 1)
                                                                        checked
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                            > Optativa </input>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endfor

                                            <span class="form-group col-md-12 col-md-offset-1">
                                                <strong id="periodo{{$curs['id']}}{{$curs['id']}}{{$curs['id']}}"></strong>
                                            </span> 
                                        </div>
                                    </div>
                                </div>
                            </div>   
                            @if($loop->last) 
                                </div>
                            @endif

                        @endif
                    @endforeach
                @endif
                
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
                        <a href="{{route('disciplina.show')}}" class="btn btn-block btn-lg btn-danger">
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
            </form>
        </div>
    </div>
</div>
@endsection