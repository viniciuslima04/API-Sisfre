@if(!empty($semestres) )                                
    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O SEMESTRE --- </option>
    @foreach ($semestres as $semestr)
        @if(old('semestre1') == $semestr->id)
            <option data-tokens="ketchup mustard" value="{{$semestr->id}}" selected> {{$semestr->ano}}.{{$semestr->etapa}} ({{$semestr->tipo}}) </option>
        @endif
        <option data-tokens="ketchup mustard" value="{{$semestr->id}}"> {{$semestr->ano}}.{{$semestr->etapa}} ({{$semestr->tipo}}) </option>
    @endforeach
@endif