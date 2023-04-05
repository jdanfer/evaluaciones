@extends('adminlte::page')

@section('content')

<div class="header bg-gradient-default pb-8 pt-5 pt-md-8">
    @include('layouts.admin.message')
    @include('layouts.admin.errors')
    <div class="row" style="padding-left: 10px">
      <div class="col-lg-6 col-md-8">
          <h1 style="color: blue">Jefaturas registradas</h1>
      </div>
    </div>
    <div class="row" style="padding-left: 10px">
      <div class="col-lg-3 col-md-8">
        <a href="{{ url('admin/jefaturas/crear') }}" class="btn btn-icon btn-2 btn-success">
          <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
          Crear nuevo registro</a>
      </div>
      <div class="col-lg-3 col-md-8">
      </div>

      <div class="col-lg-3 col-md-8">
          <br>
      </div>
      <div class="col-lg-3 col-md-8">

      </div>
    </div>
    <div class="row" style="padding: 10px">
      <div class="col-lg-8 col-md-8">
        <div class="card">
            <div class="table-responsive">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                      <th>Id</th>
                      <th>Descripción</th>
                      <th>Editar</th>
                      <th>Borrar</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($jefaturas as $jefatura)
                      <tr>
                          <td>{{ $jefatura->id }}</td>
                          <td>{{ $jefatura->descrip }}</td>
                          <td style="width: 100px;">
                              <a href="{{ url('admin/jefaturas/' . $jefatura->id . '/editar') }}" class="btn btn-sm btn-primary">Editar</a>
                          </td>
                          <td style="width: 100px;">
                            <a class="btn btn-sm btn-danger" href="{{ url('admin/jefaturas/' . $jefatura->id . '/eliminar') }}" 
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
          {{ $jefaturas->links()}}

        </div>
    </div>
  </div>
@endsection
