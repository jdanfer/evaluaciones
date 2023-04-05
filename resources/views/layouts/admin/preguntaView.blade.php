@extends('adminlte::page')

@section('content_header')
    <!-- CSS de Bootstrap -->
<!--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->

     <h1 style="color:blue">Preguntas</h1>
@stop

@section('content')

    @include('layouts.admin.message')
    @include('layouts.admin.errors')
    <div class="row" style="padding-left: 10px">
      <div class="col-lg-4 col-md-6">
        <a href="{{ url('admin/preguntas/crear') }}" class="btn btn-icon btn-2 btn-success">
          <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
          Crear Pregunta</a>
      </div>
      <div style="background-color:deepskyblue" class="col-lg-3 col-md-6">
           <h1 style="color:blue">Filtros:</h1>
      </div>
      <div style="background-color: deepskyblue" class="col-lg-5 col-md-6">
        <form action="" method="">
            @csrf
            <div class="form-group">
                <label for="select-cargo">Cargo</label>
                <select id="select-cargo" class="form-control input-sm" name="cargo_id">
                   <option value="">Seleccionar...</option>
                   @foreach ($cargos as $cargo)
                       @if (request('cargo_id') == $cargo->id)
                           <option value="{{ $cargo->id }}" selected>{{ $cargo->descrip }}</option>
                       @else
                           <option value="{{ $cargo->id }}">{{ $cargo->descrip }}</option>
                       @endif
                   @endforeach
                 </select>
              </div>
              <div class="form-group">
                <label for="select-titulo">Títulos</label>
                <select id="select-titulo" class="form-control input-sm" name="titulo_id">
                   <option value="">Seleccionar...</option>
                   @foreach ($titulos as $titulo)
                       @if (request('titulo_id') == $titulo->id)
                           <option value="{{ $titulo->id }}" selected>{{ $titulo->descrip }}</option>
                       @else
                           <option value="{{ $titulo->id }}">{{ $titulo->descrip }}</option>
                       @endif
                   @endforeach
                 </select>
              </div>

              <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>
      </div>

    </div>
    <div class="row" style="padding: 10px">
      <div class="col-lg-12 col-md-8">
        <div class="card">
            <div class="table-responsive">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                      <th style="visibility: hidden">Id</th>
                      <th>Número</th>                      
                      <th>Pregunta</th>
                      <th>Título</th>
                      <th>Jefatura</th>
                      <th>Editar</th>
                      <th>Borrar</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($preguntas as $pregunta)
                      <tr>
                          <td style="visibility: hidden">{{ $pregunta->id }}</td>
                          <td>{{ $pregunta->pregunta_nro }}</td>
                          <td>{{ $pregunta->descrip }}</td>
                          <td>{{ $pregunta->titulo->descrip }}</td>
                          <td>{{ $pregunta->jefatura->descrip }}</td>
                          <td style="width: 100px;">
                              <a href="{{ url('admin/preguntas/' . $pregunta->id . '/editar') }}" class="btn btn-sm btn-primary">Editar</a>
                          </td>
                          <td style="width: 100px;">
                            <a class="btn btn-sm btn-danger" href="{{ url('admin/preguntas/' . $pregunta->id . '/eliminar') }}" 
                              onclick="return confirm('¿Seguro que deseas eliminarlo?')">
                              <span aria-hidden="true" class="glyphicon glyphicon-trash">
                              </span>
                              Borrar</a>

                          </td>
                        </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="d-flex justify-content-center">
            {!! $preguntas->links() !!}
         </div>
        </div>
    </div>
    @endsection
