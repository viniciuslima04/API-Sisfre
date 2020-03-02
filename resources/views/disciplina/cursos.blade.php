@if(!empty($cursos) && !empty($quantidade))
    @for($i=1; $i<=$quantidade; $i++)
        <div class="panel panel-primary">
            <div class="panel-body">
                <h3 class="text-on-pannel text-primary"><strong class="text-uppercase"> Curso {{$i + 1}} </strong></h3>
                <div class="row col-md-12 col-md-offset-0">                    
                    <div class="form-group col-md-12 curso{{$i}}">
                        <label for="curso" class="col-md-3 control-label">Curso:</label>
                        <div class="col-md-8">
                            <select class="selectpicker form-control text-uppercase" name="curso[]" id="curso{{$i}}" data-num="{{$i}}" data-periodo="#periodo{{$i}}">
                                <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O CURSO --- </option>
                                @foreach ($cursos as $curso)
                                    @if(old('curso.$i') == $curso->id)
                                        <option data-tokens="ketchup mustard" value="{{$curso->id}}" selected> {{$curso->nome}} </option>
                                    @endif
                                    <option data-tokens="ketchup mustard" value="{{$curso->id}}"> {{$curso->nome}} </option>
                                @endforeach
                            </select>


                            <span class="help-block">
                                 <strong id="curso{{$i}}{{$i}}"></strong>
                            </span>

                        </div>
                    </div>

                    <div id="periodo{{$i}}" class="row col-md-11 col-md-offset-1">
                        
                    </div>

                    <div id="optativa{{$i}}" class="row col-md-11 col-md-offset-1">
                        
                    </div>
                </div>
            </div>
        </div>
    @endfor
@endif