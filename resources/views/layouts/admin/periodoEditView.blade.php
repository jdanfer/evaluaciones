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
              <h3 class="card-title">Modificación de Período</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
           <form action="{{ url('/admin/periodos/' . $periodo->id . '/editar') }}" method="post">
               @csrf
               <div class="form-group">
                  <label for="descrip">Descripción de Período</label>
                  <input type="text" style="width: 300px" class="form-control" id="descrip" name="descrip" placeholder="Descripción de período..." value="{{ old('descrip', $periodo->descrip) }}">
               </div>
               <div class="form-group">
                  <div class="input-group mb-3">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="pordefecto" id="pordefecto" @if ($periodo->pordefecto==='on') checked @endif>
                        <label class="custom-control-label" for="pordefecto">Período predeterminado para informes</label>
                      </div>
                  </div>
                </div>        
               <br>
                <button type="submit" class="btn btn-primary">Modificar</button>
           </form>
          </div>
        </div><!-- /.container -->
      </div>
</div>
@endsection
