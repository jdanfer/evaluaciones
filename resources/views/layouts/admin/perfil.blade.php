@extends('adminlte::page')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="row" style="padding-top: 20px">
        <!-- left column -->
        <div class="col-md-8">
            <!-- jquery validation -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Datos de Usuario: <small> {{ auth()->user()->username }}</small></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="editaUser" method="post" action="{{ route('profile.update') }}" autocomplete="off">
                    @csrf
                    @method('put')

                    <div class="card-body">
                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-name">{{ __('Nombre') }}</label>
                            <input type="text" name="name" id="input-name"
                                class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                placeholder="{{ __('Nombre') }}" value="{{ old('name', auth()->user()->name) }}" required
                                autofocus>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" style="width: 300px;" class="form-control" disabled id="documento"
                                name="documento" placeholder="Cédula indentidad..." required
                                value="{{ old('documento', auth()->user()->documento) }}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-id-card"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-email">{{ __('Correo electrónico') }}</label>
                            <input type="email" name="email" id="input-email"
                                class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                placeholder="{{ __('Correo electrónico') }}"
                                value="{{ old('email', auth()->user()->email) }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                </form>
                <hr class="my-4" />
                <form method="post" action="{{ route('profile.password') }}" autocomplete="off">
                    @csrf
                    @method('put')

                    <h6 class="heading-small text-muted mb-4">{{ __('Constraseña') }}</h6>

                    @if (session('password_status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('password_status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="pl-lg-4">
                        <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                            <label class="form-control-label"
                                for="input-current-password">{{ __('Contraseña actual') }}</label>
                            <input type="password" name="old_password" id="input-current-password"
                                class="form-control form-control-alternative{{ $errors->has('old_password') ? ' is-invalid' : '' }}"
                                placeholder="{{ __('Contraseña actual') }}" value="" required>

                            @if ($errors->has('old_password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('old_password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-password">{{ __('Nueva contraseña') }}</label>
                            <input type="password" name="password" id="input-password"
                                class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                placeholder="{{ __('Nueva contraseña') }}" value="" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="form-control-label"
                                for="input-password-confirmation">{{ __('Confirmar contraseña') }}</label>
                            <input type="password" name="password_confirmation" id="input-password-confirmation"
                                class="form-control form-control-alternative"
                                placeholder="{{ __('Confirmar contraseña') }}" value="" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success mt-4">{{ __('Cambiar Clave') }}</button>
                        </div>
                        <br>
                    </div>
                </form>

            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <!--/.col (right) -->
    </div>
    <!-- /.row -->
@endsection
