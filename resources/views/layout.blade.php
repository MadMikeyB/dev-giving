<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token()}}">

    <title>{{ config('app.name') }} @yield('title')</title>

    <!-- Fonts -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
    <main id="app">
        <h1>
            <i class="fas fa-donate fa-fw"></i>
            Dev Giving
        </h1>
        <header class="card">
            <nav>
                @auth
                    <a href="{{ route('project.create') }}" class="btn btn-green btn-add-project">
                        <i class="fa-fw fas fa-plus"></i>
                        <span>Add Project</span>
                    </a>

                    <div class="me">
                        <div class="avatar"><img src="{{ auth()->user()->avatar }}" alt=""></div>
                        <div class="name">{{ auth()->user()->name }}</div>
                    </div>
                @else
                    <a href="{{ route('github.create') }}" class="btn btn-blue">
                        <i class="fa-fw fab fa-github"></i>
                        <span>Signin with Github</span>
                    </a>
                @endauth
            </nav>
        </header>

        @yield('content')
    </main>
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
