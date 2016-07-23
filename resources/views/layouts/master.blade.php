<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sentra Baja</title>
    <link rel="stylesheet" href="/css/bootstrap.css"/>
    <link rel="stylesheet" href="/css/jquery-ui.css"/>
    {{--<link rel="stylesheet" href="/css/jquery-ui.structure.min.css"/>--}}
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Sentra Baja</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                @if(Auth::user())
                    @if(Auth::user()->role == 'ADMIN')
                        @include('navigation.admin.menu')
                    @else
                        @include('navigation.branch.menu')
                    @endif
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="hidden-xs" >
                    <a href="">
                        Selamat Datang,
                        @if(Auth::user())
                            {{Auth::user()->name}}
                        @else
                            {{'Tamu'}}
                        @endif
                    </a>
                </li>
                @if (Auth::user())
                    <li><a href="{{url('/user/logout')}}">Logout</a></li>
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="container">
    @yield('content')
</div>
<script type="application/javascript" src="/js/jquery-2.2.3.min.js"></script>
<script type="application/javascript" src="/js/bootstrap.js"></script>

@yield('js')

</body>
</html>

