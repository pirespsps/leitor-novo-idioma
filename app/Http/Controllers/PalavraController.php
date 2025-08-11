<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Palavra;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PalavraController extends Controller{

    public function index(){
        //$idiomas = Palavra::all("idioma")->groupBy('idioma')->toArray();
        $idiomas = DB::table('tbPalavra')->distinct()->get('idioma')->toArray();
        $palavrasIdioma = [];
        
        foreach($idiomas as $idioma){

            $palavrasIdioma[$idioma->idioma] = [];
            $palavras = Palavra::whereRaw('idioma = ?',[$idioma->idioma])->get();

            foreach($palavras as $palavra){
                $palavraOriginal = $palavra->palavraOriginal;
                $significado = $palavra->significado;
                array_push($palavrasIdioma[$idioma->idioma],[$palavraOriginal => $significado]);
            }

        }

        return view('palavras',
        ['dicionario' => $palavrasIdioma]);
    }
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

        $palavra->save();

    }
}
