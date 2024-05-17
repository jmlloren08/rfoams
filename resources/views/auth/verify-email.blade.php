<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RFOAMIS | Login Page</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('backend/assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ url('backend/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('backend/assets/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1">
                    <img src="{{ url('backend/assets/dist/img/header-arta.png') }}" alt="RFO Insight Logo" class="logo" style="width: 50%; height:50%;">
                    <!-- <b>RFO</b>Insight -->
                </a>
            </div>
            <div class="card-body">
                <div class="mb-4 text-sm text-gray-600">
                    <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>
                </div>
                @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    <p>A new verification link has been sent to the email address you provided during registration.</p>
                </div>
                @endif
                <div class="row flex align-items-center">
                    <div class="col-8 flex items-center justify-start">
                        <!-- resend -->
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <div>
                                <button type="submit" class="btn btn-primary btn-block">Resend Verification Email</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-4 flex items-center justify-end"><!-- logout -->
                        <a href="{{ route('admin.logout') }}">Logout</a>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ url('backend/assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('backend/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('backend/assets/dist/js/adminlte.min.js') }}"></script>
</body>

</html>