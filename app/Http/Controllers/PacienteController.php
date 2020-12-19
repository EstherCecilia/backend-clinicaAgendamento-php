<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index()
    {
        return Paciente::all();
    }

    public function showCpf($cpf)
    {
        return Paciente::where("cpf",$cpf)->first();
    }
 
    public function show($id)
    {
        return Paciente::find($id);
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('docs.create');
    }


    
    public function store(Request $request)
    {

        return Paciente::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $article = Paciente::findOrFail($id);
        $article->update($request->all());

        return $article;
    }

    public function delete(Request $request, $id)
    {
        $article = Paciente::findOrFail($id);
        $article->delete();

        return 204;
    }
}
