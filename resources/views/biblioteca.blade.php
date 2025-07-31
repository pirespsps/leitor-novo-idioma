@extends('layouts.principal-layout')

@section('conteudo')
  <div class="container-fluid mt-5" id="containerDocumentos">

    @foreach ($documentos as $documento)

    <a class="linkBib" href="/documento/ler/{{ $documento->id }}">
      
    <div class="containerDocumento container-fluid">
      <h3>
      {{ $documento->titulo }}
      <small class="text-muted">{{ $documento->idioma }}</small>
      </h3>
      <p>{{ $documento->pagina + 1 }}/{{ $documento->paginasTotais }}</p>
      <p><small>{{ $documento->pathArquivo }}</small></p>
    </a>

    <button class="rmvBotao btn btn-danger" value="{{ $documento->id }}"> <img class="removeImg"
      src="{{ asset("images/removeIcon.png") }}"></button>

    </div>
  @endforeach

  </div>
@endsection