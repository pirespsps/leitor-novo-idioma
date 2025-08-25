@extends('layouts.principal-layout')

@section('conteudo')

    <div class="container bg-secondary mt-5" id="formPratica">
        <!-- pegar idioma certinho -->

        <form class="pt-1" method="POST" action="{{ route('praticar-resultado', ['idioma' => 'da']) }}">
            @csrf
            
            @foreach ($palavras as $palavra)
                <input type="hidden" name="palavras[]" value="{{ $palavra['palavra'] }}">
                <input type="hidden" name="significados[]" value="{{ $palavra['significado'] }}">
            @endforeach

            <table class="table table-striped table-bordered table-hover table-secondary mt-5">
                <thead class="thead-dark table-primary">
                    <th>Palavra</th>
                    <th>Significado</th>
                </thead>
                <tbody>
                    @foreach ($palavras as $palavra)
                        <tr>
                            <td>{{ $palavra['palavra'] }}</td>
                            <td><input class="form-control" type="text" name="tentativas[]" placeholder="Significado..." required></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <input type="submit" class="btn btn-success mt-5 text-center d-block mx-auto" value="Confirmar">
        </form>

@endsection

@section('script')
    @vite('resources/js/praticar.js')
@endsection