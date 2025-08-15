<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use App\Models\Palavra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class LeitorController extends Controller
{


    public function primeiraLeitura(Request $request, int $id)
    {

        $doc = Documento::find($id);

        $palavras = $this->getPalavras($doc->idioma);
        session(['palavras' => $palavras]);

        if (session('documento.id') !== $doc->id) {
            session([
                'documento' => [
                    'id' => (int) $doc->id,
                    'pagina' => $doc->pagina,
                    'path' => $doc->pathArquivo,
                    'idioma' => $doc->idioma
                ]
            ]);
        }

        return view('leitor', [
            "titulo" => $doc->titulo,
            "paginaAtual" => $doc->pagina,
            "paginasTotais" => $doc->paginasTotais,
            "alinhamento" => $doc->alinhamento,
        ]);

    }

    public function lerAxios(Request $request)
    {

        $pagina = $request->input('pagina');

        $arrayDoc = session('documento');
        $arrayDoc['pagina'] = $pagina;

        $leitor = new Parser();
        $pdf = $leitor->parseContent(Storage::get($arrayDoc['path']));

        $arrayPos = $pdf->getPages()[$pagina]->getDataTm();

        $linhas = $this->toLinhas($arrayPos);

        session(['documento' => $arrayDoc]);

        $palavras = session('palavras');
        $palavrasArray = [];

        //apagar depois de mudar para o session['palavras'] para array
        if (!is_null($palavras) && !sizeof($palavras) == 0) {
            foreach ($palavras as $palavra) {
                $palavrasArray[$palavra->palavraOriginal] = $palavra->significado;
            }
        }

        $pagina++;

        return response()->json([
        'idioma' => $arrayDoc['idioma'],
        'linhas' => $linhas,
        'pagina' => $pagina,
        'palavras' => $palavrasArray
    ]);
    }

    public function salvarPagina(Request $request)
    {

        $arrayDoc = $request->session()->get('documento');
        $doc = Documento::find($arrayDoc['id']);
        $doc->pagina = $arrayDoc['pagina'];

        $doc->save();
    }

    private function toLinhas($texto)
    {

        $linhas = [];
        $indexLinha = 0;
        $yLinhaAtual = "";


        if (empty($texto) || !is_array($texto[0])) {
            return $linhas;
        }

        foreach ($texto as $pedaco) {

            if (floor($pedaco[0][5]) != $yLinhaAtual) {
                $indexLinha++;
                $yLinhaAtual = floor($pedaco[0][5]);
            }

            $palavras = $this->separarString($pedaco[1]);

            foreach ($palavras as $palavra) {
                $linhas[$indexLinha][] = $palavra;
            }
        }

        return $linhas;
    }

    private function separarString($str)
    {
        $str = trim($str);
        $novoArray = [];
        if (str_contains($str, " ")) {
            $arrayStr = explode(" ", $str);
            foreach ($arrayStr as $palavra) {
                array_push($novoArray, $palavra);
                array_push($novoArray, " ");
            }
            return $novoArray;
        } else {
            return [$str];
        }
    }

    private function getPalavras($idioma)
    {

        //salvar direto como array
        if (session('documento.idioma') != $idioma) {
            $palavras = Palavra::whereRaw("idioma = ?", [$idioma])->get();
            return $palavras;
        } else {
            return session('palavras');
        }
    }

}