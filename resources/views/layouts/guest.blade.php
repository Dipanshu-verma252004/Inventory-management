<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Theme CSS for authentication pages -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/iconify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('assets/css/auth-custom.css') }}">
    </head>
    <body class="auth-page">
        <main class="auth-shell">
            <section class="auth-hero" aria-label="Inventory management introduction">
                <a class="auth-brand" href="{{ route('home') }}">
                    <span class="auth-brand-mark"><i class="icon-base bx bx-cube-alt"></i></span>
                    <span>{{ config('app.name', 'StockFlow') }}</span>
                </a>

                <div class="auth-hero-content">
                    <span class="auth-eyebrow">INVENTORY MANAGEMENT</span>
                    <h1>Keep your stock<br>moving forward.</h1>
                    <p>Manage products, suppliers and sales from one simple workspace.</p>
                </div>

                <div class="auth-stat">
                    <span class="auth-stat-dot"></span>
                    <span>Simple, secure and built for your business</span>
                </div>
            </section>

            <section class="auth-content">
                <div class="auth-card">
                    {{ $slot }}
                </div>
                <p class="auth-footer">&copy; {{ now()->year }} {{ config('app.name', 'StockFlow') }}. All rights reserved.</p>
            </section>
        </main>
    </body>
</html>
