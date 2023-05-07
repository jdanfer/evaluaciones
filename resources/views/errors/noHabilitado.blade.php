@extends('adminlte::page')
@section('content')
    <div class="header bg-gradient-default pb-8 pt-5 pt-md-8">
        <div class="header bg-gradient-default pb-8 pt-5 pt-md-8">
            @include('layouts.admin.message')
            @include('layouts.admin.errors')
            <div class="row" style="padding: 10px">
                <div class="col-lg-6 col-md-8">
                    <h1 style="color: blue">Opción no habilitada a este usuario</h1>
                </div>
            </div>

            <div>
                <a class="btn btn-danger" href="{{ url('/') }}" role="button">Ir al inicio</a>
            </div>
        </div>
    @endsection
