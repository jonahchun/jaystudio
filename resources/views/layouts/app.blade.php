<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ \Settings::getConfigValue('app/name') }}</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon//apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('favicon/safari-pinned-tab.svg') }}" color="#f3e5da">
    <meta name="msapplication-TileColor" content="#f3e5da">
    <meta name="theme-color" content="#f3e5da">
    <link href="{{ mix('css/main.css') }}" rel="stylesheet">
</head>
<body>
    <div style="position: absolute; height: 0; overflow: hidden;" class="icons-sprite">
    @include('page.icons')
    </div>
    <div class="wrapper" id="app">
        @include('page.aside')

        <main class="main">
            @include('page.header')
            @include('page.components.alert')

            <div class="dashboard">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>
