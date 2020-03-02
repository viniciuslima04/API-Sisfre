@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => route('login')])
           </b>SISFRE<b>
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            &copy; {{ date('Y') }} SISFRE. Todos os direitos reservados.
        @endcomponent
    @endslot
@endcomponent
