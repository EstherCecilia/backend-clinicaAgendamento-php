<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Paciente;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AgendamentoController extends Controller
{
    public function index()
    {
        return Agendamento::all();
    }

    public function index2()
    {
        $resultado = array();
        $agendamentos = Agendamento::all();

        foreach ($agendamentos as $value) {
            $paciente = Paciente::where('id', $value->codigo_paciente)->first();
            $resultado[$value->id]['paciente'] = $paciente;
            $resultado[$value->id]['consulta'] = $value;
        }
        return $resultado;
    }

    public function indexDate(Request $request)
    {
        return Agendamento::all()->where('data','>=',Carbon::now());

    }

    public function cachPrice(Request $request)
    {

        $ids = $request->get('ids');
        try {
            $notas["situacao"] = Agendamento::where('id', $ids)->where('situacao','pendente')
                        ->update(['situacao' => "pago"]);
                    
            
        } catch (Exception $e) {
            return array("resposta" => "Erro ao pagar documento" . $e->getMessage() . "-" . $e->getLine());
        }
        if (empty($notas)) {
            $notas = ["resposta" => 0];
        }
 
        return $notas;
    }

    public function indexPrice($id)
    {

        $paciente = Paciente::find($id);
        $agendamentos = Agendamento::all()->where('codigo_paciente',$id)->where('situacao',"pendente");

        $resultado['agendamentos'] = $agendamentos;
        $resultado['status'] = true;
        $resultado['paciente']=$paciente;
        $resultado['price']=count($agendamentos)*70;



        return $resultado;
    }

    // public function showCpf($cpf)
    // {
    //     return Paciente::where("cpf",$cpf)->first();
    // }
 
    public function show($id)
    {
        return Agendamento::find($id);
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


    public function testeHorario($data){
       $agendamento1 =  Agendamento::all()->where('consultorio',1)->where("horario",$data);
       
       if(count($agendamento1)==0){
            return 1;
       }else{
            $agendamento2 =  Agendamento::all()->where('consultorio',2)->where('horario',$data);

            if(count($agendamento2)==0){
                return 2;
            
            }else{
                return 0;
            }

       }
    }
    
    public function store(Request $request)
    {

        $resultado = array();

        try {

        $data = Carbon::parse($request['data']);
        

        if($data->dayOfWeek == Carbon::SUNDAY || $data->dayOfWeek == Carbon::SATURDAY){
            $resultado['status'] = false;
            $resultado['mensagem'] = "Finais de semana a clinica se encontra fechada";
            return $resultado;

        }


        if($data->hour <= 8 || $data->hour >= 20){
            $resultado['status'] = false;
            $resultado['mensagem'] = "Nesse horario a clinica se encontra fechada";
            return $resultado;

        }

       
        $clinica = $this->testeHorario($request['data']);
        if($clinica == 0){
            $resultado['status'] = false;
            $resultado['mensagem'] = "Não há horario disponivel";
            return $resultado;
        }

        $request['consultorio'] = $clinica;
        $resultado['status'] = true;
        $request['horario'] = $request['data'];
        $resultado['dados'] = Agendamento::create($request->all());
        return $resultado;
         
    } catch (Exception $e) {
        $resultado['status'] = false;
        $resultado['mensagem'] = "Erro desconhecido";
        $resultado['erro'] = array($e->getMessage(), $e->getFile(), $e->getLine());
        return $resultado;
    }

    }

    public function update(Request $request, $id)
    {
        $article = Agendamento::findOrFail($id);
        $article->update($request->all());

        return $article;
    }

    public function delete(Request $request, $id)
    {
        $article = Agendamento::findOrFail($id);
        $article->delete();

        return 204;
    }
}
