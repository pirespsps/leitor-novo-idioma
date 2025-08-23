@extends('layouts.principal-layout')

@section('conteudo')

    <div class="container bg-secondary mt-5" id="formPratica">
        @foreach ($palavras as $palavra)
        <input type="hidden" name="palavras[]" value="{{ $palavra['palavra']."|".$palavra['significado'] }}">
        @endforeach

        <div class="container justify-content-end d-inline-flex">
            <p id="perguntaAtual">1</p>
            <p>/</p>
            <p>{{ $tamanho }}</p>
        </div>
        <h1 class="pt-2 text-center" id="palavra">{{ $palavras[0]['palavra'] }}</h1>
        <input class="form-control mt-4" type="text" placeholder="Significado..." id="resposta" required>
        <button class="btn btn-success mt-5" id="confirmBT">Confirmar</button>

    </div>

@endsection

@section('script')
    @vite('resources/js/praticar.js')
@endsection