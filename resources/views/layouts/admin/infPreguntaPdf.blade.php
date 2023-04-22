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
      <h3 style="color:blue">Promedios por Pregunta</h3>
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
            <th style="color: white; text-align: center" class="bg-primary">P1</th>
            <th style="color: white; text-align: center" class="bg-primary">P2</th>
            <th style="color: white; text-align: center" class="bg-primary">P3</th>
            <th style="color: white; text-align: center" class="bg-primary">P4</th>
            <th style="color: white; text-align: center" class="bg-primary">S/T</th>
            <th style="color: white; text-align: center" class="bg-primary">P5</th>
            <th style="color: white; text-align: center" class="bg-primary">P6</th>
            <th style="color: white; text-align: center" class="bg-primary">P7</th>
            <th style="color: white; text-align: center" class="bg-primary">P8</th>
            <th style="color: white; text-align: center" class="bg-primary">S/T</th>
            <th style="color: white; text-align: center" class="bg-primary">P9</th>
            <th style="color: white; text-align: center" class="bg-primary">P10</th>
            <th style="color: white; text-align: center" class="bg-primary">P11</th>
            <th style="color: white; text-align: center" class="bg-primary">P12</th>
            <th style="color: white; text-align: center" class="bg-primary">S/T</th>
            <th style="color: white; text-align: center" class="bg-primary">P13</th>
            <th style="color: white; text-align: center" class="bg-primary">P14</th>
            <th style="color: white; text-align: center" class="bg-primary">P15</th>
            <th style="color: white; text-align: center" class="bg-primary">P16</th>
            <th style="color: white; text-align: center" class="bg-primary">S/T</th>
            <th style="color: white; text-align: center" class="bg-primary">Total</th>

        </tr>
        </thead>
        <tbody>
          @foreach($borrarinf as $borrareva)
            <tr>
              <td>{{$borrareva->persona_nom}}</td>
              <td style="text-align: center">{{$borrareva->p1}}</td>
              <td style="text-align: center">{{$borrareva->p2}}</td>
              <td style="text-align: center">{{$borrareva->p3}}</td>
              <td style="text-align: center">{{$borrareva->p4}}</td>
              <td style="text-align: center">{{$borrareva->prom1}}</td>
              <td style="text-align: center">{{$borrareva->p5}}</td>
              <td style="text-align: center">{{$borrareva->p6}}</td>
              <td style="text-align: center">{{$borrareva->p7}}</td>
              <td style="text-align: center">{{$borrareva->p8}}</td>
              <td style="text-align: center">{{$borrareva->prom2}}</td>
              <td style="text-align: center">{{$borrareva->p9}}</td>
              <td style="text-align: center">{{$borrareva->p10}}</td>
              <td style="text-align: center">{{$borrareva->p11}}</td>
              <td style="text-align: center">{{$borrareva->p12}}</td>
              <td style="text-align: center">{{$borrareva->prom3}}</td>
              <td style="text-align: center">{{$borrareva->p13}}</td>
              <td style="text-align: center">{{$borrareva->p14}}</td>
              <td style="text-align: center">{{$borrareva->p15}}</td>
              <td style="text-align: center">{{$borrareva->p16}}</td>
              <td style="text-align: center">{{$borrareva->prom4}}</td>
              <td style="text-align: center">{{$borrareva->promtot}}</td>
            </tr>
            @if ($borrareva->estotal===99)
               <tr>
                 <td class="bg-success" style="color: white">Total Personas: {{$borrareva->cant_porjefe}}</td>
                 <td class="bg-success" style="text-align: center">{{$borrareva->sp1}}</td>
                 <td class="bg-success" style="text-align: center">{{$borrareva->sp2}}</td>
                 <td class="bg-success" style="text-align: center">{{$borrareva->sp3}}</td>
                 <td class="bg-success" style="text-align: center">{{$borrareva->sp4}}</td>
                 <td class="bg-success" style="text-align: center">{{$borrareva->sptotg1}}</td>
                 <td class="bg-success" style="text-align: center">{{$borrareva->sp5}}</td>
                 <td class="bg-success" style="text-align: center">{{$borrareva->sp6}}</td>
                 <td class="bg-success" style="text-align: center">{{$borrareva->sp7}}</td>
                 <td class="bg-success" style="text-align: center">{{$borrareva->sp8}}</td>
                 <td class="bg-success" style="text-align: center">{{$borrareva->sptotg2}}</td>
                 <td class="bg-success" style="text-align: center">{{$borrareva->sp9}}</td>
                 <td class="bg-success" style="text-align: center">{{$borrareva->sp10}}</td>
                 <td class="bg-success" style="text-align: center">{{$borrareva->sp11}}</td>
                 <td class="bg-success" style="text-align: center">{{$borrareva->sp12}}</td>
                 <td class="bg-success" style="text-align: center">{{$borrareva->sptotg3}}</td>
                 <td class="bg-success" style="text-align: center">{{$borrareva->sp13}}</td>
                 <td class="bg-success" style="text-align: center">{{$borrareva->sp14}}</td>
                 <td class="bg-success" style="text-align: center">{{$borrareva->sp15}}</td>
                 <td class="bg-success" style="text-align: center">{{$borrareva->sp16}}</td>
                 <td class="bg-success" style="text-align: center">{{$borrareva->sptotg4}}</td>
                 <td class="bg-success" style="text-align: center">{{$borrareva->sptotg}}</td>
   
                </tr>
                <br>
            @endif 

            @if ($borrareva->cambio_jefe===78)
               <tr>
                 <td class="bg-success" style="color: white">Total Personas</td>
                 <td class="bg-success" style="color: white">{{$borrareva->saldo_per}}</td>
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
