@extends('layout.base')

@section('titulo','Cadastrar Usuários')

@section('conteudo')
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Cadastrar Usuário</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('usuario.store') }}">
                           
                           <div class="form-group {{ $errors->has('acesso') ? ' has-error' : '' }}">
                                <label for="acesso" class="col-md-4 control-label" >Tipo:</label>
                                <div class="col-md-6"> 
                                    <select class="form-control" data-live-search="true" id="acesso" name="acesso">
                                        @if(old('acesso') == 4)
                                            <option data-tokens="ketchup mustard" value= "4" selected> ADMINISTRADOR </option>
                                        @elseif(old('acesso') == 1)
                                            <option data-tokens="ketchup mustard" value= "1" selected> FUNCIONÁRIO </option>
                                        @elseif(old('acesso') == 2)
                                            <option data-tokens="ketchup mustard" value= "2" selected> PROFESSOR </option>
                                        @else
                                            <option data-tokens="ketchup mustard" value= "0" selected> SELECIONE... </option>
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

                            <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="username" class="col-md-4 control-label">Usuário: </label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control text-uppercase" name="username" value="{{ old('username') }}">

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
                                    <input id="abreviatura" type="text" class="form-control text-uppercase" maxlength="10" name="abreviatura" value="{{ old('abreviatura') }}" placeholder="Ex: Pedro Carlos = PC">

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
                                    <input id="email" type="email" class="form-control text-lowercase" name="email" value="{{ old('email') }}">

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
                                    <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}">

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
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}">

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
                                        <button type="submit" class="btn btn-block btn-lg btn-success">
                                            Cadastrar
                                        </button>     
                                </div>

                                <div class="form-group col-md-2" ></div>

                                <div class="form-group col-md-5">
                                    <a href="{{route('home')}}" class="btn btn-block btn-lg btn-danger">
                                        Cancelar
                                    </a>   
                                </div>
                            </div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                    </div>
                </div>
            </div>
@endsection
