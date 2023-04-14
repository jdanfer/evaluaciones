<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- CSS Propio -->
    <link rel="stylesheet" href="css/styles.css">

</head>

<body>

<div class="row">
    <div class="col-lg-3 col-md-8">
      <a>
        <img style="width: 80px; height:40" id="header-logo" src="vendor/adminlte/dist/img/logo2p.png"/>
      </a>
      <h3 style="color:blue">Promedios por Jefaturas</h3>
      <table class="table table-sm">
        <thead>
          <tr>
            <th style="color:blue" class="table-info"> Período:{{$elperiodo->descrip}}</th>
          </tr>
        </thead>
      </table>

    </div>
</div>
<table border="1">
        <thead>
           <tr>
            <th style="width: 340px; color: white" class="bg-primary">Nombre</th>
            <th style="width: 130px; color: white; text-align: center" class="bg-primary">Competencias</th>
            <th style="width: 130px; color: white; text-align: center" class="bg-primary">Responsab.</th>
            <th style="width: 130px; color: white; text-align: center" class="bg-primary">Funciones</th>
            <th style="width: 130px; color: white; text-align: center" class="bg-primary">Actitud</th>
            <th style="width: 130px; color: white; text-align: center" class="bg-primary">Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($borrarinf as $borrareva)
            <tr>
              <td>{{$borrareva->persona_nom}}</td>
              <td style="text-align: center">{{$borrareva->prom1}}</td>
              <td style="text-align: center">{{$borrareva->prom2}}</td>
              <td style="text-align: center">{{$borrareva->prom3}}</td>
              <td style="text-align: center">{{$borrareva->prom4}}</td>
              <td style="text-align: center">{{$borrareva->promtot}}</td>
            </tr>
            @if ($borrareva->cambio_jefe===1)
              <tr>
                <td class="bg-success" style="color: white; text-align: center">Sub-Total {{$borrareva->jefatura}}: {{$borrareva->cant_porjefe}}</td>
                <td class="bg-success" style="color: white; text-align: center">{{$borrareva->tot_prom1}}</td>
                <td class="bg-success" style="color: white; text-align: center">{{$borrareva->tot_prom2}}</td>
                <td class="bg-success" style="color: white; text-align: center">{{$borrareva->tot_prom3}}</td>
                <td class="bg-success" style="color: white; text-align: center">{{$borrareva->tot_prom4}}</td>
                <td class="bg-success" style="color: white; text-align: center">{{$borrareva->tot_promg}}</td>
              </tr>
            @endif
            @if ($borrareva->estotal===99)
              <br>
              <tr>
                <td class="bg-success" style="color: white; text-align: center">Total personas: {{$borrareva->saldo_per}}</td>
                <td class="bg-success" style="color: white; text-align: center">{{$borrareva->totalgral1}}</td>
                <td class="bg-success" style="color: white; text-align: center">{{$borrareva->totalgral2}}</td>
                <td class="bg-success" style="color: white; text-align: center">{{$borrareva->totalgral3}}</td>
                <td class="bg-success" style="color: white; text-align: center">{{$borrareva->totalgral4}}</td>
                <td class="bg-success" style="color: white; text-align: center">{{$borrareva->totalgraltot}}</td>
    
              </tr>
  
            @endif
          @endforeach  
        </tbody>
</table>
<br>
@foreach($borrarinf as $borrareva)
  @if ($borrareva->fecha !=null)
  <div>
    <h4 style="color:blue">Fecha actual: {{$borrareva->fecha}}</h4>
  </div>
  @endif 
@endforeach

<!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- JS de Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

    <!-- JS de Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- JS de Vue.js -->
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>

    <!-- JS Propio -->
    <script src="js/app.js"> </script>

</body>

</html>