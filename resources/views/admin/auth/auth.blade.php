<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <link rel="icon" href="{{ asset('assets/admiko/images/logo.png') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('assets/admiko/vendors/bootstrap/css/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito" rel="stylesheet">
    <title>Inicio de Sesión</title>
    <style>
        *:focus, *:active, *:focus-within {
            outline: unset !important;
            box-shadow: unset !important;
        }
        body {
            background-color: #edf2f7;
            font-size: 14px;
            font-family: Nunito, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            color: #1a202c;
        }
        label {
            color: #4a5568;
        }
        h3{
            color: grey;
            font-size: 24px;

        }
        .loginContent{
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, .1), 0 2px 4px -1px rgba(0, 0, 0, .06) !important;
            border-radius: 0.2rem;
        }
        .form-control {
            padding: .5rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            height: auto;
            border-color: #e2e8f0;
        }
        .form-control:focus {
            font-size: 16px;
            color: #4a5568;
            background-color: #fff;
            border-color: #cbd5e0;
        }
        .btn {
            padding: .5rem 1rem;
            border-width: 1px;
            border-color: transparent;
            font-size: .875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .1em;
            border-radius: .20rem;
            background-color: #3b7ddd;
            color: #fff;
        }
        .btn:hover {
            background-color: #2469ce;
        }
    </style>
</head>
<body>
<div class="d-flex flex-column min-vh-100 min-vw-100 align-items-center justify-content-center px-2 pb-5">
    <div class="w-100" style="max-width: 480px">
        <div class="loginContent bg-white overflow-hidden p-4">
            <div class="my-2 mb-3">
                <center><img class="mb-1" width="70px" src="{{ asset('assets/admiko/images/logo.png') }}"></center>
                <p class="h5 mt-1 fw-normal text-center" style="color: #4a5568; font-size: 18px">Derecho y Ciencias Políticas</p>
            </div>
            @yield('content')
        </div>
    </div>
</div>
<script src="{{ asset('assets/admiko/vendors/jquery/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('assets/admiko/vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
    $('.needs-validation').on('submit', function (event) {
        var form = $(this)[0];

        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
</script>
</body>
</html>
