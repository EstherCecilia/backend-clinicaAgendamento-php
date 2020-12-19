<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;
    
    protected $fillable  = ['id', 'consultorio', 'duracao', 'codigo_paciente', 'data', 'horario', 'situacao'];
}
