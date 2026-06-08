@php
use Illuminate\Support\Facades\Auth;

$user = Auth::guard('api')->user();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard Jobseeker</title>

    @vite([
        'resources/js/app.js',
        'resources/js/logout.js',
        'resources/css/dashboard.css'
    ])
    
    @stack('styles')
    
    {{-- FONT --}}
    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">

    {{-- ICON --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'
          rel='stylesheet'>

</head>

<body>

<div class="dashboard-wrapper">

    {{-- SIDEBAR --}}
    @include('components.sidebar')

    {{-- MAIN --}}
    <main class="main-content">

        {{-- NAVBAR --}}
        @include('components.navbar')

        @yield('content')

    </main>

</div>

@stack('scripts')

</body>
</html>