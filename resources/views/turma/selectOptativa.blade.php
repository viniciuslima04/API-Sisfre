@if(!empty($disciplinasOptativas && !empty($quantidade)) )                                
    <div class="titulo" id="titulo" data-qtdOptativas="{{$quantidade}}"> 
        <h4 class="text-center">Selecione a(s) disciplina(s) optativa(s) ofertada(s):</h4>
    </div>

    <div class="form-group col-md-12"></div>

    @for($i = 1; $i<=$quantidade;$i++)
        <div class="form-group col-md-12 optativa{{$i}}">
            <label for="optativa{{$i}}" class="col-md-2 col-md-offset-1 control-label">Optativa {{$i}}:</label>
            <div class="col-md-8">
                <select class="selectpicker form-control text-uppercase" name="optativa[]" id="optativa{{$i}}">
                    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE A DISCIPLINA --- </option>
                    @foreach ($disciplinasOptativas as $discOpt)
                        @if(old('optativa.$i') == $discOpt->id)
                            <option data-tokens="ketchup mustard" value="{{$discOpt->id}}" selected> {{$$discOpt->nome}} </option>
                        @endif
                        <option data-tokens="ketchup mustard" value="{{$discOpt->id}}"> {{$discOpt->nome}} </option>
                    @endforeach
                </select>

                <span class="form-group col-md-12">
                    <strong id="optativa{{$i}}{{$i}}"></strong>
                </span>
            </div>
        </div>
    @endfor

@endif