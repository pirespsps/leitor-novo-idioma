<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Documento;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class LeitorFormController extends Controller
{
     public function index(Request $request)
    {
        return view('leitor-form');
    }

    public function createDocument(Request $request){
        //criar controller especifico pro form..

        $request->validate([
            'pdf' => 'required|mimes:pdf',
            'titulo' => 'required',
            'idioma' => 'required'
        ]);

        $titulo = trim($request->post("titulo"));
        $arquivo = $request->file('pdf');
        $alinhamento = $request->post("alignment");
        $idioma = $request->post("idioma");

        $path = "documentos/";
        $nomeArquivo = preg_replace('/[^a-z0-9]/i', '', strtolower($titulo));
        $path .= $nomeArquivo . "_" . time();
        $path .= ".pdf";

        $doc = new Documento();
        $leitor = new Parser();
        $pdf = $leitor->parseFile($arquivo);

        $doc->titulo = $titulo;
        $doc->pathArquivo = $path;
        $doc->idioma = $idioma;
        $doc->alinhamento = $alinhamento;
        $doc->pagina = 0;
        $doc->paginasTotais = sizeof($pdf->getPages());

        if($request->hasFile('pdf')){
            Storage::disk('local')->put($path,file_get_contents($request->file('pdf')));
        }

        $doc->save();

        return redirect('biblioteca');
    }
}
