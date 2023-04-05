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
              <h3 class="card-title">Ingreso de Jefaturas</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ url('admin/jefaturas') }}" method="post">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="descrip">Descripción de Jefatura</label>
                  <input type="text" class="form-control" id="descrip" name="descrip" placeholder="Ingresar jefatura..." value="{{ old('descrip') }}">
                </div>
              </div>
              <br>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Agregar</button>
                <br>
                <br>
                <div>
                  <a class="btn btn-primary" href="{{ url('admin/jefaturas') }}" role="button">Volver</a>
                </div>
      
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>  
  </div>
@endsection
