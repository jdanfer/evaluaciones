@extends('adminlte::page')

@section('title', 'Sistema de Evaluaciones')
@section('content_header')
    <!-- CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

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
                        <span class="info-box-number">{{ $personas->count() }}</span>
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
                            <span class="info-box-number">{{ $autoevaluaciones->count() }}</span>
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
                            <span class="info-box-number">{{ $evaluaciones->count() }}</span>
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
                            <span class="info-box-number">{{ $finalizadas->count() }}</span>
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
                        <span style="text-align: center" class="info-box-number">{{ $totalpersonas->count() }}</span>

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
                            <span style="text-align: center" class="info-box-number">{{ $autoevaltotal->count() }}</span>
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
                <div class="info-box bg-warning">
                    <span class="info-box-icon"><i class="far fa-edit"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Evaluaciones</span>
                        @if (isset($evaluacionestot))
                            <span style="text-align: center" class="info-box-number">{{ $evaluacionestot->count() }}</span>
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
                            <span style="text-align: center" class="info-box-number">{{ $finalizadastot->count() }}</span>
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
                <canvas id="pieChart"
                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
        </div>
        @include('sweetalert::alert')
        @stack('modals')
        @livewireScripts
    </body>


@stop
