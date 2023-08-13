<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>Billetera digital plus</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-1.13.5/b-2.4.1/fc-4.3.0/fh-3.4.0/r-2.5.0/sc-2.2.0/sp-2.2.0/datatables.min.css" rel="stylesheet">

    </head>
    <body class="bg-main">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <div id="app">
                    @yield('content')
                </div>
            </div>
        </div>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-1.13.5/b-2.4.1/fc-4.3.0/fh-3.4.0/r-2.5.0/sc-2.2.0/sp-2.2.0/datatables.min.js"></script>
    </body>
</html>
<style>
.bg-main{
    background-image: url('/assets/img/brand/background.svg');
    background-size: cover;
    background-position: center;
}
</style>