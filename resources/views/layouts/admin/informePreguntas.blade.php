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
              <h3 class="card-title">Informes de Promedios por Preguntas</h3>
            </div>
            <br>
            <div class="card-header">
              <h4 class="card-title">Período seleccionado: {{$periodos->descrip}}</h4>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
           <form action="{{ url('/admin/informes/preguntasInf') }}" method="get">
               @csrf
               <div style="padding-left: 10px" class="form-group">
                   <label  for="select-titulo">Título</label>
                   <select id="select-titulo" class="form-control input-sm" name="titulo_descrip">
                       <option value="Todos">Todos</option>
                       @foreach ($titulos as $titulo)
                          @if (old('titulo_descrip') == $titulo->descrip)
                             <option value="{{ $titulo->descrip }}" selected>{{ $titulo->descrip }}</option>
                          @else
                             <option value="{{ $titulo->descrip }}">{{ $titulo->descrip }}</option>
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
