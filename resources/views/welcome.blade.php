<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Manager SiForme</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #505050;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
{{--    <body style="background-image: url('{{asset('img/bg_manager.jpg')}}')">--}}
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}" style="color: white">Home</a>
                    @else
                        <a href="{{ route('login') }}" style="color: white">Login</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="jumbotron" style="color: white">
                    <h1 class="display-4">Bem vindo!</h1>
                    <img src="{{ asset("img/nova_logo.jpg") }}" alt="">
                    <p class="lead">Estamos muito felizes de ter voce por aqui. Nesse sistema voce encontrará a maneira mais rápida, organizada e eficiente de administrar seus orçamentos.</p>
                </div>
            </div>
        </div>

    </body>
</html>
