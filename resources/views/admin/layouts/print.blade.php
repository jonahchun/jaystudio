<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ \Settings::getConfigValue('app/name') }}</title>
    <meta name="msapplication-TileColor" content="#f3e5da">
    <meta name="theme-color" content="#f3e5da">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- <link href="{{ asset('css/main.css') }}" rel="stylesheet"> -->
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
    <!-- <div class="empty-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-xl-6">
                    <div class="d-flex mb-4 justify-content-center">
                        <a class="logo" href="{{ route('dashboard') }}">
                            <img class="logo__img print" src="{{ \Settings::getConfigValueUrl('app/logo') ?: asset('images/logo-big.svg') }}" width="170" alt="JAY LIM STUDIO">
                        </a>
                    </div>    
                </div>
            </div>
            @include('admin.customer.print.newlyweds_info')
            @yield('content')
        </div>
    </div> -->
    <script type="text/javascript">
        window.print();
    </script>
    
</body>
</html>
