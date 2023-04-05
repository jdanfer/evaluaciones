@extends('adminlte::page')

@section('content_header')
     <h1 style="color:blue">PERMISOS</h1>
@stop

@section('content')

    @include('layouts.admin.message')
    @include('layouts.admin.errors')
    <div class="row" style="padding-left: 10px">
      <div class="col-lg-5 col-md-6">
        <form action="" method="">
            @csrf
            <div class="form-group">
               <label for="select-documento">Documento</label>
               <input style="width: 300px;" type="text" class="form-control" id="documento" name="documento" placeholder="Ingresar documento" value="{{ old('documento') }}">
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
                      <th>Nombre</th>
                      <th>Correo</th>
                      <th>Documento</th>
                      <th>Editar</th>
                      <th>Borrar</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($users as $user)
                      <tr>
                          <td style="visibility: hidden">{{ $user->id }}</td>
                          <td>{{ $user->name }}</td>
                          <td>{{ $user->email }}</td>
                          <td>{{ $user->documento }}</td>
                          <td style="width: 100px;">
                              <a href="{{ url('admin/permisos/' . $user->id . '/editar') }}" class="btn btn-sm btn-primary">Editar</a>
                          </td>
                          <td style="width: 100px;">
                            <a class="btn btn-sm btn-danger" href="{{ url('admin/permisos/' . $user->id . '/eliminar') }}" 
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
          {{ $users->links()}}

        </div>
    </div>
@endsection
