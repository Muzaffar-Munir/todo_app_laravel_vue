<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css">        
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('assets/css/sub-pages-responsive.css') }}" type="text/css">
        <link rel="icon" href="{{ asset('assets/images/fav-icon.png') }}" type="image/png" sizes="16x16">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('assets/flat-icons/my-icons-collection/font/flaticon.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('assets/font-awesome-4.7.0/css/font-awesome.min.css') }}" type="text/css">
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
        

        <title>UpsellUpscale</title>
                    <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body>
        <div id="app">
            <Index></Index>
        </div>
        {{-- <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}" type="application/javascript"></script> --}}
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.bundle.min.js"></script>
         <script src="{{ asset('assets/js/script.js') }}" type="application/javascript"></script>
         {{-- <script src="{{ asset('assets/js/bootstrap.min.js') }}" type="application/javascript"></script> --}}
        
    {{-- <script type="application/javascript" src="{{ asset('assets/js/popper.min.js') }}"></script>
     --}}
    </body>
</html>
