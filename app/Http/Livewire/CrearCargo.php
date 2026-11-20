<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;

use Livewire\Component;
use App\Models\Cargo;
use App\Models\Evalua;
use App\Models\Jefatura;
use RealRashid\SweetAlert\Facades\Alert;

class CrearCargo extends Component
{
    public $descrip, $jefatura_id;
    protected $rules = [
        'descrip' => 'required',
        'jefatura_id' => 'required',
    ];

    public function render()
    {
        $cargos = Cargo::all();
        $jefaturas = Jefatura::all();
        return view('livewire.crear-cargo', [
            'cargos' => $cargos,
            'jefaturas' => $jefaturas,
        ]);

        ///        return view('livewire.crear-cargo');
    }

    public function createCargo()
    {
        $this->validate();

        Cargo::create([
            'descrip' => $this->descrip,
            'jefatura_id' => $this->jefatura_id
        ]);
        $this->reset(['descrip', 'jefatura_id']);

        $this->emitTo('create-cargo', 'render');
        //        $this->emit('alert');

        Alert::success('Registro grabado.', 'Cargos');
    }

    //    public function createCargo(Request $request)
    //    {
    //        $rules = [
    //            'descrip' => 'required|min:3',
    //            'jefatura_id' => 'required',
    //        ];
    //        $customMessages = [
    //            'descrip.required' => 'El campo descripción es obligatorio',
    //            'descrip.min'           => 'El campo descripción debe ser más de 3 caracteres',
    //            'jefatura_id.required' => 'El campo Jefatura es requerido',
    //        ];

    //        $request->validate($rules, $customMessages);
    //        $cargo = new Cargo();
    //        $cargo->descrip = $request->descrip;
    //        $cargo->jefatura_id = $request->jefatura_id;
    //        $cargo->save();
    //        return redirect('admin/cargos')->with('mensaje', 'Se ha creado correctamente el cargo: ' . $request->descrip);
    //    }
}
