<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">Laravel 5</div>
    </div>
    @if (Auth::check())
        <p><img src="{{Auth::user()->avatar}}"></p>
        <p>{{Auth::user()->username}}</p>
        <p>{{Auth::user()->steamid}}</p>
        <p><a href="logout">Logout!</a></p>
    @else
        <p><a href="steam">Log in by steam</a></p>
    @endif
</div>
</body>
</html>
