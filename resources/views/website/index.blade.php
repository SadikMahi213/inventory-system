@extends('layouts.website')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl shadow-xl overflow-hidden">
        <div class="px-6 py-12 sm:px-12 sm:py-16 lg:px-16 lg:py-20">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl lg:text-5xl">
                        Complete Inventory Management Solution
                    </h1>
                    <p class="mt-6 text-xl text-indigo-100 max-w-2xl">
                        Streamline your business operations with our powerful ERP system that handles purchasing, sales, inventory tracking, and financial reporting.
                    </p>
                    <div class="mt-10 flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white shadow-sm hover:bg-indigo-50">
                                Go to Dashboard
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white shadow-sm hover:bg-indigo-50">
                                Get Started
                                <i class="fas fa-user-plus ml-2"></i>
                            </a>
                            <a href="{{ route('login') }}" class="flex items-center justify-center px-6 py-3 border border-white text-base font-medium rounded-md text-white bg-indigo-600 bg-opacity-0 hover:bg-opacity-10">
                                Sign In
                                <i class="fas fa-sign-in-alt ml-2"></i>
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="md:w-1/2 flex justify-center">
                    <div class="bg-white rounded-xl p-4 shadow-2xl transform rotate-3">
                        <div class="bg-gray-200 border-2 border-dashed rounded-xl w-64 h-64 md:w-80 md:h-80 flex items-center justify-center">
                            <i class="fas fa-boxes text-6xl text-indigo-500"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="mt-16">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Powerful Features
            </h2>
            <p class="mt-4 text-xl text-gray-500">
                Everything you need to manage your inventory and business operations
            </p>
        </div>

        <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Feature 1 -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="mt-5">
                    <h3 class="text-lg font-medium text-gray-900">Purchase Management</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Track all your purchases with detailed records, supplier information, and cost analysis.
                    </p>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="mt-5">
                    <h3 class="text-lg font-medium text-gray-900">Product Master</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Maintain comprehensive product information with unique codes, specifications, and pricing.
                    </p>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="mt-5">
                    <h3 class="text-lg font-medium text-gray-900">Analytics & Reports</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Gain insights with detailed analytics, profit/loss calculations, and customizable reports.
                    </p>
                </div>
            </div>

            <!-- Feature 4 -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-yellow-500 text-white">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="mt-5">
                    <h3 class="text-lg font-medium text-gray-900">Sales Tracking</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Monitor sales performance, customer information, and revenue generation in real-time.
                    </p>
                </div>
            </div>

            <!-- Feature 5 -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-red-500 text-white">
                    <i class="fas fa-warehouse"></i>
                </div>
                <div class="mt-5">
                    <h3 class="text-lg font-medium text-gray-900">Inventory Control</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Real-time inventory tracking with automatic stock updates and low stock alerts.
                    </p>
                </div>
            </div>

            <!-- Feature 6 -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-purple-500 text-white">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div class="mt-5">
                    <h3 class="text-lg font-medium text-gray-900">Financial Management</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Comprehensive accounting features including profit/loss calculations and expense tracking.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products Section -->
    @if($featuredProducts->count() > 0)
    <div class="mt-16">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Featured Products
            </h2>
            <p class="mt-4 text-xl text-gray-500">
                Check out our most popular items
            </p>
        </div>

        <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($featuredProducts as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="bg-gray-200 border-2 border-dashed rounded-t-lg w-full h-48 flex items-center justify-center">
                    <i class="fas fa-box-open text-4xl text-gray-400"></i>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">{{ $product->name }}</h3>
                    <p class="mt-2 text-sm text-gray-500">{{ $product->description ?? 'No description available' }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-lg font-bold text-indigo-600">${{ number_format($product->selling_price ?? 0, 2) }}</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $product->stock && $product->stock->current_stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->stock && $product->stock->current_stock > 0 ? $product->stock->current_stock . ' in stock' : 'Out of stock' }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Media Gallery Preview -->
    @if($mediaItems->count() > 0)
    <div class="mt-16">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Media Gallery
                </h2>
                <p class="mt-4 text-xl text-gray-500">
                    Our latest photos and videos
                </p>
            </div>
            <a href="{{ route('website.media') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                View All
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-6">
            @foreach($mediaItems as $media)
            <div class="aspect-w-1 aspect-h-1">
                @if(Str::startsWith($media->file_type, 'image'))
                    <div class="bg-gray-200 border-2 border-dashed rounded-lg w-full h-32 flex items-center justify-center">
                        <i class="fas fa-image text-2xl text-gray-400"></i>
                    </div>
                @elseif(Str::startsWith($media->file_type, 'video'))
                    <div class="bg-gray-200 border-2 border-dashed rounded-lg w-full h-32 flex items-center justify-center">
                        <i class="fas fa-video text-2xl text-gray-400"></i>
                    </div>
                @else
                    <div class="bg-gray-200 border-2 border-dashed rounded-lg w-full h-32 flex items-center justify-center">
                        <i class="fas fa-file text-2xl text-gray-400"></i>
                    </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- CTA Section -->
    <div class="mt-16 bg-indigo-50 rounded-2xl shadow-lg">
        <div class="px-6 py-12 sm:px-12 sm:py-16 lg:px-16 lg:py-20">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    <span class="block">Ready to streamline your business?</span>
                </h2>
                <p class="mt-4 text-xl text-gray-500">
                    Join thousands of businesses using our inventory management system
                </p>
                <div class="mt-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-700">
                            Go to Dashboard
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-700">
                            Get Started Today
                            <i class="fas fa-user-plus ml-2"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection