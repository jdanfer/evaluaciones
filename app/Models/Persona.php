<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Propaganistas\LaravelFakeId\RoutesWithFakeIds;

class Persona extends Model
{
    use RoutesWithFakeIds;
    use HasFactory;
    protected $fillable = ['persona_doc', 'persona_nom1', 'persona_ape1', 'persona_ingreso', 'persona_nac', 'persona_genero', 'cargo_id', 'jefatura_id'];

    public static $rules = [
        'persona_doc' => 'required',
        'persona_doc' => 'unique:personas,persona_doc',
        'persona_nom1' => 'required',
        'persona_ape1' => 'required',
        'persona_ingreso' => 'required',
        'persona_nac' => 'required',
        'cargo_id' => 'required',
        'jefatura_id' => 'required'
    ];

    public static $customMessages = [
        'persona_doc.required' => 'El campo identificación es obligatorio.',
        'persona_nom1.required' => 'El campo primer nombre es obligatorio.',
        'persona_ape1.required' => 'El campo primer apellido es obligatorio.',
        'persona_ingreso.required' => 'El campo fecha ingreso es obligatorio.',
        'persona_nac.required' => 'El campo fecha de nacimiento es obligatorio.',
        'cargo_id.required' => 'El campo de Cargo es obligatorio.',
        'jefatura_id.required' => 'El campo Jefatura es obligatorio.',

    ];

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function jefatura()
    {
        return $this->belongsTo(Jefatura::class);
    }
}
