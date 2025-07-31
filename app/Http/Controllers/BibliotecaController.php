<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Documento;
use Illuminate\Support\Facades\Storage;

class BibliotecaController extends Controller
{
    public function index(Request $request){

        $documentos = Documento::all();

        return view("biblioteca",['documentos'=>$documentos]);
    }

    public function remover(Request $request){
        $id = (int) $request->post('id');

        $doc = Documento::find($id);
        Storage::delete($doc->pathArquivo);
        $doc->delete();
    }

}
