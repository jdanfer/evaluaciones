<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;
    protected $fillable = ['descrip', 'pregunta_nro', 'titulo_id', 'jefatura_id', 'cargo_id'];

    public static $rules = [
        'descrip' => 'required|min:3',
        'pregunta_nro' => 'required',
        'titulo_id' => 'required',
        'jefatura_id' => 'required',
        'cargo_id' => 'required',
    ];

    public static $customMessages = [
        'descrip.required' => 'El campo descripcion es obligatorio.',
        'descrip.min' => 'El campo descripción debe contener >3 caract',
        'pregunta_nro.required' => 'El campo número pregunta es obligatorio.',
        'titulo_id.required' => 'El campo título es obligatorio.',
        'jefatura_id.required' => 'El campo Jefatura es obligatorio.',
        'cargo_id.required' => 'El campo Cargo es obligatorio.',

    ];

    public function titulo()
    {
        return $this->belongsTo(Titulo::class);
    }

    public function jefatura()
    {
        return $this->belongsTo(Jefatura::class);
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }
}
