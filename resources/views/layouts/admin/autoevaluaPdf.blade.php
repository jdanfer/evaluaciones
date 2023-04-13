
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
      <h3 style="color:blue">Informe Evaluación del Desempeño de:</h3>
      <table class="table table-sm">
        <thead>
          <tr>
            <th style="color:blue" class="table-info">{{$lapersona->persona_nom1}} {{$lapersona->persona_ape1}}</th>
            <th style="color:blue" class="table-info">{{$lapersona->cargo->descrip}}</th>
            <th style="color:blue" class="table-info"> Período:{{$elperiodo->descrip}}</th>
          </tr>
        </thead>
      </table>

    </div>
</div>
<table border="1">
        <thead>
           <tr>
            <th style="width: 60px" class="table-success">Nro</th>
            <th style="width: 470px" class="table-success">Descripción de pregunta</th>
            <th style="width: 80px; text-align: center" class="table-success">Auto</th>
            <th style="width: 80px; text-align: center" class="table-success">Eval</th>
            <th style="width: 100px; text-align: center" class="table-success">Promed.</th>
            <th style="width: 200px" class="table-success">Observaciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($borrarinf as $borrareva)
            @if ($borrareva->nro===1)
              <tr>
                <td style="font-size: 12px" class="bg-primary">##</td>
                  <td style="color: white;font-size: 12px" class="bg-primary">{{$borrareva->titulo}}</td>
                </tr>
            @endif
            <tr>
              <td style="width: 60px">{{$borrareva->nro}}</td>
              <td style="width: 470px">{{$borrareva->descrip}}</td>
              <td style="width: 80px; text-align: center">{{$borrareva->autoeval}}</td>
              <td style="width: 80px; text-align: center">{{$borrareva->evalua}}</td>
              <td style="width: 100px; text-align: center">{{$borrareva->promedio}}</td>
              <td style="width: 200px">{{$borrareva->observa}}</td>
            </tr>
            @if ($borrareva->promedio_tit===99)
               <tr>
                 <td class="bg-success" style="color: white">#</td>
                 <td class="bg-success" style="color: white">Sub-Total Promedio por título: {{$borrareva->saldo_prod}}</td>
                 <td class="bg-success"></td>
                 <td class="bg-success"></td>
                 <td class="bg-success"></td>
                 <td class="bg-success"></td>
                </tr>
            @endif 
          @endforeach  
          <tr>
            <td class="bg-success" style="color: white">#</td>
            <td class="bg-success" style="color: white">Promedio total: {{$totalprod}}</td>
            <td class="bg-success"></td>
            <td class="bg-success"></td>
            <td class="bg-success"></td>
            <td class="bg-success"></td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>     
</div>



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