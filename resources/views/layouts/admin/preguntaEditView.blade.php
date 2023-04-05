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
              <h3 class="card-title">Modificación de Pregunta</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
           <form action="{{ url('/admin/preguntas/' . $pregunta->id . '/editar') }}" method="post">
               @csrf
               <div class="form-group">
                  <label for="descrip">Descripción</label>
                  <input type="text" class="form-control" id="descrip" name="descrip" placeholder="Descripción de pregunta..." value="{{ old('descrip', $pregunta->descrip) }}">
               </div>
               <div class="form-group">
                  <label for="pregunta_nro">Número de pregunta</label>
                  <input style="width: 200px;" type="number" class="form-control" id="pregunta_nro" name="pregunta_nro" placeholder="Número..." value="{{ old('pregunta_nro', $pregunta->pregunta_nro) }}">
               </div>
               <div class="form-group">
                 <label for="select-titulo">Título</label>
                 <select id="select-titulo" class="form-control input-sm" name="titulo_id">
                    <option value="">Seleccionar...</option>
                    @foreach ($titulos as $titulo)
                      @if (old('titulo_id', $pregunta->titulo_id) == $titulo->id)
                          <option value="{{ $titulo->id }}" selected>{{ $titulo->descrip }}</option>
                      @else
                         <option value="{{ $titulo->id }}">{{ $titulo->descrip }}</option>
                      @endif
                    @endforeach
                 </select>
              </div>
              <div class="form-group">
                <label for="select-cargo">Cargo</label>
                <select id="select-cargo" class="form-control input-sm" name="cargo_id">
                    <option value="">Seleccionar...</option>
                    @foreach ($cargos as $cargo)
                      @if (old('cargo_id', $pregunta->cargo_id) == $cargo->id)
                          <option value="{{ $cargo->id }}" selected>{{ $cargo->descrip }}</option>
                      @else
                         <option value="{{ $cargo->id }}">{{ $cargo->descrip }}</option>
                      @endif
                    @endforeach
                </select>
             </div>

               <div class="form-group">
                   <label for="select-jefatura">Jefatura</label>
                   <select id="select-jefatura" class="form-control input-sm" name="jefatura_id">
                       <option value="">Seleccionar...</option>
                       @foreach ($jefaturas as $jefatura)
                         @if (old('jefatura_id', $pregunta->jefatura_id) == $jefatura->id)
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
