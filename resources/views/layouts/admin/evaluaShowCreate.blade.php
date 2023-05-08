@extends('adminlte::page')

@section('content')


    <div class="header bg-gradient-default pb-8 pt-5 pt-md-8">
        @include('admin.message')
        @include('admin.errors')
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Evaluación A: {{ $lapersona->persona_nom1 }}
                                {{ $lapersona->persona_ape1 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="padding-left: 10px">
                <div class="col-lg-4 col-md-6">
                </div>
                <div class="col-lg-3 col-md-6">
                    <h1 style="color:blue">Filtros:</h1>
                </div>
                <div style="padding-left: 10px" class="col-lg-5 col-md-6">
                    <form action="" method="">
                        @csrf
                        <div class="form-group">
                            <label for="select-titulo">Título</label>
                            <select id="select-titulo" class="form-control input-sm" name="titulo_id">
                                <!--                     <option value="">Seleccionar...</option> -->
                                @foreach ($titulos as $titulo)
                                    @if (request('titulo_id') == $titulo->id)
                                        <option value="{{ $titulo->id }}" selected>{{ $titulo->descrip }}</option>
                                    @else
                                        <option value="{{ $titulo->id }}">{{ $titulo->descrip }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="select-periodo">Período</label>
                            <select id="select-periodo" class="form-control input-sm" name="periodo_id">
                                <!--                     <option value="">Seleccionar...</option> -->
                                <!--                <a class="nav-link" href="#" data-toggle="modal" data-target="#contacto-modal">Contacto</a> -->

                                @foreach ($periodos as $periodo)
                                    @if (request('periodo_id') == $periodo->id)
                                        <option value="{{ $periodo->id }}" selected>{{ $periodo->descrip }}</option>
                                    @else
                                        <option value="{{ $periodo->id }}">{{ $periodo->descrip }}</option>
                                    @endif
                                @endforeach
                            </select>
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
                                        <th>Nro.Pregunta</th>
                                        <th>Descripción</th>
                                        <th>Puntaje</th>
                                        <th>Editar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($autoevaluas))
                                        @foreach ($autoevaluas as $autoevalua)
                                            <tr>
                                                <td style="visibility: hidden">{{ $autoevalua->id }}</td>
                                                <td>{{ $autoevalua->pregunta->pregunta_nro }}</td>
                                                <td>{{ $autoevalua->pregunta->descrip }}</td>
                                                <td>{{ $autoevalua->puntos }}</td>
                                                <td style="width: 100px;">
                                                    <a class="btn btn-sm btn-primary" role="button" data-toggle="modal"
                                                        data-target="#modal-edit-{{ $autoevalua->id }}">Editar</a>
                                                    <div class="modal fade" id="modal-edit-{{ $autoevalua->id }}"
                                                        tabIndex="-1">
                                                        <div class="modal-dialog" role="document">
                                                            <form
                                                                action="{{ url('admin/evaluaciones/' . $autoevalua->id . '/editar') }}"
                                                                method="post">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header text-center">
                                                                        <h4 class="modal-title w-100 font-weight-bold">
                                                                            Puntaje de pregunta Nro:
                                                                            {{ $autoevalua->pregunta->pregunta_nro }}</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body mx-3">
                                                                        <div class="md-form mb-5">
                                                                            <label data-error="wrong" data-success="right"
                                                                                for="puntos">Puntos</label>
                                                                            <input type="number" min="1"
                                                                                max="4" style="width: 200px;"
                                                                                id="puntos" class="form-control validate"
                                                                                name="puntos"
                                                                                value="{{ old('puntos', $autoevalua->puntos) }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-body mx-3">
                                                                        <div class="md-form mb-5">
                                                                            <label for="observacion">Observaciones</label>
                                                                            <textarea class="form-control" name="observacion" id="observacion" rows="2">{{ old('observacion', $autoevalua->observacion) }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <input style="visibility: hidden" type="text"
                                                                        id="titulo_id" name="titulo_id"
                                                                        value="{{ old('titulo_id', $autoevalua->titulo_id) }}">
                                                                    <input style="visibility: hidden" type="text"
                                                                        id="periodo" name="periodo"
                                                                        value="{{ old('periodo', $autoevalua->periodo) }}">

                                                                    <div class="modal-footer d-flex justify-content-center">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Guardar</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $autoevaluas->links() }}

                </div>
            </div>
        </div>
        <div class="row" style="padding: 10px">
            <div class="col-lg-2 col-md-8">
                <div class="card">
                    <a href="/admin/evaluaciones" class="btn btn-danger btn-lg active" role="button"
                        aria-pressed="true">Ir a Personas</a>
                </div>
            </div>
            <div class="col-lg-7 col-md-8">

            </div>
            <div class="col-lg-3 col-md-8">
                <div class="card">
                    <a class="btn btn-warning btn-lg active"
                        href="{{ url('admin/evaluacion/' . $lapersona->id . '/cerrar') }}"
                        onclick="return confirm('¿Seguro que deseas cerrar la EVALUACIÓN?')">
                        <span aria-hidden="true" class="glyphicon glyphicon-trash">
                        </span>
                        Terminar Evaluación</a>
                </div>

            </div>


        </div>
    </div>

@endsection
