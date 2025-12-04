<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel ERP'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Chart.js for dashboard charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            <div class="flex">
                <!-- Sidebar -->
                <div class="w-64 min-h-screen bg-gray-800 text-white">
                    <div class="p-4">
                        <h2 class="text-xl font-bold">ERP System</h2>
                    </div>
                    <nav class="mt-5">
                        <a href="{{ route('dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                        </a>
                        <a href="{{ route('products.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('products.*') ? 'bg-gray-700' : '' }}">
                            <i class="fas fa-box mr-2"></i> Products
                        </a>
                        <a href="{{ route('purchase-records.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('purchase-records.*') ? 'bg-gray-700' : '' }}">
                            <i class="fas fa-shopping-cart mr-2"></i> Purchase Records
                        </a>
                        <a href="{{ route('sales-records.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('sales-records.*') ? 'bg-gray-700' : '' }}">
                            <i class="fas fa-dollar-sign mr-2"></i> Sales Records
                        </a>
                        <a href="{{ route('stocks.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('stocks.*') ? 'bg-gray-700' : '' }}">
                            <i class="fas fa-warehouse mr-2"></i> Stock Management
                        </a>
                        <a href="{{ route('profit-loss.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('profit-loss.*') ? 'bg-gray-700' : '' }}">
                            <i class="fas fa-chart-line mr-2"></i> Profit & Loss
                        </a>
                        <a href="{{ route('suppliers.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('suppliers.*') ? 'bg-gray-700' : '' }}">
                            <i class="fas fa-truck mr-2"></i> Suppliers
                        </a>
                        <a href="{{ route('customers.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('customers.*') ? 'bg-gray-700' : '' }}">
                            <i class="fas fa-users mr-2"></i> Customers
                        </a>
                        <a href="{{ route('cost-analysis.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('cost-analysis.*') ? 'bg-gray-700' : '' }}">
                            <i class="fas fa-calculator mr-2"></i> Cost Analysis
                        </a>
                        <a href="{{ route('media.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('media.*') ? 'bg-gray-700' : '' }}">
                            <i class="fas fa-images mr-2"></i> Media
                        </a>
                    </nav>
                </div>

                <!-- Main Content -->
                <div class="flex-1 p-6">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    @yield('scripts')
</body>
</html>