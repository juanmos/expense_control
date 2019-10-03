<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!--[if lt IE 11]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Free Datta Able Admin Template come up with latest Bootstrap 4 framework with basic components, form elements and lots of pre-made layout options" />
    <meta name="keywords" content="admin templates, bootstrap admin templates, bootstrap 4, dashboard, dashboard templets, sass admin templets, html admin templates, responsive, bootstrap admin templates free download,premium bootstrap admin templates, datta able, datta able bootstrap admin template, free admin theme, free dashboard template"/>
    <meta name="author" content="CodedThemes"/>

    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="{{asset('assets/fonts/fontawesome/css/fontawesome-all.min.css')}}">
    <!-- material icon -->
    <link rel="stylesheet" href="{{asset('assets/fonts/material/css/materialdesignicons.min.css')}}">
    <!-- animation css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/animation/css/animate.min.css')}}">
    <!-- vendor css -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" />
    @stack('styles')
</head>
<body>
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <div id="app">
            <!-- [ navigation menu ] start -->
            @include('layouts/side')
            <!-- [ navigation menu ] end -->
        
            <!-- [ Header ] start -->
            <header class="navbar pcoded-header navbar-expand-lg navbar-light">
                <div class="m-header">
                    <a class="mobile-menu" id="mobile-collapse1" href="javascript:"><span></span></a>
                    <a href="index.html" class="b-brand">
                           <div class="b-bg">
                               <i class="feather icon-trending-up"></i>
                           </div>
                           <span class="b-title">Control Electoral</span>
                       </a>
                </div>
                {{-- <a class="mobile-menu" id="mobile-header" href="javascript:">
                    <i class="feather icon-more-horizontal"></i>
                </a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav mr-auto">
                        <li><a href="javascript:" class="full-screen" onclick="javascript:toggleFullScreen()"><i class="feather icon-maximize"></i></a></li>
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" href="javascript:" data-toggle="dropdown">Dropdown</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:">Action</a></li>
                                <li><a class="dropdown-item" href="javascript:">Another action</a></li>
                                <li><a class="dropdown-item" href="javascript:">Something else here</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <div class="main-search">
                                <div class="input-group">
                                    <input type="text" id="m-search" class="form-control" placeholder="Search . . .">
                                    <a href="javascript:" class="input-group-append search-close">
                                        <i class="feather icon-x input-group-text"></i>
                                    </a>
                                    <span class="input-group-append search-btn btn btn-primary">
                                        <i class="feather icon-search input-group-text"></i>
                                    </span>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <li>
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="javascript:" data-toggle="dropdown"><i class="icon feather icon-bell"></i></a>
                                <div class="dropdown-menu dropdown-menu-right notification">
                                    <div class="noti-head">
                                        <h6 class="d-inline-block m-b-0">Notifications</h6>
                                        <div class="float-right">
                                            <a href="javascript:" class="m-r-10">mark as read</a>
                                            <a href="javascript:">clear all</a>
                                        </div>
                                    </div>
                                    <ul class="noti-body">
                                        <li class="n-title">
                                            <p class="m-b-0">NEW</p>
                                        </li>
                                        <li class="notification">
                                            <div class="media">
                                                <img class="img-radius" src="assets/images/user/avatar-1.jpg" alt="Generic placeholder image">
                                                <div class="media-body">
                                                    <p><strong>John Doe</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>30 min</span></p>
                                                    <p>New ticket Added</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="n-title">
                                            <p class="m-b-0">EARLIER</p>
                                        </li>
                                        <li class="notification">
                                            <div class="media">
                                                <img class="img-radius" src="assets/images/user/avatar-2.jpg" alt="Generic placeholder image">
                                                <div class="media-body">
                                                    <p><strong>Joseph William</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>30 min</span></p>
                                                    <p>Prchace New Theme and make payment</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="notification">
                                            <div class="media">
                                                <img class="img-radius" src="assets/images/user/avatar-3.jpg" alt="Generic placeholder image">
                                                <div class="media-body">
                                                    <p><strong>Sara Soudein</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>30 min</span></p>
                                                    <p>currently login</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="noti-footer">
                                        <a href="javascript:">show all</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown drp-user">
                                <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon feather icon-settings"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-notification">
                                    <div class="pro-head">
                                        <img src="assets/images/user/avatar-1.jpg" class="img-radius" alt="User-Profile-Image">
                                        <span>John Doe</span>
                                        <a href="auth-signin.html" class="dud-logout" title="Logout">
                                            <i class="feather icon-log-out"></i>
                                        </a>
                                    </div>
                                    <ul class="pro-body">
                                        <li><a href="javascript:" class="dropdown-item"><i class="feather icon-settings"></i> Settings</a></li>
                                        <li><a href="javascript:" class="dropdown-item"><i class="feather icon-user"></i> Profile</a></li>
                                        <li><a href="message.html" class="dropdown-item"><i class="feather icon-mail"></i> My Messages</a></li>
                                        <li><a href="auth-signin.html" class="dropdown-item"><i class="feather icon-lock"></i> Lock Screen</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div> --}}
            </header>
            <!-- [ Header ] end -->
        
            <!-- [ Mensaje Content ] start -->
            
            <!-- [ Main Content ] start -->
            @yield('content')
            <!-- [ Main Content ] end -->
            {{-- @include('includes.check_primer_login') --}}
            <!-- Warning Section Starts -->
            <!-- Older IE warning message -->
            <!--[if lt IE 11]>
                <div class="ie-warning">
                    <h1>Warning!!</h1>
                    <p>You are using an outdated version of Internet Explorer, please upgrade
                       <br/>to any of the following web browsers to access this website.
                    </p>
                    <div class="iew-container">
                        <ul class="iew-download">
                            <li>
                                <a href="http://www.google.com/chrome/">
                                    <img src="assets/images/browser/chrome.png" alt="Chrome">
                                    <div>Chrome</div>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.mozilla.org/en-US/firefox/new/">
                                    <img src="assets/images/browser/firefox.png" alt="Firefox">
                                    <div>Firefox</div>
                                </a>
                            </li>
                            <li>
                                <a href="http://www.opera.com">
                                    <img src="assets/images/browser/opera.png" alt="Opera">
                                    <div>Opera</div>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.apple.com/safari/">
                                    <img src="assets/images/browser/safari.png" alt="Safari">
                                    <div>Safari</div>
                                </a>
                            </li>
                            <li>
                                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                                    <img src="assets/images/browser/ie.png" alt="">
                                    <div>IE (11 & above)</div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <p>Sorry for the inconvenience!</p>
                </div>
            <![endif]-->
            <!-- Warning Section Ends -->
        {{-- <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
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

        <main class="py-4">
            @yield('content')
        </main> --}}
    </div>
    <script src="{{asset('assets/js/vendor-all.min.js')}}"></script>
	<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/pcoded.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/es.js"></script>
    <script src="{{asset('assets/plugins/notify/bootstrap-notify.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <script>
        $(document).ready(function(){
            $('.datetime').datetimepicker({
                format: 'YYYY/MM/DD HH:mm:ss',
                inline: true,
                sideBySide: true,
                locale: 'es',
                icons: {
                    time: "far fa-clock",
                    date: "far fa-calendar-alt",
                    up: "fas fa-chevron-up",
                    down: "fas fa-chevron-down"
                }
            });
        })
    </script>
    @stack('scripts')
</body>
</html>
