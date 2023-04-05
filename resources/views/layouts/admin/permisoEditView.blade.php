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
              <h3 class="card-title">Modificar datos de Usuario</h3>
            </div>
          </div>
        </div>
      </div>  
      <form action="{{ url('/admin/permisos/' . $user->id . '/editar') }}" method="post">
        @csrf
        <div class="row">
          <div class="col-md-6">    
            <div class="card-body">
                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="input-name">{{ __('Nombre') }}</label>
                    <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Nombre') }}" value="{{ old('name', $user->name) }}" required autofocus>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
          </div>
          <div class="col-md-6">    

          </div>
        </div>  
        <div class="row">
            <div class="col-md-4">            
              <div class="card-body">
                <label class="form-control-label" for="documento">Documento</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="documento" name="documento" placeholder="Cédula indentidad..." required value="{{ old('documento', $user->documento) }}">
                    <div class="input-group-append">
                       <div class="input-group-text">
                           <span class="fas fa-id-card"></span>
                       </div>
                    </div>      
                </div>
              </div>
            </div>
            <div class="col-md-8">            
              <div class="card-body">
                <div class="input-group mb-3">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" name="admin" id="admin" @if ($user->admin==='on') checked @endif>
                      <label class="custom-control-label" for="admin">Es un usuario Administrador</label>
                    </div>
                </div>
              </div>      
            </div>
        </div>
        <div class="row">
          <div class="col-md-6">  
             <div class="card-body">
                  <button type="submit" class="btn btn-primary">Modificar</button>
             </div>
          </div>
          <div class="col-md-6">  
            <div class="card-body">
                <a class="btn btn-primary" href="{{ url('admin/permisos') }}" role="button">Volver</a>
             </div>
          </div>
        </div>

      </form>
    </div>  
  </div>
@endsection
