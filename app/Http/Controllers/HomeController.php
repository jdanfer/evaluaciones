<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Evalua;
use App\Models\Jefatura;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalpersonas = Persona::all();
        $lapersona = Persona::where('persona_doc', Auth::user()->documento)->first();
        if (empty($lapersona)) {
            $personas = Persona::where('persona_doc', 0)->get();
        } else {
            $lajefatura = Jefatura::where('descrip', $lapersona->jefatura->descrip)->first();
            $personas = Persona::where('jefatura_id', $lajefatura->id)->get();
            $autoevaluaciones = Persona::where('jefatura_id', $lajefatura->id)
                ->whereIn('autoeval_fin', [1])->get();
            $evaluaciones = Persona::where('jefatura_id', $lajefatura->id)
                ->where('evalua_fin', [1])->get();
            $finalizadas = Persona::where('jefatura_id', $lajefatura->id)
                ->where('evalua_cerrada', [1])->get();
            $autoevaltotal = Persona::whereIn('autoeval_fin', [1])->get();
            $evaluacionestot = Persona::where('evalua_fin', [1])->get();
            $finalizadastot = Persona::where('evalua_cerrada', [1])->get();
        }
        if (isset($autoevaluaciones)) {
            return view('home', [
                'personas' => $personas,
                'totalpersonas' => $totalpersonas,
                'autoevaluaciones' => $autoevaluaciones,
                'evaluaciones' => $evaluaciones,
                'finalizadas' => $finalizadas,
                'autoevaltotal' => $autoevaltotal,
                'evaluacionestot' => $evaluacionestot,
                'finalizadastot' => $finalizadastot,
            ]);
        } else {
            return view('home', [
                'personas' => $personas,
                'totalpersonas' => $totalpersonas,
            ]);
        }
    }
}
