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

    public function lerIdioma(Request $request, $idioma)
    {

        $palavras = Palavra::whereRaw('idioma = ?', [$idioma])->get();
        $palavrasAr = [];

        foreach ($palavras as $palavra) {
            $palavrasAr[] = [
                'original' => $palavra->palavraOriginal,
                'significado' => $palavra->significado,
                'data' => $this->formatarData($palavra->created_at)
            ];
        }

        return view(
            'leitor-palavras',
            ['palavras' => $palavrasAr]
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

    private function formatarData($data){
        $ano = substr($data,0,4);
        $mes = substr($data,5,2);
        $dia = substr($data,8,2);
        return "$dia/$mes/$ano";
    }

    private function isoToPalavra($iso)
    {
        switch ($iso) {
            case 'pt':
                return "Português";
            case 'en':
                return "Inglês";
            case 'es':
                return "Espanhol";
            case 'fr':
                return "Francês";
            case 'it':
                return "Italiano";
            default:
                return 'Indefinido';
        }
    }

}
