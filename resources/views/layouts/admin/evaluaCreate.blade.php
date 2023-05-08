@extends('adminlte::page')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />

@section('content_header')
    <h1 style="color:blue">Personas para evaluar por Jefatura: {{ $lapersona->cargo->descrip }}</h1>
@stop

@section('content')

    @include('layouts.admin.message')
    @include('layouts.admin.errors')

    <div class="row" style="padding: 10px">
        <div class="col-lg-12 col-md-8">
            <div class="card">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th style="visibility: hidden">Id</th>
                                <th>Documento</th>
                                <th>1er.Nombre</th>
                                <th>1er.Apellido</th>
                                <th>Cargo</th>
                                <th>Estado</th>
                                <th>Evaluar</th>
                                <th>PDF</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($personas as $persona)
                                <tr>
                                    <td style="visibility: hidden">{{ $persona->id }}</td>
                                    <td>{{ $persona->persona_doc }}</td>
                                    <td>{{ $persona->persona_nom1 }}</td>
                                    <td>{{ $persona->persona_ape1 }}</td>
                                    <td>{{ $persona->cargo->descrip }}</td>
                                    <td style="width: 100px;">
                                        <span class="badge bg-danger">Preguntas: {{ $persona->evalua }}</span>
                                    </td>
                                    <td style="width: 100px;">
                                        @if ($persona->autoeval_fin === 2)
                                            <a href="#" class="btn btn-sm btn-danger">Terminada</a>
                                        @else
                                            <a href="{{ url('admin/evaluaciones/' . $persona->id . '/editar') }}"
                                                class="btn btn-sm btn-primary">Evaluar</a>
                                        @endif
                                    </td>
                                    <td style="width: 100px;">
                                        @if ($persona->autoeval_fin === 2)
                                            <a href="{{ url('admin/evaluacion/' . $persona->id . '/pdf') }}" id="proceso"
                                                class="btn btn-sm btn-success">PDF</a>
                                        @else
                                            <a href="#" id="proceso" class="btn btn-sm btn-danger">PDF</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $personas->links() }}

        </div>
    </div>
    <div class="row" style="padding: 10px">
        <div class="col-lg-2 col-md-8">
            <div class="card">
                <a href="/home" class="btn btn-danger btn-lg active" role="button" aria-pressed="true">Ir al inicio</a>
            </div>
        </div>
        <div class="col-lg-10 col-md-8">

        </div>
    </div>
@endsection
