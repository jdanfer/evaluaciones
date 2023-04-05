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
              <h3 class="card-title">Modificación de cargo</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
           <form action="{{ url('/admin/cargos/' . $cargo->id . '/editar') }}" method="post">
               @csrf
               <div class="form-group">
                  <label for="descrip">Descripción de cargo</label>
                  <input type="text" class="form-control" id="descrip" name="descrip" placeholder="Descripción de cargo" value="{{ old('descrip', $cargo->descrip) }}">
               </div>
               <div class="form-group">
                   <label for="select-jefatura">Jefatura</label>
                   <select id="select-jefatura" class="form-control input-sm" name="jefatura_id">
                       <option value="">Seleccionar...</option>
                       @foreach ($jefaturas as $jefatura)
                         @if (old('jefatura_id', $cargo->jefatura_id) == $jefatura->id)
                             <option value="{{ $jefatura->id }}" selected>{{ $jefatura->descrip }}</option>
                         @else
                            <option value="{{ $jefatura->id }}">{{ $jefatura->descrip }}</option>
                         @endif
                       @endforeach
                   </select>
                </div>
                <button type="submit" class="btn btn-primary">Modificar</button>
           </form>
          </div>
        </div><!-- /.container -->
      </div>
</div>
@endsection
