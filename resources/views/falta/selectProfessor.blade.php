@if(!empty($professores) )                                
    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O PROFESSOR --- </option>
    @foreach ($professores as $prof)
        @if(old('professor') == $prof->id)
            <option data-tokens="ketchup mustard" value="{{$prof->id}}" selected> {{$prof->username}} </option>
        @endif
        <option data-tokens="ketchup mustard" value="{{$prof->id}}"> {{$prof->username}} </option>
    @endforeach
@endif