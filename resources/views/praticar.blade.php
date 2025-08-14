@extends('layouts.principal-layout')

@section('conteudo')

<div class="container bg-secondary mt-5" id="formPratica">

<h1 class="pt-4 text-center">{{ $palavras[0]['palavra'] }}</h1>
<input class="form-control mt-4" type="text" placeholder="Significado...">
<button class="btn btn-success mt-5">Confirmar</button>

</div>

@endsection