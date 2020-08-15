<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>GoodBot</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
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

            a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            
            button {
                padding: 10px 30px;
                background: #CCC;
                border: solid 1px #333;
                cursor: pointer;
                border-radius: 5px;
            }
            th, td {
                text-align: left;
                padding: 5px 10px;
                border-bottom: dotted 1px #CCC;
            }
            td a {
                padding: 0;
            }
            .justify-content-left {
                text-align: left;
            }

            .justify-content-center {
                text-align: center;
            }

            table {
                width: 100%;
                border-left: dotted 1px #CCC;
                border-right: dotted 1px #CCC;
            }
            .reserve-select {
                display: none;
            }
            a i {
                cursor: pointer;
            }
        </style>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">


            <div class="content">
                <div class="title m-b-md">
                    GoodBot
                </div>
                @if (session()->get('user'))
                    Welcome <strong>{{ session()->get('user')->username }}<strong> <a href="/characters">My Characters &rarr;</a> <a href="/logout">log out &rarr;</a>
                @endif
                <div class="main">
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>
