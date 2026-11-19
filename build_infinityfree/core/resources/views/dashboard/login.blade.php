<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SEKALORI | Admin Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <link rel="shortcut icon" href="{{ asset('assets/pictures/logo-sekalori.jpg') }}">
    
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/dist/css/AdminLTE.min.css') }}">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <style>
        body.login-page {
            background: linear-gradient(135deg, #eaf5ee 0%, #f8fafc 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-box {
            margin: 0 auto;
            width: 380px;
        }
        .login-box-body {
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.07);
            border: 1px solid #e2e8f0;
            padding: 28px;
            background: #ffffff;
        }
        .btn-sekalori-login {
            background-color: #22714e !important;
            border-color: #1b5b3f !important;
            color: #ffffff !important;
            font-weight: 700;
            border-radius: 6px;
            padding: 10px;
            transition: all 0.2s ease;
        }
        .btn-sekalori-login:hover {
            background-color: #185538 !important;
            border-color: #13452d !important;
            box-shadow: 0 4px 10px rgba(34,113,78,0.3);
        }
        .form-control {
            border-radius: 6px;
            height: 40px;
        }
        .form-control:focus {
            border-color: #22714e;
            box-shadow: 0 0 6px rgba(34,113,78,0.25);
        }
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo" style="margin-bottom: 20px;">
            <a href="{{ url('/') }}" style="color: #22714e; font-weight: 800;">
                <img src="{{ asset('assets/pictures/logo-sekalori.jpg') }}" alt="SEKALORI" style="height: 42px; border-radius: 6px; margin-bottom: 6px; display: inline-block;">
                <br><b>SEKALORI</b> <span style="font-size: 18px; font-weight: 400; color: #64748b;">Admin</span>
            </a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg" style="color: #64748b; font-weight: 600; padding: 0 0 15px 0;">
                Masuk ke Panel Kelola Katering
            </p>
            <form action="{{ route('postLogin') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
                    <input type="email" name="email" class="form-control" placeholder="Email Admin" value="{{ old('email') }}" required autofocus>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-sekalori-login btn-block btn-flat">
                            <i class="fa fa-sign-in" style="margin-right: 6px;"></i> Masuk ke Dashboard
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- jQuery 3 -->
    <script src="{{ asset('assets/dashboard/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('assets/dashboard/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
</body>
</html>
