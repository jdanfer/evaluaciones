<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;
    protected $fillable = ['descrip'];

    public static $rules = [
        'descrip' => 'required|min:3',
    ];

    public static $customMessages = [
        'descrip.required' => 'El campo descripcion es obligatorio.',
        'descrip.min' => 'El campo descripción debe contener >3 caract'
    ];

    public function jefatura()
    {
        return $this->belongsTo(Jefatura::class);
    }
}
