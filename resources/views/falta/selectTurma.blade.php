@if(!empty($turmas) )                                
    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE A TURMA --- </option>
    @foreach ($turmas as $turma)
        @if(old('turma') == $turma->id)
            <option data-tokens="ketchup mustard" value="{{$turma->id}}" selected> {{$turma->descricao}} </option>
        @endif
        <option data-tokens="ketchup mustard" value="{{$turma->id}}"> {{$turma->descricao}} </option>
    @endforeach
@endif