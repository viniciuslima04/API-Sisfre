@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
            $color = 'green';
            break;
        case 'error':
            $color = 'red';
            break;
        default:
            $color = 'blue';
    }
?>
@component('mail::table')
| PROFESSOR       | DISCIPLINA         | TURMA            | DIA         | QTD           |
| --------------- |:------------------:|:----------------:|:-----------:|--------------:|
| {{$falta->professor->usuario->username}}        | {{$falta->disciplina->nome}}      | {{$falta->turma->descricao}}      | {{ implode("/", array_reverse(explode("-", $falta->dia))) }}| {{$falta->qtd}} |
@endcomponent

@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Atenciosamente'),<br>@lang('SISFRE - Sistema de Gerenciamento de Faltas e Reposições')
@endif

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
@lang(
    "Se você não conseguiu clicar no botão: \":actionText\",  copie e cole no seu navegador\n".
    'o link a seguir: [:actionURL](:actionURL)',
    [
        'actionText' => $actionText,
        'actionURL' => $actionUrl
    ]
)
@endcomponent
@endisset
@endcomponent
