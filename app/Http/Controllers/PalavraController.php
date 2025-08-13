<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Palavra;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PalavraController extends Controller
{

    public function index()
    {
        //$idiomas = Palavra::all("idioma")->groupBy('idioma')->toArray();
        $idiomas = DB::table('tbPalavra')->distinct()->get('idioma')->toArray();
        $idiomaAr = [];

        foreach ($idiomas as $idioma) {
            $idiomaStr = $idioma->idioma;
            $idiomaAr[] = [$this->isoToPalavra($idiomaStr), $idioma->idioma];
        }

        return view(
            'palavras',
            ['idiomas' => $idiomaAr]
        );
    }

    public function lerIdioma(Request $request, $idioma){

        $palavras = Palavra::select(['id','palavraOriginal','significado','created_at'])
                             ->whereRaw('idioma = ?', [$idioma])
                             ->orderBy('created_at','DESC')
                             ->get()
                             ->map(function($palavra){
                                return [
                                    'original' => $palavra->palavraOriginal,
                                    'significado' => $palavra->significado,
                                    'data' => $palavra->created_at->format('d/m/Y'),
                                    'id' => $palavra->id
                                ];
                             })
                             ->toArray();

        return view(
            'leitor-palavras',
            ['palavras' => $palavras]
        );
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

        Session::push('palavras', $palavra);

        $palavra->save();

    }

    //criar classe de formatação
    private function isoToPalavra($iso){
        $idiomas = [
            'pt' => 'Português',
            'en' => 'Inglês',
            'es' => 'Espanhol',
            'fr' => 'Francês',
            'it' => 'Italiano'
        ];
       return $idiomas[$iso] ?? 'Indefinido';
    }

}
