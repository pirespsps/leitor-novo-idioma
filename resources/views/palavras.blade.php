@extends('layouts.principal-layout')

@section('conteudo')
@foreach ($dicionario as $idioma => $palavras)
<div>
    {{ print_r($idioma) }}
    {{ print_r($palavras) }}
    <br>
    <br>
</div>
@endforeach
@endsection
