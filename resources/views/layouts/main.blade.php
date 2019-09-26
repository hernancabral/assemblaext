<!-- layout.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <style type="text/css">
    body { color: #636B6F !important; }
    </style>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>

</head>
<body>
	<div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <!-- {{ config('app.name', 'Laravel') }} -->
                    Home
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                        <li class="nav-item nav-link" >|</li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('ticket.index') }}">Tickets</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tag.index') }}">Tags</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('brand.index') }}">Brands</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('milestone.index') }}">Milestones</a>
                        </li>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('planning.index') }}">Plannings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('team.index') }}">Teams</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('people.index') }}">People</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('prioritized.index') }}">Prioritized</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cloneticket.index') }}">Clonar</a>
                        </li>
                        <li class="nav-item nav-link" >|</li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('migratetojira.index') }}">Migrar a Jira</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item">
                                <a class="nav-link" href="{{ route('users.index') }}">Usuarios</a>
                        </li>
                        
                        <li class="nav-item nav-link" >|</li>

                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>                      
                                </div>
                            </li>  
                                                   
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="p-3 container">
            @yield('content')
        </main>
    </div>

    <script>
    $('button#deleteButton').on('click', function(e){
    e.preventDefault();
    var name = $(this).attr("data-name");
    var type = $(this).attr("data-type");
    swal.fire({
        title: "Espera!",
        text: "Seguro que queres borrar "+type+ " "+name+"?",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Borrar!',
        cancelButtonText: 'Mejor no'
    })
    .then ((willDelete) => {
        console.log(willDelete);
        console.log(willDelete.value);
        if (willDelete.value) {
        $(this).closest("form").submit();
        }
    });
    });
    </script>
</body>
</html>