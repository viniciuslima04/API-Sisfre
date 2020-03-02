@if(!empty($disciplinas) )                                
    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE A DISCIPLINA --- </option>
    @foreach ($disciplinas as $disc)
        @if(old('disciplina') == $disc->id)
            <option data-tokens="ketchup mustard" value="{{$disc->id}}" selected> {{$disc->nome}} </option>
        @endif
        <option data-tokens="ketchup mustard" value="{{$disc->id}}"> {{$disc->nome}} </option>
    @endforeach
@endif