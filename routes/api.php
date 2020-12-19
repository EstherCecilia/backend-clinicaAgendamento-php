<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PacienteController;
use App\Http\Controllers\AgendamentoController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('pacientes', [PacienteController::class, 'index']);
Route::get('pacientes/id/{id}',[PacienteController::class, 'show']);
Route::get('pacientes/cpf/{cpf}',[PacienteController::class, 'showCpf']);
Route::post('pacientes', [PacienteController::class, 'store']);
Route::put('pacientes/{id}', [PacienteController::class, 'update']);
//Route::delete('pacientes/{id}', [PacienteController::class, 'delete']);


Route::get('agendamentos', [AgendamentoController::class, 'index']);
Route::post('agendamentos/ativos', [AgendamentoController::class, 'indexDate']);
Route::get('agendamentos/id/{id}',[AgendamentoController::class, 'show']);

Route::post('agendamentos/horario',[AgendamentoController::class, 'testeHorario']);
// Route::get('agendamentos/cpf/{cpf}',[AgendamentoController::class, 'showCpf']);
Route::post('agendamentos', [AgendamentoController::class, 'store']);
Route::put('agendamentos/{id}', [AgendamentoController::class, 'update']);
Route::delete('agendamentos/{id}', [AgendamentoController::class, 'delete']);