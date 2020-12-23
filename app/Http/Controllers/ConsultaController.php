<?php

namespace App\Http\Controllers;

use App\Models\Consulta;


use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    public function index()
    {
        return Consulta::all();
    }

}
