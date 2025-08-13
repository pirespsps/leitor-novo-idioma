@extends('layouts.principal-layout')

@section('conteudo')
<div class="container-fluid mt-3 col" id="idiomas">

@foreach ($idiomas as $idioma)
    <a class="container btn btn-secondary p-3 col-sm-3" href="/palavras/{{$idioma[1]}}">
    {{  $idioma[0] }}
    </a>
@endforeach
</div>
@endsection
