<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{route('top')}}">Laravelホテル</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item {{ Request::routeIs('plan.*') ? 'active' : '' }}">
                    <a class="nav-link" href="#">宿泊プラン</a>
                </li>
                <li class="nav-item {{ Request::routeIs('rooms') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('rooms')}}">客室一覧</a>
                </li>
                <li class="nav-item {{ Request::routeIs('access') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('access')}}">アクセス</a>
                </li>
                <li class="nav-item {{ Request::routeIs('inquiry.*') ? 'active' : '' }}">
                    <a class="nav-link" href="#">お問合せ</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
