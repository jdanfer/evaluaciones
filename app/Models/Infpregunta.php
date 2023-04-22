<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infpregunta extends Model
{
    use HasFactory;
    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function jefatura()
    {
        return $this->belongsTo(Jefatura::class);
    }

    public function titulo()
    {
        return $this->belongsTo(Titulo::class);
    }

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }
}