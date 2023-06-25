@extends('adminlte::page')

@section('content_header')
    <h1 style="color:blue">Personas</h1>
@stop


@section('content')

    @include('layouts.admin.message')
    @include('layouts.admin.errors')
    <div class="row" style="padding-left: 10px">
        <div class="col-lg-4 col-md-6">
            <a href="{{ url('admin/personas/crear') }}" class="btn btn-icon btn-2 btn-success">
                <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                Crear nuevo registro</a>
        </div>
        <div style="background-color:deepskyblue" class="col-lg-3 col-md-6">
            <h1 style="color:blue">Filtros:</h1>
        </div>
        <div style="background-color: deepskyblue" class="col-lg-5 col-md-6">
            <form action="" method="">
                @csrf
                <div class="form-group">
                    <label for="select-jefatura">Jefatura</label>
                    <select id="select-jefatura" class="form-control input-sm" name="jefatura_id">
                        <option value="">Seleccionar...</option>
                        @foreach ($jefaturas as $jefatura)
                            @if (request('jefatura_id') == $jefatura->id)
                                <option value="{{ $jefatura->id }}" selected>{{ $jefatura->descrip }}</option>
                            @else
                                <option value="{{ $jefatura->id }}">{{ $jefatura->descrip }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="select-documento">Documento</label>
                    <input style="width: 300px;" type="text" class="form-control" id="persona_doc" name="persona_doc"
                        placeholder="Ingresar documento" value="{{ old('persona_doc') }}">
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
                                <th>Documento</th>
                                <th>1er.Nombre</th>
                                <th>1er.Apellido</th>
                                <th>Cargo</th>
                                <th>Editar</th>
                                <th>Borrar</th>
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
                                        <form action="{{ url('/admin/personas/editar') }}" method="get">
                                            @csrf
                                            <input type="hidden" id="id" name="id"
                                                value="{{ $persona->id }}">

                                            <button type="submit" class="btn btn-sm btn-primary">Editar</button>
                                        </form>
                                    </td>
                                    <td style="width: 100px;">
                                        <a class="btn btn-sm btn-danger"
                                            href="{{ url('admin/personas/' . $persona->id . '/eliminar') }}"
                                            onclick="return confirm('¿Seguro que deseas eliminarlo?')">
                                            <span aria-hidden="true" class="glyphicon glyphicon-trash">
                                            </span>
                                            Borrar</a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $personas->links() }}

                </div>
            </div>

        </div>
    </div>
@endsection
