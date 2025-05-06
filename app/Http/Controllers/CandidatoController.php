<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CandidatoController extends Controller
{
    public function index(Request $request)
    {
        $query = Candidato::query();

        if ($request->has('javascript') && $request->javascript == 1) {
            $query->where('javascript', 1);
        }
        if ($request->has('php') && $request->php == 1) {
            $query->where('php', 1);
        }
        if ($request->has('html') && $request->html == 1) {
            $query->where('html', 1);
        }
        if ($request->has('css') && $request->css == 1) {
            $query->where('css', 1);
        }

        $candidatos = $query->get();

        return view('candidatos.index', compact('candidatos'));
    }

    public function descargarCurriculum($id)
    {
        $candidato = Candidato::findOrFail($id);
        
        if (!$candidato->curriculum) {
            return back()->with('error', 'Este candidato no tiene curriculum');
        }

        if (!Storage::disk('public')->exists($candidato->curriculum)) {
            return back()->with('error', 'El archivo del curriculum no se encuentra');
        }

        try {
            $nombreArchivo = $candidato->DNI . '.pdf';
            
            return Storage::disk('public')->download(
                $candidato->curriculum, 
                $nombreArchivo
            );
        } catch (\Exception $e) {
            return back()->with('error', 'Error al descargar el archivo');
        }
    }
}
