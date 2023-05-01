@extends('adminlte::page')

@section('title', 'Sistema de Evaluaciones')

@section('content_header')
    <!-- CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
     <h1 style="color:blue">Sistema de Evaluaciones: SAPP S.A.</h1>
@stop

@section('content')
<body class="hold-transition sidebar-mini">
        
            <!-- =========================================================== -->
            <h5 style="color:darkgreen" class="mb-2">Resumen del sector iniciado</h5>
            <div class="row">
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-none">
                  <span class="info-box-icon bg-info"><i class="far fa-user"></i></span>
    
                  <div class="info-box-content">
                    <span class="info-box-text">Personas</span>
                    <span class="info-box-number">{{ $personas->count()}}</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-sm">
                  <span class="info-box-icon bg-success"><i class="far fa-edit"></i></span>
    
                  <div class="info-box-content">
                    <span class="info-box-text">AutoEvaluaciones</span>
                    @if (isset($autoevaluaciones))
                        <span class="info-box-number">{{ $autoevaluaciones->count()}}</span>
                    @else
                        <span class="info-box-number">0</span>
                    @endif
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow">
                  <span class="info-box-icon bg-warning"><i class="far fa-edit"></i></span>
    
                  <div class="info-box-content">
                    <span class="info-box-text">Evaluaciones</span>
                    @if (isset($autoevaluaciones))
                       <span class="info-box-number">{{ $evaluaciones->count()}}</span>
                    @else 
                       <span class="info-box-number">0</span>
                    @endif 
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-lg">
                  <span class="info-box-icon bg-danger"><i class="far fa-thumbs-up"></i></span>    
                  <div class="info-box-content">
                    <span class="info-box-text">Finalizadas</span>
                    @if (isset($autoevaluaciones))
                        <span class="info-box-number">{{ $finalizadas->count()}}</span>
                    @else 
                        <span class="info-box-number">0</span>
                    @endif 
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
    
            <!-- =========================================================== -->
            <h5 class="mt-4 mb-2">Resumen TOTAL del sistema de Evaluación</h5>
            <div class="row">
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box bg-info">
                  <span class="info-box-icon"><i class="fas fa-users"></i></span>    
                  <div class="info-box-content">
                    <span class="info-box-text">Personas</span>
                    <span style="text-align: center" class="info-box-number">{{ $totalpersonas->count()}}</span>
    
                    <div class="progress">
                      <div class="progress-bar" style="width: 100%"></div>
                    </div>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box bg-success">
                  <span class="info-box-icon"><i class="far fa-edit"></i></span>
    
                  <div class="info-box-content">
                    <span class="info-box-text">Autoevaluaciones</span>
                    @if (isset($autoevaltotal))
                       <span style="text-align: center" class="info-box-number">{{ $autoevaltotal->count()}}</span>    
                    @else 
                       <span style="text-align: center" class="info-box-number">0</span>                        
                    @endif 
                      <div class="progress">
                      <div  class="progress-bar" style="width: 100%"></div>
                    </div>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box bg-warning">
                  <span class="info-box-icon"><i class="far fa-edit"></i></span>
    
                  <div class="info-box-content">
                    <span class="info-box-text">Evaluaciones</span>
                    @if (isset($evaluacionestot))
                        <span style="text-align: center" class="info-box-number">{{ $evaluacionestot->count()}}</span>
                    @else 
                        <span style="text-align: center" class="info-box-number">0</span>                
                    @endif 
                    <div class="progress">
                      <div class="progress-bar" style="width: 100%"></div>
                    </div>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box bg-danger">
                  <span class="info-box-icon"><i class="fas fa-thumbs-up"></i></span>
    
                  <div class="info-box-content">
                    <span class="info-box-text">Finalizadas</span>
                    @if (isset($finalizadastot))
                        <span style="text-align: center" class="info-box-number">{{ $finalizadastot->count()}}</span>
                    @else 
                        <span style="text-align: center" class="info-box-number">0</span>
                    @endif 
                    <div class="progress">
                      <div class="progress-bar" style="width: 100%"></div>
                    </div>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- PIE CHART -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Cómo realizar la Evaluación</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                  <div data-interval="9000" class="carousel-item active">
                    <img src="vendor/adminlte/dist/img/foto1ok.png" class="d-block w-100" alt="...">
                  </div>
                  <div data-interval="9000" class="carousel-item">
                    <img src="vendor/adminlte/dist/img/foto2ok.png" class="d-block w-100" alt="...">
                  </div>
                  <div data-interval="9000" class="carousel-item">
                    <img src="vendor/adminlte/dist/img/foto3ok.png" class="d-block w-100" alt="...">
                  </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Anterior</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Siguiente</span>
                </a>
              </div>
              <div class="card-body">
                <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>    
    
    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
  <!-- ChartJS -->
  <script src="../../dist/js/Chart.min.js"></script>

    <script>
      $(function () {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */
    
        //--------------
        //- AREA CHART -
        //--------------
    
        // Get context with jQuery - using jQuery's .get() method.
        var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    
        var areaChartData = {
          labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
          datasets: [
            {
              label               : 'Digital Goods',
              backgroundColor     : 'rgba(60,141,188,0.9)',
              borderColor         : 'rgba(60,141,188,0.8)',
              pointRadius          : false,
              pointColor          : '#3b8bba',
              pointStrokeColor    : 'rgba(60,141,188,1)',
              pointHighlightFill  : '#fff',
              pointHighlightStroke: 'rgba(60,141,188,1)',
              data                : [28, 48, 40, 19, 86, 27, 90]
            },
            {
              label               : 'Electronics',
              backgroundColor     : 'rgba(210, 214, 222, 1)',
              borderColor         : 'rgba(210, 214, 222, 1)',
              pointRadius         : false,
              pointColor          : 'rgba(210, 214, 222, 1)',
              pointStrokeColor    : '#c1c7d1',
              pointHighlightFill  : '#fff',
              pointHighlightStroke: 'rgba(220,220,220,1)',
              data                : [65, 59, 80, 81, 56, 55, 40]
            },
          ]
        }
    
        var areaChartOptions = {
          maintainAspectRatio : false,
          responsive : true,
          legend: {
            display: false
          },
          scales: {
            xAxes: [{
              gridLines : {
                display : false,
              }
            }],
            yAxes: [{
              gridLines : {
                display : false,
              }
            }]
          }
        }
    
        // This will get the first returned node in the jQuery collection.
        new Chart(areaChartCanvas, {
          type: 'line',
          data: areaChartData,
          options: areaChartOptions
        })
    
        //-------------
        //- LINE CHART -
        //--------------
        var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
        var lineChartOptions = $.extend(true, {}, areaChartOptions)
        var lineChartData = $.extend(true, {}, areaChartData)
        lineChartData.datasets[0].fill = false;
        lineChartData.datasets[1].fill = false;
        lineChartOptions.datasetFill = false
    
        var lineChart = new Chart(lineChartCanvas, {
          type: 'line',
          data: lineChartData,
          options: lineChartOptions
        })
    
        //-------------
        //- DONUT CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
        var donutData        = {
          labels: [
              'Administ.',
              'Enfermería',
              'Médicos',
              'Chóferes',
              'Farmacia',
          ],
          datasets: [
            {
              data: [700,500,400,600,300],
              backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc'],
            }
          ]
        }
        var donutOptions     = {
          maintainAspectRatio : false,
          responsive : true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        new Chart(donutChartCanvas, {
          type: 'doughnut',
          data: donutData,
          options: donutOptions
        })
    
        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
        var pieData        = donutData;
        var pieOptions     = {
          maintainAspectRatio : false,
          responsive : true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        new Chart(pieChartCanvas, {
          type: 'pie',
          data: pieData,
          options: pieOptions
        })
    
        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        var temp1 = areaChartData.datasets[1]
        barChartData.datasets[0] = temp1
        barChartData.datasets[1] = temp0
    
        var barChartOptions = {
          responsive              : true,
          maintainAspectRatio     : false,
          datasetFill             : false
        }
    
        new Chart(barChartCanvas, {
          type: 'bar',
          data: barChartData,
          options: barChartOptions
        })
    
        //---------------------
        //- STACKED BAR CHART -
        //---------------------
        var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
        var stackedBarChartData = $.extend(true, {}, barChartData)
    
        var stackedBarChartOptions = {
          responsive              : true,
          maintainAspectRatio     : false,
          scales: {
            xAxes: [{
              stacked: true,
            }],
            yAxes: [{
              stacked: true
            }]
          }
        }
    
        new Chart(stackedBarChartCanvas, {
          type: 'bar',
          data: stackedBarChartData,
          options: stackedBarChartOptions
        })
      })
    </script>
    
  </body>
    

@stop

