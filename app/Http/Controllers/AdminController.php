<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargo;
use App\Models\Evalua;
use App\Models\Jefatura;
use App\Models\Titulo;
use App\Models\Pregunta;
use App\Models\Persona;
use App\Models\Periodo;
use App\Models\Infevalula;
use App\Models\Infjefatura;
use App\Models\Infpregunta;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\PDF;

class AdminController extends Controller
{
    //

    public function generarPDF(Request $request, $documento)
    {
        //        $pdf = PDF::loadView('libro.pdf');
        //        $pdf->loadHTML('<h1>Test</h1>');
        //        return $pdf->stream();
        $elperiodo = Periodo::whereIn('pordefecto', ['on'])->first();
        $lapersona = Persona::find($documento);

        $autoevaluas = Evalua::where('persona_id', $lapersona->id);
        $autoevaluas = $autoevaluas->whereNotIn('jefatura_eval', [1])->get();

        $borrarinf = Infevalula::where('jefatura', $lapersona->jefatura->descrip)->delete();
        foreach ($autoevaluas as $autoev) {
            $lapregunta = Pregunta::find($autoev->pregunta_id);
            $borrarinf = new Infevalula();
            $borrarinf->descrip = $lapregunta->descrip;
            $borrarinf->nro = $lapregunta->pregunta_nro;
            $borrarinf->periodo = $elperiodo->descrip;
            $borrarinf->autoeval = $autoev->puntos;
            $borrarinf->evalua = 0;
            $borrarinf->promedio = 0;
            $borrarinf->titulo = $lapregunta->titulo->descrip;
            $borrarinf->jefatura = $lapersona->jefatura->descrip;
            $borrarinf->pregunta_id = $lapregunta->id;
            $borrarinf->save();
        }

        $borrarinf = Infevalula::where('jefatura', $lapersona->jefatura->descrip)->get();
        if (isset($borrarinf)) {
            $total = $borrarinf->count();
        } else {
            $total = 0;
        }
        $totalprod = 0;
        //        $tituloSelect = $borrarinf->titulo;
        $promediotit = 0;
        $cuentaPreg = 0;
        $totpromediotit = 0;
        $idanterior = 0;
        foreach ($borrarinf as $evaljefe) {
            $infevaluas = Infevalula::find($evaljefe->id);
            $autoevaluas = Evalua::where('persona_id', $lapersona->id);
            $autoevaluas = $autoevaluas->whereIn('pregunta_id', [$evaljefe->pregunta_id]);
            $autoevaluas = $autoevaluas->where('jefatura_eval', 1)->first();
            if (isset($autoevaluas)) {
                if ($idanterior === 0) {
                } else {
                    if ($evaljefe->nro === 1) {
                        $totpromediotit = 0;
                        $idanterior = $evaljefe->id - 1;
                        $infmodif = Infevalula::find($idanterior);
                        if ($cuentaPreg <= 0) {
                            $totpromediotit = 0;
                        } else {
                            $totpromediotit = $infmodif->saldo_prod / $cuentaPreg;
                        }
                        $totpromediotit = round($totpromediotit, 2);
                        $infmodif->saldo_prod = $totpromediotit;
                        $infmodif->promedio_tit = 99;
                        $infmodif->save();
                        $cuentaPreg = 0;
                        $totpromediotit = 0;
                        $promediotit = 0;
                    }
                }
                $cuentaPreg = $cuentaPreg + 1;
                $promedio = $evaljefe->autoeval + $autoevaluas->puntos;
                $promedio = $promedio / 2;
                $promediotit = $promediotit + $promedio;
                $promediotit = round($promediotit, 2);
                $infevaluas->evalua = $autoevaluas->puntos;
                $infevaluas->observa = $autoevaluas->observacion;
                $infevaluas->promedio = $promedio;
                $infevaluas->saldo_prod = $promediotit;
                $infevaluas->save();
                $totalprod = $totalprod + $promedio;
                $idanterior = 1;
            } else {
                if ($evaljefe->nro === 1 && $idanterior > 0) {
                    $totpromediotit = 0;
                    $idanterior = $evaljefe->id - 1;
                    $infmodif = Infevalula::find($idanterior);
                    if ($cuentaPreg <= 0) {
                        $totpromediotit = 0;
                    } else {
                        $totpromediotit = $infmodif->saldo_prod / $cuentaPreg;
                    }
                    $totpromediotit = round($totpromediotit, 2);
                    $infmodif->saldo_prod = $totpromediotit;
                    $infmodif->promedio_tit = 99;
                    $infmodif->save();
                    $totpromediotit = 0;
                    $cuentaPreg = 0;
                }
            }
        }
        //        $infoevaluas = Infevalula::where('jefatura', $lapersona->jefatura->descrip)->delete();
        $borrarinf = Infevalula::where('jefatura', $lapersona->jefatura->descrip)->latest('id')->first();
        if (isset($borrarinf)) {
            if ($cuentaPreg > 0) {
                $totpromediotit = $borrarinf->saldo_prod / $cuentaPreg;
            } else {
                $totpromediotit = 0;
            }
            $borrarinf->saldo_prod = round($totpromediotit, 2);
            $borrarinf->promedio_tit = 99;
            $borrarinf->save();
        }

        //        $autoevaluas = Evalua::all();
        $borrarinf = Infevalula::where('jefatura', $lapersona->jefatura->descrip)->latest('id')->first();
        if (isset($borrarinf)) {
            $borrarinf->fecha = date('d-m-Y');
            $borrarinf->save();
        }

        $borrarinf = Infevalula::where('jefatura', $lapersona->jefatura->descrip)->get();
        $totalprod = $totalprod / $total;
        $totalprod = number_format($totalprod, 2, '.', ',');

        $total = 1450 / 3;
        $total = number_format($total, 2, '.', ',');
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('/layouts/admin/autoevaluaPdf', [
            'autoevaluas' => $autoevaluas,
            'lapersona' => $lapersona,
            'elperiodo' => $elperiodo,
            'borrarinf' => $borrarinf,
            'totalprod' => $totalprod,
        ])->setPaper('a4', 'landscape');
        return $pdf->download('evaluación.pdf');
    }

    public function informeJefatura()
    {
        if (auth()->user()->admin === "on") {
            $jefaturas = Jefatura::all();
            $periodos = Periodo::whereIn('pordefecto', ['on'])->first();
            if (!isset($periodos)) {
                $periodos = Periodo::all();
            }
            return view('/layouts/admin/informeJefaturas', [
                'jefaturas' => $jefaturas,
                'periodos' => $periodos,
            ]);
        } else {
            return view('errors/noHabilitado');
        }
    }

    public function informeJefaturaCreate(Request $request)
    {
        $borrarinf = Infjefatura::whereNotNull('id')->delete();
        $elperiodo = Periodo::whereIn('pordefecto', ['on'])->first();
        $totalpersonasTot = 0;
        if ($request->jefatura_descrip === "Todos") {
            $jefaturaSelect = Jefatura::all();
            $laspersonas = Persona::orderBy('jefatura_id', 'ASC')->get();
        } else {
            $jefaturaSelect = Jefatura::whereIn('descrip', [$request->jefatura_descrip])->first();
            $laspersonas = Persona::whereIn('jefatura_id', [$jefaturaSelect->id])->get();
        }
        $totalPersonas = 0;
        $tottitulosprom = 0;
        $subtotcantjefe = 0;
        $subtotpromjefe = 0;
        $totalpromanterior = 0;
        $prom1anterior = 0;
        $prom2anterior = 0;
        $prom3anterior = 0;
        $prom4anterior = 0;
        $subtotprom1g = 0;
        $subtotprom2g = 0;
        $subtotprom3g = 0;
        $subtotprom4g = 0;
        foreach ($laspersonas as $laspersona) {
            $jefepersona = Persona::find($laspersona->id);
            $borrarinf = new Infjefatura();
            $borrarinf->persona_nom = $laspersona->persona_nom1 . " " . $laspersona->persona_ape1;
            $borrarinf->persona_id = $laspersona->id;
            $borrarinf->periodo = $elperiodo->descrip;
            $borrarinf->jefatura = $jefepersona->jefatura->descrip;
            //recorrer los tìtulos
            $titulo = Titulo::orderBy('id', 'ASC')->get();
            $cantTitulo = 1;
            $totalPromGral = 0;
            $totalTotgral = 0;
            foreach ($titulo as $tit) {
                $totalpuntos = 0;
                $totalpromed = 0;
                $laevaluacion = Evalua::where('persona_id', $jefepersona->id);
                $laevaluacion = $laevaluacion->where('titulo_id', $tit->id)->get();
                //                $laevaluacion = $laevaluacion->whereIn('jefatura_eval', [0])->get();
                foreach ($laevaluacion as $laeval) {
                    $totalpuntos = $totalpuntos + $laeval->puntos;
                    $totalpromed = $totalpromed + 1;
                }
                if ($cantTitulo === 1) {
                    if ($totalpromed === 0) {
                        $borrarinf->prom1 = 0;
                        $prom1anterior = 0;
                    } else {
                        $borrarinf->prom1 = $totalpuntos / $totalpromed;
                        $totalPromGral = $totalpuntos / $totalpromed;
                        $prom1anterior = $totalPromGral;
                        $totalTotgral = $totalTotgral + $totalPromGral;
                        $tottitulosprom = $tottitulosprom + 1;
                        $subtotprom1g = $subtotprom1g + $totalPromGral;
                    }
                }
                if ($cantTitulo === 2) {
                    if ($totalpromed === 0) {
                        $borrarinf->prom2 = 0;
                        $prom2anterior = 0;
                    } else {
                        $borrarinf->prom2 = $totalpuntos / $totalpromed;
                        $totalPromGral = $totalpuntos / $totalpromed;
                        $prom2anterior = $totalPromGral;
                        $totalTotgral = $totalTotgral + $totalPromGral;
                        $tottitulosprom = $tottitulosprom + 1;
                        $subtotprom2g = $subtotprom2g + $totalPromGral;
                    }
                }
                if ($cantTitulo === 3) {
                    if ($totalpromed === 0) {
                        $borrarinf->prom3 = 0;
                        $prom3anterior = 0;
                    } else {
                        $borrarinf->prom3 = $totalpuntos / $totalpromed;
                        $totalPromGral = $totalpuntos / $totalpromed;
                        $prom3anterior = $totalPromGral;
                        $totalTotgral = $totalTotgral + $totalPromGral;
                        $tottitulosprom = $tottitulosprom + 1;
                        $subtotprom3g = $subtotprom3g + $totalPromGral;
                    }
                }
                if ($cantTitulo === 4) {
                    if ($totalpromed === 0) {
                        $borrarinf->prom4 = 0;
                        $prom4anterior = 0;
                    } else {
                        $borrarinf->prom4 = $totalpuntos / $totalpromed;
                        $totalPromGral = $totalpuntos / $totalpromed;
                        $prom4anterior = $totalPromGral;
                        $totalTotgral = $totalTotgral + $totalPromGral;
                        $tottitulosprom = $tottitulosprom + 1;
                        $subtotprom4g = $subtotprom4g + $totalPromGral;
                    }
                }
                $cantTitulo = $cantTitulo + 1;
                $totalpuntos = 0;
                $totalpromed = 0;
            }
            if ($tottitulosprom === 0) {
                $totalTotgral = 0;
            } else {
                $totalTotgral = $totalTotgral / $tottitulosprom;
            }
            $totalTotgral = round($totalTotgral, 2);
            $borrarinf->promtot = $totalTotgral;
            $totalPersonas = $totalPersonas + 1;
            $borrarinf->saldo_per = $totalPersonas;
            $borrarinf->save();
            $subtotpromjefe = $subtotpromjefe + $totalTotgral;
            $totalpromanterior = $totalTotgral;
            $tottitulosprom = 0;
            $totalPromGral = 0;
            $totalTotgral = 0;
            ///En el segundo grupo no suma el primer promedio
            $idBorrAnterior = $borrarinf->id - 1;
            $cambioJefatura = Infjefatura::find($idBorrAnterior);
            if (isset($cambioJefatura)) {
                if ($cambioJefatura->jefatura != $borrarinf->jefatura) {
                    $subtotpromjefe = $subtotpromjefe - $totalpromanterior;
                    $subtotprom1g = $subtotprom1g - $prom1anterior;
                    $subtotprom2g = $subtotprom2g - $prom2anterior;
                    $subtotprom3g = $subtotprom3g - $prom3anterior;
                    $subtotprom4g = $subtotprom4g - $prom4anterior;
                    if ($subtotcantjefe > 0) {
                        $subtotpromjefe = $subtotpromjefe / $subtotcantjefe;
                        $subtotprom1g = $subtotprom1g / $subtotcantjefe;
                        $subtotprom2g = $subtotprom2g / $subtotcantjefe;
                        $subtotprom3g = $subtotprom3g / $subtotcantjefe;
                        $subtotprom4g = $subtotprom4g / $subtotcantjefe;
                    } else {
                        $subtotpromjefe = 0;
                        $subtotprom1g = 0;
                        $subtotprom2g = 0;
                        $subtotprom3g = 0;
                        $subtotprom4g = 0;
                    }
                    $subtotpromjefe = round($subtotpromjefe, 2);
                    $cambioJefatura->cant_porjefe = $subtotcantjefe;
                    $cambioJefatura->tot_promg = $subtotpromjefe;
                    $cambioJefatura->tot_prom1 = $subtotprom1g;
                    $cambioJefatura->tot_prom2 = $subtotprom2g;
                    $cambioJefatura->tot_prom3 = $subtotprom3g;
                    $cambioJefatura->tot_prom4 = $subtotprom4g;
                    $cambioJefatura->cambio_jefe = 1;
                    $cambioJefatura->save();
                    $subtotcantjefe = 0;
                    $subtotpromjefe = $totalpromanterior;
                    $subtotprom1g = $prom1anterior;
                    $subtotprom2g = $prom2anterior;
                    $subtotprom3g = $prom3anterior;
                    $subtotprom4g = $prom4anterior;
                    $prom1anterior = 0;
                    $prom2anterior = 0;
                    $prom3anterior = 0;
                    $prom4anterior = 0;
                }
            }
            $subtotcantjefe = $subtotcantjefe + 1;
        }
        $cambioJefatura = Infjefatura::whereNotIn('id', [0])->latest('id')->first();
        if (isset($cambioJefatura)) {
            $totalpersonasTot = $cambioJefatura->saldo_per;
        }
        if ($subtotcantjefe > 0) {
            //            $subtotpromjefe = $subtotpromjefe / $subtotcantjefe;
        } else {
            $subtotpromjefe = 0;
        }
        $subtotpromjefe = $subtotpromjefe - $totalpromanterior;
        if ($subtotcantjefe > 0) {
            $subtotpromjefe = $subtotpromjefe / $subtotcantjefe;
            $subtotprom1g = $subtotprom1g / $subtotcantjefe;
            $subtotprom2g = $subtotprom2g / $subtotcantjefe;
            $subtotprom3g = $subtotprom3g / $subtotcantjefe;
            $subtotprom4g = $subtotprom4g / $subtotcantjefe;
        } else {
            $subtotpromjefe = 0;
            $subtotprom1g = 0;
            $subtotprom2g = 0;
            $subtotprom3g = 0;
            $subtotprom4g = 0;
        }
        $subtotpromjefe = round($subtotpromjefe, 2);
        $cambioJefatura->cant_porjefe = $subtotcantjefe;
        $cambioJefatura->tot_promg = $subtotpromjefe;
        $cambioJefatura->tot_prom1 = $subtotprom1g;
        $cambioJefatura->tot_prom2 = $subtotprom2g;
        $cambioJefatura->tot_prom3 = $subtotprom3g;
        $cambioJefatura->tot_prom4 = $subtotprom4g;
        $cambioJefatura->cambio_jefe = 1;
        $cambioJefatura->save();
        $subtotcantjefe = 0;
        $subtotpromjefe = 0;
        $subtotprom1g = 0;
        $subtotprom2g = 0;
        $subtotprom3g = 0;
        $subtotprom4g = 0;
        $subtotpromjefe = 0;
        //Para el total final seleccionar todos los registros con subtotal jefaturas y sumar. Agregar un total general como 99 en último registro
        $cambioJefatura = Infjefatura::whereIn('cambio_jefe', [1])->get();
        foreach ($cambioJefatura as $cambioJefaturaFin) {
            $subtotprom1g = $subtotprom1g + $cambioJefaturaFin->tot_prom1;
            $subtotprom2g = $subtotprom2g + $cambioJefaturaFin->tot_prom2;
            $subtotprom3g = $subtotprom3g + $cambioJefaturaFin->tot_prom3;
            $subtotprom4g = $subtotprom4g + $cambioJefaturaFin->tot_prom4;
            $subtotpromjefe = $subtotpromjefe + $cambioJefaturaFin->tot_promg;
        }
        if ($totalpersonasTot > 0) {
            $cambioJefatura = Infjefatura::whereNotIn('id', [0])->latest('id')->first();
            $cambioJefatura->estotal = 99;
            $cambioJefatura->totalgral1 = $subtotprom1g / $totalpersonasTot;
            $cambioJefatura->totalgral2 = $subtotprom2g / $totalpersonasTot;
            $cambioJefatura->totalgral3 = $subtotprom3g / $totalpersonasTot;
            $cambioJefatura->totalgral4 = $subtotprom4g / $totalpersonasTot;
            $cambioJefatura->totalgraltot = $subtotpromjefe / $totalpersonasTot;
            $cambioJefatura->save();
        }
        $borrarinf = Infjefatura::whereNotIn('id', [0])->latest('id')->first();
        if (isset($borrarinf)) {
            $borrarinf->fecha = date('d-m-Y');
            $borrarinf->save();
        }
        $borrarinf = Infjefatura::all();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('/layouts/admin/infJefaturaPdf', [
            'elperiodo' => $elperiodo,
            'jefaturaSelect' => $jefaturaSelect,
            'borrarinf' => $borrarinf,
            'laspersonas' => $laspersonas,
        ])->setPaper('a4', 'landscape');
        return $pdf->download('eval-jefatura.pdf');
    }

    public function informeCargoCreate(Request $request)
    {
        $borrarinf = Infjefatura::whereNotNull('id')->delete();
        $elperiodo = Periodo::whereIn('pordefecto', ['on'])->first();
        if ($request->cargo_descrip === "Todos") {
            $cargoSelect = Cargo::all();
            //            $laspersonas = Persona::orderBy('cargo_id', 'ASC')->get();
        } else {
            $cargoSelect = Cargo::whereIn('descrip', [$request->cargo_descrip])->first();
            //            $laspersonas = Persona::whereIn('cargo_id', [$cargoSelect->id])->get();
        }
        $subtotprom1g = 0;
        foreach ($cargoSelect as $elcargoSelect) {
            $descripCargo = Cargo::find($elcargoSelect->id);
            $borrarinf = new Infjefatura();
            $borrarinf->persona_nom = $descripCargo->descrip;
            $borrarinf->persona_id = $descripCargo->id;
            $borrarinf->periodo = $elperiodo->descrip;
            $borrarinf->jefatura = $descripCargo->jefatura->descrip;
            //recorrer los tìtulos
            $laevaluacion = Evalua::whereIn('cargo_id', [$elcargoSelect->id]);
            $laevaluacion = $laevaluacion->whereIn('periodo', [$elperiodo->descrip]);
            $laevaluacion = $laevaluacion->whereNotIn('jefatura_eval', [1])->get();
            $totalPromGral = 0;
            $totalTotgral = 0;
            $totalpuntos = 0;
            $totalpromed = 0;
            $totalTotCant = 0;
            foreach ($laevaluacion as $laevalSelect) {
                $totalpuntos = $totalpuntos + $laevalSelect->puntos;
                $totalpromed = $totalpromed + 1;
                //                $laevaluacion = $laevaluacion->whereIn('jefatura_eval', [0])->get();
            }
            if ($totalpromed > 0) {
                $totalPromGral = $totalpuntos / $totalpromed;
            } else {
                $totalPromGral = 0;
            }
            $totalPromGral = round($totalPromGral, 2);
            $totalTotgral = $totalPromGral;
            $totalTotCant = $totalpromed;
            $borrarinf->prom1 = $totalPromGral;
            $laevaluacion = Evalua::whereIn('cargo_id', [$elcargoSelect->id]);
            $laevaluacion = $laevaluacion->whereIn('periodo', [$elperiodo->descrip]);
            $laevaluacion = $laevaluacion->whereIn('jefatura_eval', [1])->get();
            $totalpuntos = 0;
            $totalpromed = 0;
            $totalPromGral = 0;
            foreach ($laevaluacion as $laevalSelect) {
                $totalpuntos = $totalpuntos + $laevalSelect->puntos;
                $totalpromed = $totalpromed + 1;
                //                $laevaluacion = $laevaluacion->whereIn('jefatura_eval', [0])->get();
            }
            if ($totalpromed > 0) {
                $totalPromGral = $totalpuntos / $totalpromed;
            } else {
                $totalPromGral = 0;
            }
            $totalPromGral = round($totalPromGral, 2);
            $totalTotgral = $totalTotgral + $totalPromGral;
            $totalTotCant = $totalTotCant + $totalpromed;
            $borrarinf->prom2 = $totalPromGral;
            //            if ($totalTotCant > 0) {
            //                $subtotprom1g = $totalTotgral / $totalTotCant;
            //                $subtotprom1g = round($subtotprom1g, 2);
            //            } else {
            ///                $subtotprom1g = 0;
            //            }
            if ($totalTotgral > 0) {
                $totalTotgral = $totalTotgral / 2;
                $totalTotgral = round($totalTotgral, 2);
                //                $borrarinf->promedio = $subtotprom1g;
                $borrarinf->promedio = $totalTotgral;
            } else {
                $borrarinf->promedio = 0;
            }
            $borrarinf->save();
        }
        $borrarinf = Infjefatura::whereNotIn('id', [0])->latest('id')->first();
        if (isset($borrarinf)) {
            $borrarinf->fecha = date('d-m-Y');
            $borrarinf->save();
        }
        $borrarinf = Infjefatura::all();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('/layouts/admin/infCargoPdf', [
            'elperiodo' => $elperiodo,
            'cargoSelect' => $cargoSelect,
            'borrarinf' => $borrarinf,
        ])->setPaper('a4', 'landscape');
        return $pdf->download('eval-cargo.pdf');
    }

    public function informeCargo()
    {
        if (auth()->user()->admin === "on") {
            $cargos = Cargo::all();
            $periodos = Periodo::whereIn('pordefecto', ['on'])->first();
            if (!isset($periodos)) {
                $periodos = Periodo::all();
            }
            return view('/layouts/admin/informeCargos', [
                'cargos' => $cargos,
                'periodos' => $periodos,
            ]);
        } else {
            return view('errors/noHabilitado');
        }
    }

    public function informePreguntaCreate(Request $request)
    {
        $borrarinf = Infpregunta::whereNotNull('id')->delete();
        $elperiodo = Periodo::whereIn('pordefecto', ['on'])->first();
        if ($request->cargo_descrip === "Todos") {
            $cargoSelect = Cargo::all();
            //            $laspersonas = Persona::orderBy('cargo_id', 'ASC')->get();
        } else {
            $cargoSelect = Cargo::whereIn('descrip', [$request->cargo_descrip])->first();
            //            $laspersonas = Persona::whereIn('cargo_id', [$cargoSelect->id])->get();
        }
        $subtotprom = 0;
        $totalpersonas = 0;
        $subtotpersonas = 0;
        foreach ($cargoSelect as $elcargoSelect) {
            $laspersonas = Persona::where('cargo_id', $elcargoSelect->id)->get();
            $subtotcargop1 = 0;
            $subtotcargop2 = 0;
            $subtotcargop3 = 0;
            $subtotcargop4 = 0;
            $subtotcargop5 = 0;
            $subtotcargop6 = 0;
            $subtotcargop7 = 0;
            $subtotcargop8 = 0;
            $subtotcargop9 = 0;
            $subtotcargop10 = 0;
            $subtotcargop11 = 0;
            $subtotcargop12 = 0;
            $subtotcargop13 = 0;
            $subtotcargop14 = 0;
            $subtotcargop15 = 0;
            $subtotcargop16 = 0;
            $subtotcargopSub1 = 0;
            $subtotcargopSub2 = 0;
            $subtotcargopSub3 = 0;
            $subtotcargopSub4 = 0;
            $subtotcargopSubT = 0;

            foreach ($laspersonas as $lapersona) {
                $borrarinf = new Infpregunta();
                $borrarinf->persona_nom = $lapersona->persona_nom1 . " " . $lapersona->persona_ape1;
                $borrarinf->jefatura = $elcargoSelect->descrip;
                $borrarinf->periodo = $elperiodo->descrip;
                $laevaluacion = Evalua::whereIn('persona_id', [$lapersona->id]);
                $laevaluacion = $laevaluacion->whereIn('periodo', [$elperiodo->descrip])->get();
                $p1 = 0;
                $p2 = 0;
                $p3 = 0;
                $p4 = 0;
                $p5 = 0;
                $p6 = 0;
                $p7 = 0;
                $p8 = 0;
                $p9 = 0;
                $p10 = 0;
                $p11 = 0;
                $p12 = 0;
                $p13 = 0;
                $p14 = 0;
                $p15 = 0;
                $p16 = 0;
                $subtot1 = 0;
                $subtot2 = 0;
                $subtot3 = 0;
                $subtot4 = 0;
                $subtottot = 0;
                //promedio de cada pregunta (sumar autoeval + eval y / 2)
                foreach ($laevaluacion as $eval) {
                    $lapregunta = Pregunta::find($eval->pregunta_id);
                    if (isset($lapregunta)) {
                        if ($lapregunta->pregunta_nro === 1) {
                            $p1 = $p1 + $eval->puntos;
                        }
                        if ($lapregunta->pregunta_nro === 2) {
                            $p2 = $p2 + $eval->puntos;
                        }
                        if ($lapregunta->pregunta_nro === 3) {
                            $p3 = $p3 + $eval->puntos;
                        }
                        if ($lapregunta->pregunta_nro === 4) {
                            $p4 = $p4 + $eval->puntos;
                        }
                        if ($lapregunta->pregunta_nro === 5) {
                            $p5 = $p5 + $eval->puntos;
                        }
                        if ($lapregunta->pregunta_nro === 6) {
                            $p6 = $p6 + $eval->puntos;
                        }
                        if ($lapregunta->pregunta_nro === 7) {
                            $p7 = $p7 + $eval->puntos;
                        }
                        if ($lapregunta->pregunta_nro === 8) {
                            $p8 = $p8 + $eval->puntos;
                        }
                        if ($lapregunta->pregunta_nro === 9) {
                            $p9 = $p9 + $eval->puntos;
                        }
                        if ($lapregunta->pregunta_nro === 10) {
                            $p10 = $p10 + $eval->puntos;
                        }
                        if ($lapregunta->pregunta_nro === 11) {
                            $p11 = $p11 + $eval->puntos;
                        }
                        if ($lapregunta->pregunta_nro === 12) {
                            $p12 = $p12 + $eval->puntos;
                        }
                        if ($lapregunta->pregunta_nro === 13) {
                            $p13 = $p13 + $eval->puntos;
                        }
                        if ($lapregunta->pregunta_nro === 14) {
                            $p14 = $p14 + $eval->puntos;
                        }
                        if ($lapregunta->pregunta_nro === 15) {
                            $p15 = $p15 + $eval->puntos;
                        }
                        if ($lapregunta->pregunta_nro === 16) {
                            $p16 = $p16 + $eval->puntos;
                        }
                    }
                }
                $p1 = $p1 / 2;
                $p2 = $p2 / 2;
                $p3 = $p3 / 2;
                $p4 = $p4 / 2;
                $p5 = $p5 / 2;
                $p6 = $p6 / 2;
                $p7 = $p7 / 2;
                $p8 = $p8 / 2;
                $p9 = $p9 / 2;
                $p10 = $p10 / 2;
                $p11 = $p11 / 2;
                $p12 = $p12 / 2;
                $p13 = $p13 / 2;
                $p14 = $p14 / 2;
                $p15 = $p15 / 2;
                $p16 = $p16 / 2;
                $subtotprom = $p1 + $p2 + $p3 + $p4 + $p5 + $p6 + $p7 + $p8 + $p9 + $p10 + $p11 + $p12 + $p13 + $p14 + $p15 + $p16;
                $borrarinf->p1 = $p1;
                $borrarinf->p2 = $p2;
                $borrarinf->p3 = $p3;
                $borrarinf->p4 = $p4;
                $borrarinf->p5 = $p5;
                $borrarinf->p6 = $p6;
                $borrarinf->p7 = $p7;
                $borrarinf->p8 = $p8;
                $borrarinf->p9 = $p9;
                $borrarinf->p10 = $p10;
                $borrarinf->p11 = $p11;
                $borrarinf->p12 = $p12;
                $borrarinf->p13 = $p13;
                $borrarinf->p14 = $p14;
                $borrarinf->p15 = $p15;
                $borrarinf->p16 = $p16;
                $borrarinf->tot_promg = $subtotprom;
                $subtot1 = $p1 + $p2 + $p3 + $p4;
                $subtot1 = $subtot1 / 4;
                $subtot1 = round($subtot1, 2);
                $subtot2 = $p5 + $p6 + $p7 + $p8;
                $subtot2 = $subtot2 / 4;
                $subtot2 = round($subtot2, 2);
                $subtot3 = $p9 + $p10 + $p11 + $p12;
                $subtot3 = $subtot3 / 4;
                $subtot3 = round($subtot3, 2);
                $subtot4 = $p13 + $p14 + $p15 + $p16;
                $subtot4 = $subtot4 / 4;
                $subtot4 = round($subtot4, 2);
                $borrarinf->prom1 = $subtot1;
                $borrarinf->prom2 = $subtot2;
                $borrarinf->prom3 = $subtot3;
                $borrarinf->prom4 = $subtot4;
                $subtottot = $subtot1 + $subtot2 + $subtot3 + $subtot4;
                $subtottot = $subtottot / 4;
                $subtottot = round($subtottot, 2);
                $borrarinf->promtot = $subtottot;
                $borrarinf->save();
                $totalpersonas = $totalpersonas + 1;
                $subtotcargop1 = $subtotcargop1 + $p1;
                $subtotcargop2 = $subtotcargop2 + $p2;
                $subtotcargop3 = $subtotcargop3 + $p3;
                $subtotcargop4 = $subtotcargop4 + $p4;
                $subtotcargop5 = $subtotcargop5 + $p5;
                $subtotcargop6 = $subtotcargop6 + $p6;
                $subtotcargop7 = $subtotcargop7 + $p7;
                $subtotcargop8 = $subtotcargop8 + $p8;
                $subtotcargop9 = $subtotcargop9 + $p9;
                $subtotcargop10 = $subtotcargop10 + $p10;
                $subtotcargop11 = $subtotcargop11 + $p11;
                $subtotcargop12 = $subtotcargop12 + $p12;
                $subtotcargop13 = $subtotcargop13 + $p13;
                $subtotcargop14 = $subtotcargop14 + $p14;
                $subtotcargop15 = $subtotcargop15 + $p15;
                $subtotcargop16 = $subtotcargop16 + $p16;
                $subtotpersonas = $subtotpersonas + 1;
            }
            $subtotprom = 0;
            ///acá grabar los subtotales por cambio de cargo
            $borrarinf = Infpregunta::whereNotIn('id', [0])->latest('id')->first();
            if (isset($borrarinf)) {
                $borrarinf->estotal = 99;
                $borrarinf->sp1 = $subtotcargop1;
                $borrarinf->sp2 = $subtotcargop2;
                $borrarinf->sp3 = $subtotcargop3;
                $borrarinf->sp4 = $subtotcargop4;
                $borrarinf->sp5 = $subtotcargop5;
                $borrarinf->sp6 = $subtotcargop6;
                $borrarinf->sp7 = $subtotcargop7;
                $borrarinf->sp8 = $subtotcargop8;
                $borrarinf->sp9 = $subtotcargop9;
                $borrarinf->sp10 = $subtotcargop10;
                $borrarinf->sp11 = $subtotcargop11;
                $borrarinf->sp12 = $subtotcargop12;
                $borrarinf->sp13 = $subtotcargop13;
                $borrarinf->sp14 = $subtotcargop14;
                $borrarinf->sp15 = $subtotcargop15;
                $borrarinf->sp16 = $subtotcargop16;
                $subtotcargopSub1 = $subtotcargop1 + $subtotcargop2 + $subtotcargop3 + $subtotcargop4;
                $subtotcargopSub2 = $subtotcargop5 + $subtotcargop6 + $subtotcargop7 + $subtotcargop8;
                $subtotcargopSub3 = $subtotcargop9 + $subtotcargop10 + $subtotcargop11 + $subtotcargop12;
                $subtotcargopSub4 = $subtotcargop13 + $subtotcargop14 + $subtotcargop15 + $subtotcargop16;
                $subtotcargopSub1 = $subtotcargopSub1 / 4;
                $subtotcargopSub2 = $subtotcargopSub2 / 4;
                $subtotcargopSub3 = $subtotcargopSub3 / 4;
                $subtotcargopSub4 = $subtotcargopSub4 / 4;
                $subtotcargopSub1 = round($subtotcargopSub1, 2);
                $subtotcargopSub2 = round($subtotcargopSub2, 2);
                $subtotcargopSub3 = round($subtotcargopSub3, 2);
                $subtotcargopSub4 = round($subtotcargopSub4, 2);
                $subtotcargopSubT = $subtotcargopSub1 + $subtotcargopSub2 + $subtotcargopSub3 + $subtotcargopSub4;
                $subtotcargopSubT = $subtotcargopSubT / 4;
                $subtotcargopSubT = round($subtotcargopSubT, 2);
                $borrarinf->sptotg1 = $subtotcargopSub1;
                $borrarinf->sptotg2 = $subtotcargopSub2;
                $borrarinf->sptotg3 = $subtotcargopSub3;
                $borrarinf->sptotg4 = $subtotcargopSub4;
                $borrarinf->sptotg = $subtotcargopSubT;
                $borrarinf->cant_porjefe = $subtotpersonas;
                $borrarinf->save();
                $subtotpersonas = 0;
            }
        }

        $borrarinf = Infpregunta::whereNotIn('id', [0])->latest('id')->first();
        if (isset($borrarinf)) {
            $borrarinf->estotal = 99;
            $borrarinf->totalgral1 = $subtottot;
            $borrarinf->cambio_jefe = 78;
            $borrarinf->saldo_per = $totalpersonas;
            $borrarinf->fecha = date('d-m-Y');
            $borrarinf->save();
            $totalpersonas = 0;
        }

        $borrarinf = Infpregunta::all();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('/layouts/admin/infPreguntaPdf', [
            'elperiodo' => $elperiodo,
            'cargoSelect' => $cargoSelect,
            'borrarinf' => $borrarinf,
        ])->setPaper('a4', 'landscape');
        return $pdf->download('eval-x-pregunta.pdf');
    }

    public function informePregunta()
    {
        if (auth()->user()->admin === "on") {
            $cargos = Cargo::all();
            $periodos = Periodo::whereIn('pordefecto', ['on'])->first();
            if (!isset($periodos)) {
                $periodos = Periodo::all();
            }
            return view('/layouts/admin/informePreguntas', [
                'cargos' => $cargos,
                'periodos' => $periodos,
            ]);
        } else {
            return view('errors/noHabilitado');
        }
    }

    public function informeComentario()
    {
        if (auth()->user()->admin === "on") {
            $cargos = Cargo::all();
            $periodos = Periodo::whereIn('pordefecto', ['on'])->first();
            if (!isset($periodos)) {
                $periodos = Periodo::all();
            }
            return view('/layouts/admin/informeComentarios', [
                'cargos' => $cargos,
                'periodos' => $periodos,
            ]);
        } else {
            return view('errors/noHabilitado');
        }
    }

    public function informeComentarioCreate(Request $request)
    {
        $borrarinf = Infjefatura::whereNotNull('id')->delete();
        $elperiodo = Periodo::whereIn('pordefecto', ['on'])->first();
        $totalcoment = 0;
        $subtotalpor = 0;
        if ($request->cargo_descrip === "Todos") {
            $cargoSelect = Cargo::all();
            //            $laspersonas = Persona::orderBy('cargo_id', 'ASC')->get();
            $laevaluacion = Evalua::whereNotNull('observacion');
            $laevaluacion = $laevaluacion->whereIn('periodo', [$elperiodo->descrip]);
            $laevaluacion = $laevaluacion->orderBy('cargo_id', 'DESC')->get();
        } else {
            $cargoSelect = Cargo::whereIn('descrip', [$request->cargo_descrip])->first();
            $laevaluacion = Evalua::whereIn('cargo_id', [$cargoSelect->id]);
            $laevaluacion = $laevaluacion->whereIn('periodo', [$elperiodo->descrip]);
            $laevaluacion = $laevaluacion->whereNotNull('observacion')->orderBy('cargo_id', 'DESC')->get();
        }
        $primeravez = 0;
        foreach ($laevaluacion as $laeval) {
            if ($primeravez === 1) {
                $borrarinf = Infjefatura::whereNotIn('id', [0])->latest('id')->first();
                if (isset($borrarinf)) {
                    if ($borrarinf->cant_porjefe != $laeval->cargo_id) {
                        $cargoEval = Cargo::find($borrarinf->cant_porjefe);
                        if (isset($cargoEval)) {
                            $borrarinf->descrip = $cargoEval->descrip;
                            $borrarinf->prom1 = $subtotalpor;
                            $borrarinf->save();
                        }
                        $subtotalpor = 0;
                    }
                }
            }
            $lapregunta = Pregunta::find($laeval->pregunta_id);
            $borrarinf = new Infjefatura();
            $personas = Persona::find($laeval->persona_id);
            $borrarinf->persona_nom = $personas->persona_nom1 . " " . $personas->persona_ape1;
            $borrarinf->periodo = $elperiodo->descrip;
            $borrarinf->nro = $lapregunta->pregunta_nro;
            $borrarinf->cant_porjefe = $laeval->cargo_id;
            $borrarinf->observa = $laeval->observacion;
            $borrarinf->save();
            $primeravez = 1;
            $totalcoment = $totalcoment + 1;
            $subtotalpor = $subtotalpor + 1;
        }
        $borrarinf = Infjefatura::whereNotIn('id', [0])->latest('id')->first();
        if (isset($borrarinf)) {
            $cargoEval = Cargo::find($borrarinf->cant_porjefe);
            if (isset($cargoEval)) {
                $borrarinf->descrip = $cargoEval->descrip;
                $borrarinf->prom1 = $subtotalpor;
                $borrarinf->save();
            }
        }

        $borrarinf = Infjefatura::whereNotIn('id', [0])->latest('id')->first();
        if (isset($borrarinf)) {
            $borrarinf->fecha = date('d-m-Y');
            $borrarinf->saldo_per = $totalcoment;
            $borrarinf->save();
        }
        $borrarinf = Infjefatura::all();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('/layouts/admin/infComentarioPdf', [
            'elperiodo' => $elperiodo,
            'cargoSelect' => $cargoSelect,
            'borrarinf' => $borrarinf,
        ])->setPaper('a4', 'landscape');
        return $pdf->download('eval-comentarios.pdf');
    }

    public function showCargoCreate()
    {
        $cargos = Cargo::all();
        $jefaturas = Jefatura::all();
        return view('/layouts/admin/cargoCreate', [
            'cargos' => $cargos,
            'jefaturas' => $jefaturas,
        ]);
    }

    public function showPeriodoCreate()
    {
        $periodos = Periodo::all();
        return view('/layouts/admin/PeriodoCreate', [
            'periodos' => $periodos,
        ]);
    }

    public function showJefaturaCreate()
    {
        $jefaturas = Jefatura::all();
        return view('/layouts/admin/JefaturaCreate', [
            'jefaturas' => $jefaturas,
        ]);
    }

    public function showTituloCreate()
    {
        $titulos = Titulo::all();
        return view('/layouts/admin/TituloCreate', [
            'titulos' => $titulos,
        ]);
    }

    public function showPreguntaCreate()
    {
        $preguntas = Pregunta::all();
        $jefaturas = Jefatura::all();
        $titulos = Titulo::all();
        $cargos = Cargo::all();
        return view('/layouts/admin/preguntaCreate', [
            'preguntas' => $preguntas,
            'jefaturas' => $jefaturas,
            'titulos' => $titulos,
            'cargos' => $cargos,
        ]);
    }

    public function showPersonaCreate()
    {
        $jefaturas = Jefatura::all();
        $cargos = Cargo::all();
        return view('/layouts/admin/personaCreate', [
            'jefaturas' => $jefaturas,
            'cargos' => $cargos,
        ]);
    }

    public function showAutoEvalCreate()
    {
        $jefaturas = Jefatura::all();
        $cargos = Cargo::all();
        $titulos = Titulo::all();
        return view('/layouts/admin/autoevaluaCreate', [
            'jefaturas' => $jefaturas,
            'cargos' => $cargos,
            'titulos' => $titulos,
        ]);
    }

    public function createCargo(Request $request)
    {
        $rules = [
            'descrip' => 'required|min:3',
            'jefatura_id' => 'required',
        ];
        $customMessages = [
            'descrip.required' => 'El campo descripción es obligatorio',
            'descrip.min'           => 'El campo descripción debe ser más de 3 caracteres',
            'jefatura_id.required' => 'El campo Jefatura es requerido',
        ];

        $request->validate($rules, $customMessages);
        $cargo = new Cargo();
        $cargo->descrip = $request->descrip;
        $cargo->jefatura_id = $request->jefatura_id;
        $cargo->save();
        return redirect('admin/cargos')->with('mensaje', 'Se ha creado correctamente el cargo: ' . $request->descrip);
    }

    public function createPeriodo(Request $request)
    {
        $rules = [
            'descrip' => 'required|min:3',
        ];
        $customMessages = [
            'descrip.required' => 'El campo descripción es obligatorio',
            'descrip.min'           => 'El campo descripción debe ser más de 3 caracteres',
        ];
        if ($request->pordefecto === 'on') {
            $periodoDefecto = Periodo::whereIn('pordefecto', ['on'])->get();
            if (isset($periodoDefecto)) {
                foreach ($periodoDefecto as $periodoporDef) {
                    $modificarPeriodo = Periodo::find($periodoporDef->id);
                    $modificarPeriodo->pordefecto = null;
                    $modificarPeriodo->save();
                }
            }
        }
        $request->validate($rules, $customMessages);
        $periodo = new Periodo();
        $periodo->descrip = $request->descrip;
        $periodo->pordefecto = $request->pordefecto;
        $periodo->save();
        return redirect('admin/periodos')->with('mensaje', 'Se ha creado correctamente: ' . $request->descrip);
    }

    public function createJefatura(Request $request)
    {
        $rules = [
            'descrip' => 'required|min:3|unique:jefaturas',
        ];
        $customMessages = [
            'descrip.required' => 'El campo descripción es obligatorio',
            'descrip.min'           => 'El campo descripción debe ser más de 3 caracteres',
            'descrip.unique' => 'Ya existe un registro con esta descripción.',
        ];

        $request->validate($rules, $customMessages);
        $jefatura = new Jefatura();
        $jefatura->descrip = $request->descrip;
        $jefatura->save();
        return redirect('admin/jefaturas')->with('mensaje', 'Se ha creado correctamente: ' . $request->descrip);
    }

    public function createTitulo(Request $request)
    {
        $rules = [
            'descrip' => 'required|min:3|max:40',
        ];
        $customMessages = [
            'descrip.required' => 'El campo descripción es obligatorio',
            'descrip.min'           => 'El campo descripción debe ser más de 3 caracteres',
            'descrip.max'           => 'El campo descripción debe ser menor o igual de 40 caracteres',
        ];

        $request->validate($rules, $customMessages);
        $titulo = new Titulo();
        $titulo->descrip = $request->descrip;
        $titulo->save();
        return redirect('admin/titulos')->with('mensaje', 'Se ha creado correctamente: ' . $request->descrip);
    }

    public function createPregunta(Request $request)
    {
        $rules = [
            'descrip' => 'required|min:3',
            'pregunta_nro' => 'required',
            'titulo_id' => 'required',
            'jefatura_id' => 'required',
            'cargo_id' => 'required',
        ];
        $customMessages = [
            'descrip.required' => 'El campo descripción es obligatorio',
            'descrip.min'           => 'El campo descripción debe ser más de 3 caracteres',
            'pregunta_nro.required' => 'El campo pregunta es requerido.',
            'titulo_id.required' => 'El campo título es requerido.',
            'jefatura_id.required' => 'El campo Jefatura es requerido',
            'cargo_id.required' => 'El campo Cargo es requerido',
        ];

        $request->validate($rules, $customMessages);
        $pregunta = new Pregunta();
        $pregunta->descrip = $request->descrip;
        $pregunta->pregunta_nro = $request->pregunta_nro;
        $pregunta->titulo_id = $request->titulo_id;
        $pregunta->jefatura_id = $request->jefatura_id;
        $pregunta->cargo_id = $request->cargo_id;
        $pregunta->save();
        return redirect('admin/preguntas')->with('mensaje', 'Se ha creado correctamente la pregunta Nro:' . $request->pregunta_nro);
    }

    public function createPersona(Request $request)
    {
        $rules = [
            'persona_doc' => 'required',
            'persona_nom1' => 'required',
            'persona_ape1' => 'required',
            'persona_ingreso' => 'required',
            'persona_nac' => 'required',
            'cargo_id' => 'required',
            'jefatura_id' => 'required',
        ];
        $customMessages = [
            'persona_doc.required' => 'El campo documento es obligatorio',
            'pregunta_nom1.required' => 'El campo primer nombre es requerido.',
            'pregunta_ape1.required' => 'El campo primer apellido es requerido.',
            'pregunta_ingreso.required' => 'El campo fecha ingreso es requerido.',
            'pregunta_nac.required' => 'El campo fecha nacimiento es requerido.',
            'cargo_id.required' => 'El campo título es requerido.',
            'jefatura_id.required' => 'El campo Jefatura es requerido',
        ];

        $request->validate($rules, $customMessages);
        $persona = new Persona();
        $persona->persona_doc = $request->persona_doc;
        $persona->persona_nom1 = $request->persona_nom1;
        $persona->persona_ape1 = $request->persona_ape1;
        $persona->persona_nom2 = $request->persona_nom2;
        $persona->persona_ape2 = $request->persona_ape2;
        $persona->persona_ingreso = $request->persona_ingreso;
        $persona->persona_nac = $request->persona_nac;
        $persona->cargo_id = $request->cargo_id;
        $persona->jefatura_id = $request->jefatura_id;
        $persona->esjefe = $request->esjefe;
        $persona->save();
        return redirect('admin/personas')->with('mensaje', 'Se ha creado correctamente el registro de:' . $request->persona_nom1 . ' ' . $request->persona_ape1);
    }

    public function createAutoEval(Request $request)
    {
        $rules = [
            'persona_id' => 'required',
            'jefatura_id' => 'required',
            'titulo_id' => 'required',
            'pregunta_id' => 'required',
            'puntos' => 'required',
            'periodo' => 'required',
        ];
        $customMessages = [
            'persona_id.required' => 'El campo persona es obligatorio',
            'jefatura_id.required' => 'El campo Jefatura es requerido.',
            'titulo_id.required' => 'El campo Título es requerido.',
            'pregunta_id.required' => 'El campo pregunta es requerido.',
            'puntos.required' => 'El campo de puntos es requerido.',
            'periodo.required' => 'El campo periodo es requerido.',
        ];

        $request->validate($rules, $customMessages);
        $autoeval = new Evalua();
        $autoeval->persona_id = $request->persona_id;
        $autoeval->jefatura_id = $request->jefatura_id;
        $autoeval->titulo_id = $request->titulo_id;
        $autoeval->pregunta_id = $request->pregunta_id;
        $autoeval->puntos = $request->puntos;
        $autoeval->periodo = $request->periodo;
        $autoeval->confirmado = 0;
        $autoeval->save();
        return redirect('admin/autoevaluaciones')->with('mensaje', 'Se han guardado correctamente las preguntas.');
    }

    public function showCargo()
    {
        if (auth()->user()->admin === "on") {
            $cargos = Cargo::simplePaginate(5);
            $jefaturas = Jefatura::all();
            return view('/layouts/admin/cargoView', [
                'cargos' => $cargos,
                'jefaturas' => $jefaturas,
            ]);
        } else {
            return view('errors/noHabilitado');
        }
    }

    public function showPeriodo()
    {
        if (auth()->user()->admin === "on") {
            $periodos = Periodo::simplePaginate(5);
            return view('/layouts/admin/periodoView', [
                'periodos' => $periodos,
            ]);
        } else {
            return view('errors/noHabilitado');
        }
    }

    public function showJefatura()
    {
        if (auth()->user()->admin === "on") {
            $jefaturas = Jefatura::simplePaginate(5);
            return view('/layouts/admin/jefaturaView', [
                'jefaturas' => $jefaturas,
            ]);
        } else {
            return view('errors/noHabilitado');
        }
    }

    public function showTitulo()
    {
        if (auth()->user()->admin === "on") {
            $titulos = Titulo::simplePaginate(5);
            return view('/layouts/admin/tituloView', [
                'titulos' => $titulos,
            ]);
        } else {
            return view('errors/noHabilitado');
        }
    }

    public function showPersona(Request $request)
    {
        //        $personas = Persona::paginate(5);
        if (auth()->user()->admin === "on") {
            $cargos = Cargo::all();
            $jefaturas = Jefatura::all();
            if (isset($request->jefatura_id)) {
                if (isset($request->persona_doc)) {
                    $personasView = Persona::where('jefatura_id', $request->jefatura_id);
                    $personasView = $personasView->where('persona_doc', $request->persona_doc)->simplePaginate(5);
                } else {
                    $personasView = Persona::where('jefatura_id', $request->jefatura_id)->simplePaginate(5);
                }
            } else {
                if (isset($request->persona_doc)) {
                    $personasView = Persona::where('persona_doc', $request->persona_doc)->simplePaginate(5);
                } else {

                    $personasView = Persona::simplePaginate(5);
                }
            }
            $personas = $personasView;
            return view('/layouts/admin/personaView', [
                'personas' => $personas,
                'cargos' => $cargos,
                'jefaturas' => $jefaturas,
            ]);
        } else {
            return view('errors/noHabilitado');
        }
    }

    public function showPregunta(Request $request)
    {
        if (auth()->user()->admin === "on") {
            $titulos = Titulo::all();
            $jefaturas = Jefatura::all();
            $cargos = Cargo::all();
            if (isset($request->cargo_id)) {
                if (isset($request->titulo_id)) {
                    $preguntasView = Pregunta::where('cargo_id', $request->cargo_id);
                    $preguntasView = $preguntasView->where('titulo_id', $request->titulo_id)->simplePaginate(5);
                } else {
                    $preguntasView = Pregunta::where('cargo_id', $request->cargo_id)->simplePaginate(5);
                }
            } else {
                if (isset($request->titulo_id)) {
                    $preguntasView = Pregunta::where('titulo_id', $request->titulo_id)->simplePaginate(5);
                } else {

                    $preguntasView = Pregunta::simplePaginate(5);
                }
            }
            $preguntas = $preguntasView;

            return view('/layouts/admin/preguntaView', [
                'preguntas' => $preguntas,
                'titulos' => $titulos,
                'jefaturas' => $jefaturas,
                'cargos' => $cargos,
            ]);
        } else {
            return view('errors/noHabilitado');
        }
    }

    public function showPersonaEval(Request $request)
    {
        //        $personas = Persona::paginate(5);
        $lapersona = Persona::where('persona_doc', Auth::user()->documento)->first();
        if (empty($lapersona)) {
        } else {
            $jefatura = Cargo::where('id', $lapersona->cargo_id)->first();
            $noesjefe = Jefatura::where('descrip', $lapersona->cargo->descrip)->first();
            if (empty($jefatura)) {
            } else {
                $evaluador = Jefatura::where('descrip', $jefatura->descrip)->first();
                if (empty($evaluador)) {
                    $personasView = Persona::where('jefatura_id', 0)->orderBy('persona_ape1')->simplePaginate(5);
                } else {
                    $personasView = Persona::where('jefatura_id', $evaluador->id)->orderBy('persona_ape1')->simplePaginate(5);
                }
            }
        }
        if (!empty($personasView)) {
            foreach ($personasView as $personaView) {
                $cuenta = Evalua::where('persona_id', $personaView->id)
                    ->whereIn('jefatura_eval', [0])
                    ->where('puntos', '>', 0)
                    ->whereIn('confirmado', [0, 1, 2])->count();
                if (!empty($cuenta)) {
                    $personaEdita = Persona::find($personaView->id);
                    $personaEdita->evalua = $cuenta;
                    $personaEdita->save();
                } else {
                    $personaEdita = Persona::find($personaView->id);
                    $personaEdita->evalua = 0;
                    $personaEdita->save();
                }
            }
        }
        $personas = $personasView;
        if (!empty($noesjefe)) {
            return view('/layouts/admin/evaluaCreate', [
                'personas' => $personas,
                'lapersona' => $lapersona,
            ]);
        } else {
            return view('/errors/noHabilitado');
        }
    }

    public function showAutoEval(Request $request)
    {
        $seleccperiodo = 0;

        if (isset($request->periodo_id)) {
            $periodosSelec = Periodo::where('id', $request->periodo_id)->first();
            $periodos = Periodo::all();
            $seleccperiodo = 1;
        } else {
            $periodos = Periodo::all();
            $periodosSelec = Periodo::orderby('id', 'DESC')->get();
        }
        //Ayudante informática y Jefe Adm
        if (Auth::user()->grupo === "Usuario") {
            $lapersona = Persona::where('persona_doc', Auth::user()->documento)->first();

            if (isset($request->titulo_id)) {
                $autoevalView = Evalua::where('titulo_id', $request->titulo_id);
                if (isset($request->periodo_id)) {
                    $autoevalView = $autoevalView->where('periodo', $periodosSelec->descrip);
                } else {
                    $autoevalView = $autoevalView->where('periodo', 'Sin Datos');
                }
                $autoevalView = $autoevalView->where('persona_id', $lapersona->id)->simplePaginate(8);
            } else {
                // Tiene que seleccionar tìtulo????
                $autoevalView = Evalua::where('titulo_id', 0);
                $autoevalView = $autoevalView->where('persona_id', $lapersona->id)->simplePaginate(8);
            }
            ///            $informaticas = Informatica::where('user_id', auth()->id())->paginate(5);

            $titulos = Titulo::all();
            $jefaturas = Jefatura::all();
            if ($autoevalView->isEmpty()) {
                if ($seleccperiodo === 1) {
                    $preguntas = Pregunta::where('cargo_id', $lapersona->cargo_id);
                    $preguntas = $preguntas->where('titulo_id', $request->titulo_id)->get();
                    foreach ($preguntas as $pregunta) {
                        $autoevalnew = new Evalua();
                        $autoevalnew->fecha = date('Y-m-d');
                        $autoevalnew->persona_id = $lapersona->id;
                        $autoevalnew->jefatura_id = $lapersona->jefatura_id;
                        $autoevalnew->cargo_id = $lapersona->cargo_id;
                        $autoevalnew->titulo_id = $request->titulo_id;
                        $autoevalnew->puntos = 0;
                        $autoevalnew->pregunta_id = $pregunta->id;
                        $autoevalnew->periodo = $periodosSelec->descrip;
                        $autoevalnew->confirmado = 0;
                        $autoevalnew->jefatura_eval = 0;
                        $autoevalnew->save();
                    }
                    $autoevalView = Evalua::where('titulo_id', $request->titulo_id);
                    $autoevalView = $autoevalView->where('periodo', $periodosSelec->descrip);
                    $autoevalView = $autoevalView->where('persona_id', $lapersona->id)->simplePaginate(8);
                }
            }
            $autoevaluas = $autoevalView;
            return view('/layouts/admin/autoevaluaCreate', [
                'autoevaluas' => $autoevaluas,
                'titulos' => $titulos,
                'jefaturas' => $jefaturas,
                'periodos' => $periodos,
            ]);
        }
    }

    public function showPermiso(Request $request)
    {
        if (auth()->user()->admin === "on") {
            if (isset($request->documento)) {
                $users = User::where('documento', $request->documento)->simplePaginate(5);
                return view('/layouts/admin/permisoView', [
                    'users' => $users,
                ]);
            } else {
                $users = User::simplePaginate(5);
                return view('/layouts/admin/permisoView', [
                    'users' => $users,
                ]);
            }
        } else {
            return view('errors/noHabilitado');
        }
    }

    public function showEvalEdit(Request $request, $id)
    {
        $seleccperiodo = 0;

        if (isset($request->periodo_id)) {
            $periodosSelec = Periodo::where('id', $request->periodo_id)->first();
            $periodos = Periodo::all();
            $seleccperiodo = 1;
        } else {
            $periodos = Periodo::all();
            $periodosSelec = Periodo::orderby('id', 'DESC')->get();
        }
        //Ayudante informática y Jefe Adm
        if (Auth::user()->grupo === "Usuario") {
            $lapersona = Persona::find($id);

            if (isset($request->titulo_id)) {
                $autoevalView = Evalua::where('titulo_id', $request->titulo_id);
                if (isset($request->periodo_id)) {
                    $autoevalView = $autoevalView->where('periodo', $periodosSelec->descrip);
                } else {
                    $autoevalView = $autoevalView->where('periodo', 'Sin Datos');
                }
                $autoevalView = $autoevalView->whereIn('jefatura_eval', [1]);
                $autoevalView = $autoevalView->where('persona_id', $lapersona->id)->simplePaginate(8);
            } else {
                // Tiene que seleccionar tìtulo????
                $autoevalView = Evalua::where('titulo_id', 0);
                $autoevalView = $autoevalView->whereIn('jefatura_eval', [1]);
                $autoevalView = $autoevalView->where('persona_id', $lapersona->id)->simplePaginate(8);
            }
            ///            $informaticas = Informatica::where('user_id', auth()->id())->paginate(5);

            $titulos = Titulo::all();
            $jefaturas = Jefatura::all();
            if ($autoevalView->isEmpty()) {
                if ($seleccperiodo === 1) {
                    $preguntas = Pregunta::where('cargo_id', $lapersona->cargo_id);
                    $preguntas = $preguntas->where('titulo_id', $request->titulo_id)->get();
                    foreach ($preguntas as $pregunta) {
                        $autoevalnew = new Evalua();
                        $autoevalnew->fecha = date('Y-m-d');
                        $autoevalnew->persona_id = $lapersona->id;
                        $autoevalnew->jefatura_id = $lapersona->jefatura_id;
                        $autoevalnew->cargo_id = $lapersona->cargo_id;
                        $autoevalnew->titulo_id = $request->titulo_id;
                        $autoevalnew->puntos = 0;
                        $autoevalnew->pregunta_id = $pregunta->id;
                        $autoevalnew->periodo = $periodosSelec->descrip;
                        $autoevalnew->confirmado = 0;
                        $autoevalnew->jefatura_eval = 1;
                        $autoevalnew->save();
                    }
                    $autoevalView = Evalua::where('titulo_id', $request->titulo_id);
                    $autoevalView = $autoevalView->where('periodo', $periodosSelec->descrip);
                    $autoevalView = $autoevalView->whereIn('jefatura_eval', [1]);
                    $autoevalView = $autoevalView->where('persona_id', $lapersona->id)->simplePaginate(8);
                }
            }
            $autoevaluas = $autoevalView;
            return view('/layouts/admin/evaluaShowCreate', [
                'autoevaluas' => $autoevaluas,
                'titulos' => $titulos,
                'jefaturas' => $jefaturas,
                'periodos' => $periodos,
                'lapersona' => $lapersona,
            ]);
        }
    }

    public function showUser()
    {
        $usuarios = User::all();
        return view('/layouts/admin/perfil', [
            'usuarios' => $usuarios,
        ]);
    }

    public function showCargoEdit($id)
    {
        $jefaturas = Jefatura::all();
        return view("/layouts/admin/cargoEditView", [
            "cargo" => Cargo::find($id),
            'jefaturas' => $jefaturas,
        ]);
    }

    public function showPeriodoEdit($id)
    {
        return view("/layouts/admin/periodoEditView", [
            "periodo" => Periodo::find($id),
        ]);
    }

    public function showJefaturaEdit($id)
    {
        return view("/layouts/admin/jefaturaEditView", [
            "jefatura" => Jefatura::find($id),
        ]);
    }

    public function showTituloEdit($id)
    {
        return view("/layouts/admin/tituloEditView", [
            "titulo" => Titulo::find($id),
        ]);
    }

    public function showPreguntaEdit($id)
    {
        $jefaturas = Jefatura::all();
        $titulos = Titulo::all();
        $cargos = Cargo::all();
        return view("/layouts/admin/preguntaEditView", [
            "pregunta" => Pregunta::find($id),
            'titulos' => $titulos,
            'jefaturas' => $jefaturas,
            'cargos' => $cargos,
        ]);
    }

    public function showPersonaEdit($id)
    {
        $jefaturas = Jefatura::all();
        $cargos = Cargo::all();
        return view("/layouts/admin/personaEditView", [
            "persona" => Persona::find($id),
            'cargos' => $cargos,
            'jefaturas' => $jefaturas,
        ]);
    }

    public function showPermisoEdit($id)
    {
        return view("/layouts/admin/permisoEditView", [
            "user" => User::find($id),
        ]);
    }

    public function showAutoEvalEdit($id)
    {
        return view("/layouts/admin/PuntoModal", [
            "autoevaluas" => Evalua::find($id),
        ]);
    }

    public function editCargo(Request $request, $id)
    {
        $rules = [
            'descrip' => 'required|max:100',
            'jefatura_id' => 'required',
        ];
        $customMessages = [
            'descrip.required' => 'El campo descripciòn es obligatorio',
            'descrip.max'           => 'El campo acepta hasta 100 caracteres',
            'jefatura_id.required' => 'El campo Jefatura es requerido',
        ];

        $request->validate($rules, $customMessages);
        $cargo = Cargo::find($id);
        $cargo->descrip = $request->descrip;
        $cargo->jefatura_id = $request->jefatura_id;
        $cargo->save();
        return redirect('/admin/cargos')->with('mensaje', "El cargo se ha modificado");
    }

    public function editPeriodo(Request $request, $id)
    {
        $rules = [
            'descrip' => 'required|max:100',
        ];
        $customMessages = [
            'descrip.required' => 'El campo descripciòn es obligatorio',
            'descrip.max'           => 'El campo acepta hasta 100 caracteres',
        ];
        if ($request->pordefecto === 'on') {
            $periodoDefecto = Periodo::whereIn('pordefecto', ['on'])->get();
            if (isset($periodoDefecto)) {
                foreach ($periodoDefecto as $periodoporDef) {
                    $modificarPeriodo = Periodo::find($periodoporDef->id);
                    $modificarPeriodo->pordefecto = null;
                    $modificarPeriodo->save();
                }
            }
        }

        $request->validate($rules, $customMessages);
        $periodo = Periodo::find($id);
        $periodo->descrip = $request->descrip;
        $periodo->pordefecto = $request->pordefecto;
        $periodo->save();
        return redirect('/admin/periodos')->with('mensaje', "El registro se ha modificado correctamente.");
    }

    public function editJefatura(Request $request, $id)
    {
        $rules = [
            'descrip' => 'required|max:100',
        ];
        $customMessages = [
            'descrip.required' => 'El campo descripciòn es obligatorio',
            'descrip.max'           => 'El campo acepta hasta 100 caracteres',
        ];

        $request->validate($rules, $customMessages);
        $jefatura = Jefatura::find($id);
        $jefatura->descrip = $request->descrip;
        $jefatura->save();
        return redirect('/admin/jefaturas')->with('mensaje', "El registro se ha modificado correctamente.");
    }

    public function editTitulo(Request $request, $id)
    {
        $rules = [
            'descrip' => 'required|max:100',
        ];
        $customMessages = [
            'descrip.required' => 'El campo descripciòn es obligatorio',
            'descrip.max'           => 'El campo acepta hasta 100 caracteres',
        ];

        $request->validate($rules, $customMessages);
        $titulo = Titulo::find($id);
        $titulo->descrip = $request->descrip;
        $titulo->save();
        return redirect('/admin/titulos')->with('mensaje', "El registro se ha modificado correctamente.");
    }

    public function editPregunta(Request $request, $id)
    {
        $rules = [
            'descrip' => 'required|min:3',
            'pregunta_nro' => 'required',
            'titulo_id' => 'required',
            'jefatura_id' => 'required',
            'cargo_id' => 'required',
        ];
        $customMessages = [
            'descrip.required' => 'El campo descripción es obligatorio',
            'descrip.min'           => 'El campo descripción debe ser más de 3 caracteres',
            'pregunta_nro.required' => 'El campo pregunta es requerido.',
            'titulo_id.required' => 'El campo título es requerido.',
            'jefatura_id.required' => 'El campo Jefatura es requerido',
            'cargo_id.required' => 'El campo Cargo es requerido',
        ];

        $request->validate($rules, $customMessages);
        $pregunta = Pregunta::find($id);
        $pregunta->descrip = $request->descrip;
        $pregunta->pregunta_nro = $request->pregunta_nro;
        $pregunta->titulo_id = $request->titulo_id;
        $pregunta->jefatura_id = $request->jefatura_id;
        $pregunta->cargo_id = $request->cargo_id;
        $pregunta->save();
        return redirect('/admin/preguntas')->with('mensaje', "La Pregunta se ha modificado");
    }

    public function editPersona(Request $request, $id)
    {
        $rules = [
            'persona_doc' => 'required',
            'persona_nom1' => 'required',
            'persona_ape1' => 'required',
            'persona_ingreso' => 'required',
            'persona_nac' => 'required',
            'cargo_id' => 'required',
            'jefatura_id' => 'required',
        ];
        $customMessages = [
            'persona_doc.required' => 'El campo documento es obligatorio',
            'persona_nom1.required' => 'El campo primer nombre es requerido.',
            'persona_ape1.required' => 'El campo primer apellido es requerido.',
            'persona_ingreso.required' => 'El campo fecha ingreso es requerido.',
            'persona_nac.required' => 'El campo fecha nacimiento es requerido.',
            'cargo_id.required' => 'El campo título es requerido.',
            'jefatura_id.required' => 'El campo Jefatura es requerido',
        ];

        $request->validate($rules, $customMessages);
        $persona = Persona::find($id);
        $persona->persona_doc = $request->persona_doc;
        $persona->persona_nom1 = $request->persona_nom1;
        $persona->persona_nom2 = $request->persona_nom2;
        $persona->persona_ape1 = $request->persona_ape1;
        $persona->persona_ape2 = $request->persona_ape2;
        $persona->persona_ingreso = $request->persona_ingreso;
        $persona->persona_nac = $request->persona_nac;
        $persona->cargo_id = $request->cargo_id;
        $persona->jefatura_id = $request->jefatura_id;
        $persona->save();
        return redirect('/admin/personas')->with('mensaje', "Se ha modificado correctamente");
    }

    public function editAutoEvalua(Request $request, $id)
    {
        $lapersona = Persona::where('persona_doc', Auth::user()->documento)->first();
        $rules = [
            'puntos' => 'required',
        ];
        $customMessages = [
            'puntos.required' => 'El campo de puntos es requerido.',
        ];

        $request->validate($rules, $customMessages);
        $autoevalua = Evalua::find($id);
        $autoevalua->puntos = $request->puntos;
        //        $autoevalua->observacion = $request->observacion;
        $autoevalua->save();

        $titulos = Titulo::all();
        $jefaturas = Jefatura::all();
        $periodos = Periodo::all();

        $autoevalView = Evalua::where('titulo_id', $autoevalua->titulo_id);
        $autoevalView = $autoevalView->where('periodo', $autoevalua->periodo);
        $autoevalView = $autoevalView->where('persona_id', $lapersona->id)->simplePaginate(8);

        $autoevaluas = $autoevalView;
        //    return redirect('/autoevaluaciones')->with('mensaje', "Se ha modificado correctamente");
        return redirect()->back();
    }

    public function editEvalua(Request $request, $id)
    {
        $lapersona = Persona::where('persona_doc', Auth::user()->documento)->first();
        $rules = [
            'puntos' => 'required',
        ];
        $customMessages = [
            'puntos.required' => 'El campo de puntos es requerido.',
        ];

        $request->validate($rules, $customMessages);
        $autoevalua = Evalua::find($id);
        $autoevalua->puntos = $request->puntos;
        $autoevalua->observacion = $request->observacion;
        $autoevalua->save();

        $autoevalView = Evalua::where('titulo_id', $autoevalua->titulo_id);
        $autoevalView = $autoevalView->where('periodo', $autoevalua->periodo);
        $autoevalView = $autoevalView->where('persona_id', $lapersona->id)->simplePaginate(8);

        ///        $autoevaluas = $autoevalView;
        return redirect()->back();
    }

    public function editPermiso(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:100',
            'documento' => 'required',
        ];
        $customMessages = [
            'name.required' => 'El campo nombre es obligatorio',
            'name.max'           => 'El campo acepta hasta 100 caracteres',
            'documento.required' => 'El campo documento es obligatorio.'
        ];

        $request->validate($rules, $customMessages);
        $user = User::find($id);
        $user->name = $request->name;
        $user->documento = $request->documento;
        $user->admin = $request->admin;
        $user->save();
        return redirect('/admin/permisos')->with('mensaje', "El registro se ha modificado correctamente.");
    }

    public function deleteCargo($id)
    {
        Cargo::find($id)->delete();
        return redirect('/admin/cargos')->with('mensaje', "El cargo $id  Se ha eliminado correctamente");
    }

    public function deletePermiso($id)
    {
        if (auth()->id() === $id) {
            return redirect('/admin/permisos')->with('mensaje', "El usuario $id  NO SE PUEDE ELIMINAR SI ESTA INICIADO!!!");
        } else {
            return redirect('/admin/permisos')->with('mensaje', "El usuario $id  Se ha eliminado correctamente");
        }
        //            User::find($id)->delete();
    }

    public function deletePeriodo($id)
    {
        Periodo::find($id)->delete();
        return redirect('/admin/periodos')->with('mensaje', "El registro $id  Se ha eliminado correctamente");
    }

    public function deleteJefatura($id)
    {
        Jefatura::find($id)->delete();
        return redirect('/admin/jefaturas')->with('mensaje', "El registro $id  Se ha eliminado correctamente");
    }

    public function deleteTitulo($id)
    {
        Titulo::find($id)->delete();
        return redirect('/admin/titulos')->with('mensaje', "El registro $id  Se ha eliminado correctamente");
    }

    public function deletePregunta($id)
    {
        Pregunta::find($id)->delete();
        return redirect('/admin/preguntas')->with('mensaje', "La pregunta $id  Se ha eliminado correctamente");
    }

    public function deletePersona($id)
    {
        Persona::find($id)->delete();
        return redirect('/admin/personas')->with('mensaje', "Se ha eliminado el número $id ");
    }

    public function deleteAutoEval($id)
    {
        Evalua::find($id)->delete();
        return redirect('/admin/autoevaluaciones')->with('mensaje', "Se ha eliminado el ID $id ");
    }

    public function showAutoevalCierre($documento)
    {
        $persona = Persona::where('persona_doc', $documento)->first();
        if (isset($persona)) {
            $autoevalua = Evalua::where('persona_id', $persona->id)
                ->whereIn('jefatura_eval', [0])->get();
            if ($autoevalua->isEmpty()) {
            } else {
                foreach ($autoevalua as $autoeval) {
                    $modificar = Evalua::find($autoeval->id);
                    $modificar->cerrada = 1;
                    $modificar->save();
                }
                $persona->autoeval_fin = 1;
                $persona->save();
            }
            return redirect()->back()->with('mensaje', "Evaluación cerrada correctamente.");
        } else {
            return redirect()->back()->with('mensaje', "ATENCION! No se pudo actualizar el registro.");
        }
    }

    public function showEvalCierre(Request $request, $id)
    {
        $persona = Persona::find($id);
        if (isset($persona)) {
            $autoevalua = Evalua::where('persona_id', $persona->id)
                ->whereIn('jefatura_eval', [1])->get();
            if ($autoevalua->isEmpty()) {
            } else {
                foreach ($autoevalua as $autoeval) {
                    $modificar = Evalua::find($autoeval->id);
                    $modificar->cerrada_jefe = 1;
                    $modificar->save();
                }
                $persona->autoeval_fin = 2;
                $persona->save();
            }
            ///            return view('/layouts/admin/evaluaCreate')->with('mensaje', "Evaluación cerrada correctamente");
            return redirect()->back()->with('mensaje', "Evaluación cerrada correctamente.");
        } else {
            return redirect()->back()->with('mensaje', "ATENCION! No se pudo actualizar el registro.");
        }
    }
}
