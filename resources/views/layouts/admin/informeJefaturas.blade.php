@extends('adminlte::page')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />

@section('content')

<div style="padding-left: 10px" class="header bg-gradient-default pb-8 pt-5 pt-md-8">
    @include('admin.message')
    @include('admin.errors')
    <div class="container-fluid">
      <br>
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
              <h3 class="card-title">Informes de Promedios por Jefaturas</h3>
            </div>
            <br>
            <div class="card-header">
              <h4 class="card-title">Período seleccionado: {{$periodos->descrip}}</h4>
            </div>

            <!-- /.card-header -->
            <!-- form start -->
           <form action="{{ url('/admin/informes/jefaturasInf') }}" id="some-form" method="get">
               @csrf
               <div style="padding-left: 10px" class="form-group">
                   <label  for="select-jefatura">Jefatura</label>
                   <select id="select-jefatura" class="form-control input-sm" name="jefatura_descrip">
                       <option value="Todos">Todos</option>
                       @foreach ($jefaturas as $jefatura)
                          @if (old('jefatura_descrip') == $jefatura->descrip)
                             <option value="{{ $jefatura->descrip }}" selected>{{ $jefatura->descrip }}</option>
                          @else
                             <option value="{{ $jefatura->descrip }}">{{ $jefatura->descrip }}</option>
                          @endif
                       @endforeach
                    </select>
                </div>

                <div style="padding-left: 10px">
                   <button type="submit" id="proceso" class="btn btn-primary">Procesar...</button>
                </div>
                <br>
           </form>
          </div>
        </div><!-- /.container -->
      </div>
</div>
<script>
//let form = document.querySelector('#some-form');
//let loader = document.querySelector('#spinner-div')
//form.addEventListener('submit', function (event) {
//    event.preventDefault();
  
    // using non css framework method with Style
//    loader.style.display = 'block';
  
    // using a css framework such as TailwindCSS
//    loader.classList.remove('hidden');

    // pretend the form has been sumitted and returned
//    setTimeout(() => loader.style.display = 'none', 15000);
//});
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
