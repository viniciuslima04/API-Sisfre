@if(!empty($professores) )                                
    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O PROFESSOR --- </option>
    @foreach ($professores as $professor)
        @if(old('professor') == $professor->professor_id)
            <option data-tokens="ketchup mustard" value="{{$professor->professor_id}}" selected> {{$professor->username}}) </option>
        @endif
        <option data-tokens="ketchup mustard" value="{{$professor->professor_id}}"> {{$professor->username}}</option>
    @endforeach
@endif