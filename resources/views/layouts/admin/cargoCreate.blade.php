@extends('adminlte::page')

@section('content')

<div class="header bg-gradient-default pb-8 pt-5 pt-md-8">
    @include('admin.message')
    @include('admin.errors')
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Ingreso de Cargos</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ url('admin/cargos') }}" method="post">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="descrip">Descripción de cargo</label>
                  <input type="text" class="form-control" id="descrip" name="descrip" placeholder="Ingresar cargo..." value="{{ old('descrip') }}">
                </div>
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
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Agregar</button>
                <br>
                <br>
                <div>
                  <a class="btn btn-primary" href="{{ url('admin/cargos') }}" role="button">Volver</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>  
  </div>
@endsection
