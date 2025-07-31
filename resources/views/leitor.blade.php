@extends('layouts.principal-layout')

@section('conteudo')

    <div class="mt-4 mb-3" id="textoContainer">

        <div class="container w-100 headerContainer">
            <p class="titulo">{{ $titulo }}</p>
            <p>
            <div id="paginaAtual">{{$paginaAtual + 1}}</div>
            /
            <div id="paginasTotais">{{ $paginasTotais }} </div>
            </p>
        </div>

        <div class="container p-3" id="textoDoc" style="justify-content:{{ $alinhamento }}">
            <!-- texto... -->
        </div>

        <div class="container mt-3 mb-3" id="botoesLeitor">

            <button class="btn btn-outline-primary col-md-1" id="paginaAnterior">
                << </button>
                    <button class="btn btn-outline-primary col-md-1" id="paginaPosterior"> >> </button>

        </div>

    </div>

    <!-- Popup -->
    <div class="container" id="popupPalavra" hidden>
        <meta name="token" content="{{ csrf_token() }}">
        <meta name ="rota" content="{{ route('salvar-palavra') }}">
        <div class="headerContainer">
            <p class="titulo">Definir significado</p>
        </div>
        <h2 id="palavra">Palavra</h2>
        <input type="text" id="significado" class="form-control" placeholder="Significado...">
        <div class="container mt-5 mb-2 botoes">
            <button id="confirmarPopup" class="btn btn-primary">Confirmar</button>
            <button id="cancelarPopup" class="btn btn-secondary">Cancelar</button>
        </div>

    </div>

@endsection

@section('script')
    @vite('resources/js/leitor.js')
@endsection