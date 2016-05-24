<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Damian Brończyk">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="description" content="@yield('description')">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet'
          type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700&subset=latin,latin-ext" rel='stylesheet'
          type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">

    @yield('css')

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                Hungry Fingers
                <small class="text-warning">beta</small>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/') }}">Home</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/steam') }}"><img src="{{ URL::asset('img/small.png') }}"></a></li>
                    <!-- <li><a href="{{ url('/register') }}">Register</a></li> -->
                @else
                    {{--<li><a href="{{ url('/sale') }}">Sprzedaj coś</a></li>--}}
                    {{--<li><a href="#">Moje oferty</a></li>--}}

                    {{--<li class="dropdown">--}}
                        {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">--}}
                            {{--<i class="fa fa-btn fa-users"></i>Użytkownicy <span class="caret"></span>--}}
                        {{--</a>--}}

                        {{--<ul class="dropdown-menu" role="menu">--}}
                            {{--<li><a href="{{URL::route('users')}}"><i class="fa fa-btn fa-list"></i>Lista</a></li>--}}
                            {{--<li><a href="#"class="save"><i--}}
                                            {{--class="fa fa-btn fa-plus"></i>Dodaj</a></li>--}}

                            {{--<li><a href="#" data-toggle="modal" data-target=".bs-example-modal-sm" class="save"><i--}}
                                            {{--class="fa fa-btn fa-plus"></i>Dodaj</a></li>--}}


                        {{--</ul>--}}
                    {{--</li>--}}



                    <li><a href="{{URL::route('users')}}"><i class="fa fa-btn fa-users"></i>Użytkownicy</a></li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="fa fa-btn fa-gamepad"></i>Gry <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{URL::route('games')}}"><i class="fa fa-btn fa-list"></i>Lista</a></li>
                            <li><a href="#" data-toggle="modal" data-target=".bs-example-modal-sm" class="save"><i
                                            class="fa fa-btn fa-plus"></i>Dodaj</a></li>

                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->username }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#"><i class="fa fa-btn fa-user"></i>Profil</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{URL::route('logout')}}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>

                    <li><img style="margin-top: 4px;" height="40" width="40" src="{{ Auth::user()->avatar }}"></li>

                @endif
            </ul>
        </div>
    </div>
</nav>

<div class="container">

    @if (session('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-success">
            {!! session('error') !!}
        </div>
    @endif


    @yield('content')
</div>


<footer class="footer">
    <div class="container">
        <p class="text-muted text-center">Hungry Fingers {{ date('Y') }}</p>
    </div>
</footer>

<!-- ------------------------------------------------------------------------------------------- -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            {!! Form::open(array('url' => 'add')) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Dodaj grę</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Nazwa gry</label>
                    {{--<input type="text" class="form-control" id="name" placeholder="Nazwa gry">--}}
                    {{ Form::text('name', null,array('id' => 'name', 'class' => 'form-control' ,'placeholder'=>'Nazwa gry')) }}
                </div>
                <div class="form-group">
                    <label for="appid">Steam ID</label>
                    {{--<input type="text" class="form-control" id="appid" placeholder="Steam ID">--}}
                    {{ Form::text('appid', null,array('id' => 'appid', 'class' => 'form-control' ,'placeholder'=>'Steam ID')) }}

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                <button type="submit" class="btn btn-primary save">Zapisz</button>
            </div>


            {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- ------------------------------------------------------------------------------------------- -->


<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="{{ URL::asset('js/scripts.js') }}"></script>


<script>
    $('.save').click(function () {
        var appid = $('#appid').val();
        var name = $('#name').val();
        console.log(name + ' ' + appid);
    });
</script>

@yield('script')

</body>
</html>
