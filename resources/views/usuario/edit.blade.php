@extends('layout.base')

@section('titulo','Editar Usuário')

@section('scripts')
    @include('scripts.outros')
@endsection

@section('conteudo')
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Atualizar Usuário</div>
                    <div class="panel-body">
                    <form class="form-horizontal editar" role="form" method="POST" action="{{route('usuario.update', $user->id) }}">
                      
                      @if( Auth::user()->acesso == 4) 
                           <div class="form-group {{ $errors->has('acesso') ? ' has-error' : '' }}">
                                <label for="acesso" class="col-md-4 control-label" >Tipo:</label>
                                <div class="col-md-6"> 
                                    <select class="form-control" data-live-search="true" id="acesso" name="acesso">
                                        @if($user->acesso == 4)
                                            <option data-tokens="ketchup mustard" value=" {{$user->acesso}}" selected> ADMINISTRADOR </option>
                                        @elseif($user->acesso == 1)
                                            <option data-tokens="ketchup mustard" value=" {{$user->acesso}}" selected> FUNCIONÁRIO </option>
                                        @elseif($user->acesso == 2)
                                            <option data-tokens="ketchup mustard" value=" {{$user->acesso}}" selected> PROFESSOR </option>
                                        @else
                                            <option data-tokens="ketchup mustard" value= "0" selected>SELECIONE...</option>
                                        @endif
                                            <option data-tokens="ketchup mustard" value= "4" > ADMINISTRADOR </option>
                                            <option data-tokens="ketchup mustard" value= "1" > FUNCIONÁRIO </option>
                                            <option data-tokens="ketchup mustard" value= "2" > PROFESSOR </option>

                                    </select>

                                    @if ($errors->has('acesso'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('acesso') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                      @else
                            <input type="hidden" name="acesso" value="{{ $user->acesso }}">
                      @endif
                            <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="username" class="col-md-4 control-label">Usuário: </label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control text-uppercase" name="username" @if(!empty(old('username'))) 
                                            value="{{ old('username') }}"
                                        @else 
                                            value="{{ $user->username }}" 
                                        @endif
                                        />

                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('abreviatura') ? ' has-error' : '' }}">
                                <label for="abreviatura" class="col-md-4 control-label">Abreviatura: </label>

                                <div class="col-md-6">
                                    <input id="abreviatura" type="text" class="form-control text-uppercase" name="abreviatura" 
                                        @if(!empty(old('abreviatura'))) 
                                            value="{{ old('abreviatura') }}"
                                        @else 
                                            value="{{ $user->abreviatura }}" 
                                        @endif
                                        placeholder="Ex: Pedro Carlos = PC"/>

                                    @if ($errors->has('abreviatura'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('abreviatura') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail: </label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control text-lowercase" name="email" @if(!empty(old('email'))) 
                                            value="{{ old('email') }}"
                                        @else 
                                            value="{{ $user->email }}" 
                                        @endif
                                        />

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Senha: </label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password"/>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password_confirmation" class="col-md-4 control-label">Confirmar Senha: </label>

                                <div class="col-md-6">
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation"/>

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
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
                                    <a href="{{route('usuario.show')}}" class="btn btn-block btn-lg btn-danger">
                                        Cancelar
                                    </a>   
                                </div>
                            </div>
                            
                            @include('layout.flash')

                            <div class="row col-md-8 col-md-offset-2">
                                <div id="alert" class="text-center alert alert-danger alert-block" style="display: none">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong id="mensagem"></strong>
                                </div>
                            </div>

                            <input type="hidden" name="_method" value="put">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        </form>
                    </div>
                </div>
            </div>
@endsection