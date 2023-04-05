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
              <h3 class="card-title">Modificación de Jefatura</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
           <form action="{{ url('/admin/jefaturas/' . $jefatura->id . '/editar') }}" method="post">
               @csrf
               <div class="form-group">
                  <label for="descrip">Descripción de Jefatura</label>
                  <input type="text" class="form-control" id="descrip" name="descrip" placeholder="Descripción de jefatura" value="{{ old('descrip', $jefatura->descrip) }}">
               </div>
                <br>
                <button type="submit" class="btn btn-primary">Modificar</button>
           </form>
          </div>
        </div><!-- /.container -->
      </div>
</div>
@endsection
