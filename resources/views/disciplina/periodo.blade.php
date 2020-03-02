@if(!empty($curso) )                                
    <div class="titulo" id="titulo" data-duracao="{{$curso->duracao}}"> 
        <h4 class="text-center">Quantidade de Aulas por Periodo:</h4>
    </div>
    @for($i = 1; $i<=$curso->duracao;$i++)

        <div class="form-group col-md-4 periodo{{$curso->id}}{{$i}}">
            <label for="periodo{{$curso->id}}{{$i}}" class="col-md-2 col-md-offset-1 control-label">S{{$i}}:</label>
            <div class="col-md-8">
                <input id="periodo{{$curso->id}}{{$i}}" type="text" maxlength="2" class="form-control disciplina-optativa" name="periodo[{{$curso->id}}][{{$i}}]"
                data-periodo="{{$i}}">

                <label><input id="optativa{{$curso->id}}{{$i}}" type="checkbox" name="optativa[{{$curso->id}}][{{$i}}]"> Optativa </input></label>
            </div>
        </div>
    @endfor

    <span class="form-group col-md-12 col-md-offset-1">
        <strong id="periodo{{$curso->id}}{{$curso->id}}{{$curso->id}}"></strong>
    </span>
@endif