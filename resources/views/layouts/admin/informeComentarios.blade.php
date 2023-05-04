@extends('adminlte::page')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />

@section('content')

<div style="padding-left: 10px" class="header bg-gradient-default pb-8 pt-5 pt-md-8">
    @include('admin.message')
    @include('admin.errors')
    <br>
    <div class="container-fluid">
      <div style="display: none;
      position: fixed;
      width: 100%;
      height: 100%;
      margin-top: 100px;
      top: 0;
      left: 0;
      text-align: center;
      background-color: rgba(255, 255, 255, 0.8);
      z-index: 2;" id="spinner-div" class="pt-5">
        <div class="spinner-border text-primary" role="status">
        </div>
    </div>
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Informes de Comentarios por personas</h3>
            </div>
            <br>
            <div class="card-header">
              <h4 class="card-title">Período seleccionado: {{$periodos->descrip}}</h4>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form wire:submit.prevent="submit" action="{{ url('/admin/informes/comentariosInf') }}" method="get">
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
                  <button type="submit" id="proceso" class="btn btn-primary">Procesar...</button>
               </div>
          </form>
          </div>

        </div><!-- /.container -->
      </div>
</div>
<script>
$(document).ready(function () {
    $("#proceso").click(function () {//The load button
        $('#spinner-div').show();//Load button clicked show spinner
        $.ajax({
            url: "",
            type: 'GET',
            dataType: 'json',
            success: function (res) {
               //On success do something....
            },
            complete: function () {
              setTimeout(() => $('#spinner-div').hide(), 5000);
//              $('#spinner-div').hide();//Request is complete so hide spinner
            }
        });
    });
});
</script>
@endsection
