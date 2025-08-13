@extends('layouts.principal-layout')

@section('conteudo')

<!-- criar table.... -->
@foreach ($palavras as $palavra)

{{ $palavra['original'] }} = {{ $palavra['significado'] }} | {{ $palavra['data'] }}

<br> 
<br>
@endforeach


@endsection
