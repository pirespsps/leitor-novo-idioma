@extends('layouts.principal-layout')

@section('conteudo')

    <div class="container-fluid row mt-3">

        <div class="indexOption container border rounded col-sm-5 p-2">
            <a href="/form" class="text-reset text-decoration-none">
                <h1 class="text-center">Novo Arquivo</h1>
            </a>
        </div>

        <div class="indexOption container border rounded col-sm-5 p-2">
            <a href="/biblioteca" class="text-reset text-decoration-none">
            <h1 class="text-center">Meus Arquivos</h1>
            </a>
        </div>

    </div>

@endsection