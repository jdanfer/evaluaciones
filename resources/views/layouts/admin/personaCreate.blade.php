@extends('adminlte::page')

@section('content')

<div class="header bg-gradient-default pb-8 pt-5 pt-md-8">
    @include('admin.message')
    @include('admin.errors')
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-10">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Ingreso de Personas</h3>
            </div>
          </div>
        </div>
      </div>  
      <form action="{{ url('admin/personas') }}" method="post">
        @csrf
        <div class="row">
          <div class="col-md-6">  
            <div class="form-group">
              <label for="persona_doc">Número identificación</label>
              <input style="width: 300px;" type="text" class="form-control" id="persona_doc" name="persona_doc" placeholder="Ingresar documento" value="{{ old('persona_doc') }}">
            </div>
          </div>
          <div class="col-md-6">  
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" name="esjefe" id="esjefe">
              <label class="custom-control-label" for="esjefe">Es Jefatura/Evaluador</label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">  
            <div class="form-group">
               <label for="persona_nom1">Primer Nombre</label>
               <input type="text" class="form-control" id="persona_nom1" name="persona_nom1" required placeholder="Ingresar primer nombre" value="{{ old('persona_nom1') }}">
            </div>
          </div>
          <div class="col-md-6">  
            <div class="form-group">
               <label for="persona_nom2">Segundo Nombre</label>
               <input type="text" class="form-control" id="persona_nom2" name="persona_nom2" placeholder="Ingresar segundo nombre" value="{{ old('persona_nom2') }}">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">  
            <div class="form-group">
               <label for="persona_ape1">Primer Apellido</label>
               <input type="text" class="form-control" id="persona_ape1" name="persona_ape1" required placeholder="Ingresar primer apellido" value="{{ old('persona_ape1') }}">
            </div>
          </div>
          <div class="col-md-6">  
            <div class="form-group">
               <label for="persona_ape2">Segundo Apellido</label>
               <input type="text" class="form-control" id="persona_ape2" name="persona_ape2" placeholder="Ingresar segundo apellido" value="{{ old('persona_ape2') }}">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">  
           <div class="form-group">
             <label for="select-cargo">Cargo</label>
             <select id="select-cargo" class="form-control input-sm" name="cargo_id">
                <option value="">Seleccionar...</option>
                 @foreach ($cargos as $cargo)
                    @if (old('cargo_id') == $cargo->id)
                        <option value="{{ $cargo->id }}" selected>{{ $cargo->descrip }}</option>
                    @else
                        <option value="{{ $cargo->id }}">{{ $cargo->descrip }}</option>
                    @endif
                @endforeach
              </select>
           </div>
          </div>
          <div class="col-md-6">  
            <div class="form-group">
              <label for="select-jefatura">Jefatura</label>
              <select id="select-jefatura" class="form-control input-sm" name="jefatura_id">
                 <option value="">Seleccionar...</option>
                 @foreach ($jefaturas as $jefatura)
                     @if (old('jefatura_id') == $jefatura->id)
                         <option value="{{ $jefatura->id }}" selected>{{ $jefatura->descrip }}</option>
                     @else
                         <option value="{{ $jefatura->id }}">{{ $jefatura->descrip }}</option>
                     @endif
                 @endforeach
               </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">  
            <div class="form-group">
               <label for="persona_ingreso">Fecha de ingreso</label>
               <input type="date" style="width:200px" class="form-control" id="persona_ingreso" name="persona_ingreso" value="{{ old('persona_ingreso') }}">
            </div>
          </div>
          <div class="col-md-6">  
            <div class="form-group">
                <label for="persona_nac">Fecha de nacimiento</label>
                <input type="date" style="width:200px" class="form-control" id="persona_nac" name="persona_nac" value="{{ old('persona_nac') }}">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">  
             <div class="card-body">
                  <button type="submit" class="btn btn-primary">Agregar</button>
             </div>
          </div>
          <div class="col-md-6">  
            <div class="card-body">
                <a class="btn btn-primary" href="{{ url('admin/personas') }}" role="button">Volver</a>
             </div>
          </div>
        </div>

      </form>
    </div>  
  </div>
@endsection
