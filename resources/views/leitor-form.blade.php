@extends('layouts.principal-layout')

@section('conteudo')

    <div class="container rol mt-5 col-sm-4 p-2">

        <form action="{{ route('criar-documento') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="formClass container p-3 row">
                <h1>Novo Documento</h1>
                
                <label for="titulo">Título:</label>
                <input type="text" name="titulo">

                <label for="idioma">Idioma:</label>
                <select name="idioma">
                    <option value="en">Inglês</option>
                    <option value="fr">Francês</option>
                    <option value="it">Italiano</option>
                    <option value="es">Espanhol</option>
                    <option value="pt">Português</option>
                </select>

                <!-- radio -->
                 <label>Alinhamento:</label>
                 <div class="container">

                 <input id="left" type="radio" name="alignment" value="left" checked>
                 <label for="left">Esquerda</label>

                 <input id="center" type="radio" name="alignment" value="center">
                 <label for="center">Centro</label>
                 </div>

                 <label for="pdf">Arquivo:</label>
                <input type="file" name="pdf">

                <br>

                <button class="btn btn-secondary mt-4 p-2">Enviar</button>

        </form>
    </div>

    </div>
@endsection