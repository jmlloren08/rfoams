<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RFOAMIS | Registration Page</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('backend/assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ url('backend/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('backend/assets/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1">
                    <img src="{{ url('backend/assets/dist/img/header-arta.png') }}" alt="RFO Insight Logo" class="logo" style="width: 50%; height:50%;">
                    <b>RFO</b>Insight</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Register a new membership</p>

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control @if ($errors->has('name')) is-invalid @endif" id="name" name="name" placeholder="Full name" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control @if ($errors->has('email')) is-invalid @endif" id="email" name="email" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control @if ($errors->has('password')) is-invalid @endif" id="password" name="password" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control @if ($errors->has('password_confirmation')) is-invalid @endif" id="password_confirmation" name="password_confirmation" placeholder="Retype password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @if ($errors->has('password_confirmation'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password_confirmation') }}
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
                                <label for="agreeTerms">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <a href="{{ route('login') }}" class="text-center">I already have a membership</a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="{{ url('backend/assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('backend/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('backend/assets/dist/js/adminlte.min.js') }}"></script>
</body>

</html>