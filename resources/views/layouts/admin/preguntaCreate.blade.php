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
              <h3 class="card-title">Ingreso de Preguntas</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ url('admin/preguntas') }}" method="post">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="descrip">Descripción de la pregunta</label>
                  <input type="text" class="form-control" id="descrip" name="descrip" placeholder="Ingresar pregunta..." value="{{ old('descrip') }}">
                </div>
                <div class="form-group">
                    <label for="pregunta_nro">Número de la pregunta</label>
                    <input style="width: 200px;" min="1" type="number" class="form-control" id="pregunta_nro" name="pregunta_nro" placeholder="Ingresar Número" value="{{ old('pregunta_nro') }}">
                </div>
                <div class="form-group">
                  <label for="select-titulo">Título</label>
                  <select id="select-titulo" class="form-control input-sm" name="titulo_id">
                     <option value="">Seleccionar...</option>
                     @foreach ($titulos as $titulo)
                         @if (old('titulo_id') == $titulo->id)
                             <option value="{{ $titulo->id }}" selected>{{ $titulo->descrip }}</option>
                         @else
                             <option value="{{ $titulo->id }}">{{ $titulo->descrip }}</option>
                         @endif
                     @endforeach
                   </select>
                </div>
                <div class="form-group">
                  <label for="select-cargo">Cargo</label>
                  <select style="width: 500px;" id="select-cargo" class="form-control input-sm" name="cargo_id">
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
                <div class="form-group">
                  <label for="select-jefatura">Jefatura</label>
                  <select style="width: 500px;" id="select-jefatura" class="form-control input-sm" name="jefatura_id">
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
                  <a class="btn btn-primary" href="{{ url('admin/preguntas') }}" role="button">Volver</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>  
  </div>
@endsection
