<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Theme CSS for profile pages -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/iconify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('assets/css/profile-custom.css') }}">
    </head>
    <body class="profile-page">
        <header class="profile-nav">
            <a class="profile-brand" href="{{ route('dashboard') }}">
                <span class="profile-brand-mark"><i class="icon-base bx bx-cube-alt"></i></span>
                <span>{{ config('app.name', 'StockFlow') }}</span>
            </a>

            <div class="profile-nav-actions">
                <a class="profile-dashboard-link" href="{{ route('dashboard') }}"><i class="icon-base bx bx-grid-alt"></i> Dashboard</a>
                <div class="profile-user-menu">
                    <span class="profile-nav-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    <span class="profile-nav-name">{{ Auth::user()->name }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="profile-logout" type="submit" title="Log out"><i class="icon-base bx bx-log-out"></i></button>
                </form>
            </div>
        </header>
        <main class="profile-main">{{ $slot }}</main>
    </body>
</html>
