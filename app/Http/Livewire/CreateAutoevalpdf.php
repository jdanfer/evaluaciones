<?php

namespace App\Http\Livewire;

use App\Models\Infevalula;
use Livewire\Component;
use App\Models\Periodo;
use App\Models\Persona;
use App\Models\Evalua;
use App\Models\Pregunta;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class CreateAutoevalpdf extends Component
{
    public function render()
    {
        return view('livewire.create-autoevalpdf');
    }

    public function generarPDF(Request $request, $documento)
    {
        //        $pdf = PDF::loadView('libro.pdf');
        //        $pdf->loadHTML('<h1>Test</h1>');
        $elperiodo = Periodo::whereIn('pordefecto', ['on'])->first();
        $lapersona = Persona::find($documento);

        $autoevaluas = Evalua::where('persona_id', $lapersona->id);
        $autoevaluas = $autoevaluas->whereNotIn('jefatura_eval', [1]);
        $autoevaluas = $autoevaluas->orderBy('nro_pregunta', 'DESC')->get();
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

        $borrarinf = Infevalula::where('jefatura', $lapersona->jefatura->descrip);
        $borrarinf = $borrarinf->orderBy('nro', 'DESC')->get();
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
        $cambiodetitulo = 0;
        $tituloanterior = "Sin datos";
        foreach ($borrarinf as $evaljefe) {
            $infevaluas = Infevalula::find($evaljefe->id);
            $autoevaluas = Evalua::where('persona_id', $lapersona->id);
            $autoevaluas = $autoevaluas->whereIn('pregunta_id', [$evaljefe->pregunta_id]);
            $autoevaluas = $autoevaluas->where('jefatura_eval', 1)->first();
            if (isset($autoevaluas)) {
                if ($idanterior === 0) {
                } else {
                    $idanterior = $evaljefe->id - 1;
                    $infmodif = Infevalula::find($idanterior);
                    $tituloanterior = $infmodif->titulo;
                    if ($evaljefe->titulo != $tituloanterior) {
                        $cambiodetitulo = 1;
                    }
                    if ($cambiodetitulo === 1) {
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
                        $cambiodetitulo = 0;
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
                if ($idanterior != 0) {
                    $idanterior = $evaljefe->id - 1;
                    $infmodif = Infevalula::find($idanterior);
                    $tituloanterior = $infmodif->titulo;
                    if ($evaljefe->titulo != $tituloanterior) {
                        $cambiodetitulo = 1;
                    }
                }
                if ($cambiodetitulo === 1 && $idanterior > 0) {
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
                    $cambiodetitulo = 0;
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
}
