@extends('layouts.principal-layout')

@section('conteudo')

<div class="container" id="bodyPalavras">

<div class="container-fluid mt-4">
    <div class="container-fluid" id="exercicios">

    <a href="/palavras/{{ $idioma }}/praticar">
        <div class="exercicio">
            <img src="{{ asset('images/dailyIcon.png') }}">
            <p class="fw-bold">Revisão do dia</p>
        </div>
        </a>
    </div>
</div>

<div class="container">
    <!-- botar pagination depois -->

    <table class="table table-striped table-bordered table-hover mt-5">
        <thead class="thead-dark table-primary">
            <th>#</th>
            <th>Palavra</th>
            <th>Significado</th>
            <th>Aprendida</th>
        </thead>
        <tbody>
            @foreach ($palavras as $palavra)
                <tr>
                    <td>{{ $palavra['id'] }}</td>
                    <td>{{ $palavra['original'] }}</td>
                    <td>{{ $palavra['significado'] }}</td>
                    <td>{{ $palavra['data'] }}</td>

                </tr>
            @endforeach

        </tbody>
    </table>
</div>
</div>


@endsection