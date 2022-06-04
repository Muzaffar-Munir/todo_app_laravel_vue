<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'UpsellUpscale') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">        
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sub-pages-responsive.css') }}">
    <link rel="icon" href="{{ asset('assets/images/fav-icon.png') }}" type="image/png" sizes="16x16">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/flat-icons/my-icons-collection/font/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="_token" content="{!! csrf_token() !!}" />
</head>
<body>
    <div id="app">
         <!-- nav -->
    <div class="container responsive-container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a href="/" class="navbar-brand nav-image">
            <img src="/assets/images/logo-nav.png" />
          </a>
          <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarText"
            aria-controls="navbarText"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse nav-padding" id="navbarText">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a href="/home/list-freelancers" class="nav-link">Freelancing</a>
              </li>
              <li class="nav-item">
                <a href="/home/list-clients" class="nav-link">Companies</a>
              </li>
              <li class="nav-item">
                <a href="/home/services" class="nav-link">Services</a>
              </li>
              <li class="nav-item">
                <a href="/home/list-freelancers" class="nav-link">Contact</a>
              </li>
            </ul>
          </div>
        </nav>
      </div>

        <main class="py-4">
            @yield('content')
        </main>
              <!-- footer -->
              <footer>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <h3>ABOUT</h3>
                            <img src="/assets/images/logo-footer.1.png" alt="logo">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean
                                euismod bibendum laoreet. Proin gravida dolor sit amet lacus
                                accumsan et viverra justo commodo.</p>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <h3>LEGAL</h3>
                            <ul>
                                <li>Privacy Policy</li>
                                <li>Terms Of Use</li>
                                <li>Faq's</li>
                            </ul>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <h3>SOCIAL MEDIA</h3>
                            <ul>
                                <li>Facebook</li>
                                <li>Instagram</li>
                                <li>Twitter</li>
                                <li>LinkedIn</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
            <div class="copyright">
                <div class="container">
                    <div class="row copyright-content">
                        <p class="copyright-content-p">All rights reserved @ UpsellUpscale.com  2020</p>
                        <p>Design & Developed by WebOnClicks 
                        </p>
                    </div>
                </div>
            </div>
      
       
        <script type="application/javascript" src="{{ asset('assets/js/jquery-3.3.1.min.js')}}"></script>
        <script type="application/javascript" src="{{ asset('assets/js/script.js')}}"></script>
        <script type="application/javascript" src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
        <script type="application/javascript" src="{{ asset('assets/js/popper.min.js')}}"></script>
    </div>
</body>
</html>
