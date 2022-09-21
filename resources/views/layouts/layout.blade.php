<html lang='pt-br'>
<head>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title>Sistema monday @yield('title')</title>
    <link href="{{ asset('/images/brand/favicon.png') }}" rel="icon" type="image/png"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/styledHome.js') }}" defer></script>

     <!-- Styles -->
     <link rel='stylesheet' href="{{ url('/css/app.css') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">

    <link href="{{ asset('css/styledHome.css') }}" rel="stylesheet">
    
    <style>
        .wrapper #wrapperContent, .wrapper #wrapperContent.closed {
            padding: 0;
        }
    </style>
</head>
<body id="body-pd">
    <div id="appDashboard">
        <header class="header" id="header">
            <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
            <a href="{{ route('home')}}" class="text-decoration-none text-dark">
                <div class=""> Gabriel <i class='bx bx-user nav_icon'></i> </div>
            </a>
        </header>
        <div class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div> 
                    <a href="" class="nav_logo"><i class='bx bx-layer nav_logo-icon'></i>
                        <span class="nav_logo-name">Sistema Monday</span>
                    </a>
                    <div class="nav_list">
                         <a href="" class="nav_link"> <i class='bx bx-user nav_icon'></i>
                            <span class="nav_name">Usuários</span>
                        </a> 
                        <a href="" class="nav_link"> <i class='bx bx-message-square-detail nav_icon'></i>
                            <span class="nav_name">Funções</span>
                        </a>
                        <a href="" class="nav_link"><i class='bx bx-cog nav_icon'></i>
                            <span class="nav_name">Configurações</span>
                        </a>
                    </div>
                </div>
                <a href="{{ route('logout') }}" class="nav_link"  onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"> <i class='bx bx-log-out nav_icon'></i>
                        <span class="nav_name">Sair</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </nav>
        </div>
        <main class="main">
            @yield('content')
        </main>
    </div>
    
    <script src="{{ url('/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d712964458.js" crossorigin="anonymous"></script>

    @yield('script')
    
</body>
</html>