<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Palavra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PalavraController extends Controller
{
    public function salvarPalavra(Request $request)
    {

        $palavraStr = $request->input("palavra");
        $significado = $request->input("significado");
        $idioma = session("documento.idioma");

        $palavra = new Palavra();
        $palavra->palavraOriginal = $palavraStr;
        $palavra->significado = $significado;
        $palavra->idioma = $idioma;

        Session::push('palavras',$palavra);

        // $palavras = session('palavras');
        // array_push($palavras,$palavra);
        // session(['palavras'=>$palavras]);

        $palavra->save();

    }
}
