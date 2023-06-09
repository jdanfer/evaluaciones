@extends('adminlte::page')

@section('content')

<div style="padding-left: 10px" class="header bg-gradient-default pb-8 pt-5 pt-md-8">
    @include('admin.message')
    @include('admin.errors')
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Informes de Promedios por Cargos</h3>
            </div>
            <br>
            <div class="card-header">
              <h4 class="card-title">Período seleccionado: {{$periodos->descrip}}</h4>
            </div>

            <!-- /.card-header -->
            <!-- form start -->
           <form action="{{ url('/admin/informes/cargosInf') }}" method="get">
               @csrf
               <div style="padding-left: 10px" class="form-group">
                   <label  for="select-cargo">Cargo</label>
                   <select id="select-cargo" class="form-control input-sm" name="cargo_descrip">
                       <option value="Todos">Todos</option>
                       @foreach ($cargos as $cargo)
                          @if (old('cargo_descrip') == $cargo->descrip)
                             <option value="{{ $cargo->descrip }}" selected>{{ $cargo->descrip }}</option>
                          @else
                             <option value="{{ $cargo->descrip }}">{{ $cargo->descrip }}</option>
                          @endif
                       @endforeach
                    </select>
                </div>

                <div style="padding-left: 10px">
                   <button type="submit" class="btn btn-primary">Procesar...</button>
                </div>
                <br>
           </form>
          </div>
        </div><!-- /.container -->
      </div>
</div>
@endsection
