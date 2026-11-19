<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SEKA Warkop & Cafe | Admin Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <link rel="shortcut icon" href="{{ asset('assets/pictures/logo-seka.jpg') }}">
    
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
            background: linear-gradient(135deg, #f7f2ec 0%, #ede3d7 100%);
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
            box-shadow: 0 10px 25px rgba(90,53,27,0.08);
            border: 1px solid #dfcfbe;
            padding: 28px;
            background: #ffffff;
        }
        .btn-sekalori-login,
        .btn-seka-login {
            background-color: #5a351b !important;
            border-color: #432410 !important;
            color: #ffffff !important;
            font-weight: 700;
            border-radius: 6px;
            padding: 10px;
            transition: all 0.2s ease;
        }
        .btn-sekalori-login:hover,
        .btn-seka-login:hover {
            background-color: #432410 !important;
            border-color: #331908 !important;
            box-shadow: 0 4px 10px rgba(90,53,27,0.3);
        }
        .form-control {
            border-radius: 6px;
            height: 40px;
        }
        .form-control:focus {
            border-color: #5a351b;
            box-shadow: 0 0 6px rgba(90,53,27,0.25);
        }
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo" style="margin-bottom: 20px;">
            <a href="{{ url('/') }}" style="color: #5a351b; font-weight: 800; text-decoration: none;">
                <img src="{{ asset('assets/pictures/logo-seka.jpg') }}" alt="SEKA Warkop & Cafe" style="height: 54px; width: 54px; object-fit: cover; border-radius: 50%; margin-bottom: 8px; display: inline-block; box-shadow: 0 2px 8px rgba(90,53,27,0.2); border: 2px solid #dfcfbe;">
                <br><b>SEKA</b> <span style="font-size: 18px; font-weight: 400; color: #785e4f;">Warkop & Cafe</span>
            </a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg" style="color: #785e4f; font-weight: 600; padding: 0 0 15px 0;">
                Masuk ke Panel Admin Warkop & Cafe
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
