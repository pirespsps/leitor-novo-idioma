<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Models\Palavra;

class PraticaController extends Controller
{
    public function index(Request $request, $idioma){
        //fazer em uma query depois


        $ultimaData = Palavra::whereRaw('idioma = ?',$idioma)
                                    ->orderBy('created_at','DESC')
                                    ->value(DB::raw('DATE(created_at)'));

        $palavras = Palavra::select(['palavraOriginal','significado'])
                                ->whereRaw('DATE(created_at) = ? AND idioma = ?',[$ultimaData,$idioma])
                                ->get()
                                ->map(function($palavra){
                                    return ['palavra' => ucfirst($palavra->palavraOriginal),
                                            'significado' => $palavra->significado];
                                })
                                ->toArray();


        return view('praticar', ['palavras' => $palavras, 'tamanho' => sizeof($palavras)]);
    }

    public function resultado(Request $request){

        return view('praticar-resultado');
    }

}
