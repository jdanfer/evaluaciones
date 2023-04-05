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
              <h3 class="card-title">Modificación de Título</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
           <form action="{{ url('/admin/titulos/' . $titulo->id . '/editar') }}" method="post">
               @csrf
               <div class="form-group">
                  <label for="descrip">Descripción de Título</label>
                  <input type="text" class="form-control" id="descrip" name="descrip" placeholder="Descripción de título" value="{{ old('descrip', $titulo->descrip) }}">
               </div>
                <br>
                <button type="submit" class="btn btn-primary">Modificar</button>
           </form>
          </div>
        </div><!-- /.container -->
      </div>
</div>
@endsection
