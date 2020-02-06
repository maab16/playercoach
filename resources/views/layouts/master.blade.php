<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'>
    <link
        href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
        crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

    <!-- CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/theme/style.css') }}" rel="stylesheet">

   <!-- Styles -->
    @stack('styles')
    <!-- Global Spark Object -->
    <script>
        window.Spark = <?php echo json_encode(array_merge(Spark::scriptVariables(), [])); ?>;
    </script>
</head>
<body>
    <div id="spark-app" v-cloak style="width: 100%;">
        <div class="wrapper d-flex align-items-stretch">
            @include('layouts.sidebar')
            <!-- Main Content -->
            <main id="content" class="pl-4 pr-4">
                <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm mb-5">
                    <div class="container">

                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                                aria-controls="navbarSupportedContent" aria-expanded="false"
                                aria-label="{{ __('Toggle navigation') }}">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Right Side Of Navbar -->
                            <!-- Left Side Of Navbar -->
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
                                    <li>
                                        <div class="nav-item">
                                            <a id="home" class="nav-link" href="/home" role="button">Hjem</a>
                                        </div>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }} <span class="caret"></span>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                            <a href="/password/reset" class="dropdown-item">Reset password</a>
                                            <a class="dropdown-item" href="mailto:jk@billige-el-priser.dk?subject=side:{{ URL::current () }}">Teknisk support</a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                  style="display: none;">
                                                @csrf
                                            </form>
                                        </div>

                                    </li>

                                @endguest
                            </ul>


                        </div>
                    </div>
                </nav>
                @yield('content')
            </main>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('/js/sweetalert.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        (function($) {

            "use strict";

            var fullHeight = function() {

                $('.js-fullheight').css('height', $(window).height());
                $(window).resize(function(){
                    $('.js-fullheight').css('height', $(window).height());
                });

            };
            fullHeight();

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });

            $('a').each(function() {
                if ($(this).text().trim().length == 0) {
                    $(this).remove()
                }
            });

            // $('.select2-multiple').select2({
            //     width: '100%'
            // });

        })(jQuery);
    </script>
    <!-- Scripts -->
    @stack('scripts')
</body>
</html>
