@extends('layouts.erp')

@section('title', 'Product Details')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Product Details</h1>
        <div class="flex space-x-2">
            <a href="{{ route('products.edit', $product) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-2"></i> Back to Products
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">{{ $product->product_name }}</h2>
            <p class="text-gray-600">Product Code: {{ $product->product_code }}</p>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3 pb-2 border-b border-gray-200">Basic Information</h3>
                    <dl class="grid grid-cols-1 gap-2">
                        <div class="flex">
                            <dt class="w-1/3 text-sm font-medium text-gray-500">Product Name</dt>
                            <dd class="w-2/3 text-sm text-gray-900">{{ $product->product_name }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-1/3 text-sm font-medium text-gray-500">Product Code</dt>
                            <dd class="w-2/3 text-sm text-gray-900">{{ $product->product_code }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-1/3 text-sm font-medium text-gray-500">Brand</dt>
                            <dd class="w-2/3 text-sm text-gray-900">{{ $product->brand ?? '-' }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-1/3 text-sm font-medium text-gray-500">Model No</dt>
                            <dd class="w-2/3 text-sm text-gray-900">{{ $product->model_no ?? '-' }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-1/3 text-sm font-medium text-gray-500">Size</dt>
                            <dd class="w-2/3 text-sm text-gray-900">{{ $product->size ?? '-' }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-1/3 text-sm font-medium text-gray-500">Color</dt>
                            <dd class="w-2/3 text-sm text-gray-900">{{ $product->color ?? '-' }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-1/3 text-sm font-medium text-gray-500">Grade</dt>
                            <dd class="w-2/3 text-sm text-gray-900">{{ $product->grade ?? '-' }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-1/3 text-sm font-medium text-gray-500">Material</dt>
                            <dd class="w-2/3 text-sm text-gray-900">{{ $product->material ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Pricing & Stock Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3 pb-2 border-b border-gray-200">Pricing & Stock</h3>
                    <dl class="grid grid-cols-1 gap-2">
                        <div class="flex">
                            <dt class="w-1/3 text-sm font-medium text-gray-500">Category</dt>
                            <dd class="w-2/3 text-sm text-gray-900">{{ $product->category->name ?? '-' }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-1/3 text-sm font-medium text-gray-500">Unit</dt>
                            <dd class="w-2/3 text-sm text-gray-900">{{ $product->unit }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-1/3 text-sm font-medium text-gray-500">Unit Quantity</dt>
                            <dd class="w-2/3 text-sm text-gray-900">{{ $product->unit_qty }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-1/3 text-sm font-medium text-gray-500">Unit Rate</dt>
                            <dd class="w-2/3 text-sm text-gray-900">${{ number_format($product->unit_rate, 2) }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-1/3 text-sm font-medium text-gray-500">Total Buy</dt>
                            <dd class="w-2/3 text-sm text-gray-900">${{ number_format($product->total_buy, 2) }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-1/3 text-sm font-medium text-gray-500">Quantity (Stock)</dt>
                            <dd class="w-2/3 text-sm text-gray-900">{{ $product->quantity }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-1/3 text-sm font-medium text-gray-500">Approximate Rate</dt>
                            <dd class="w-2/3 text-sm text-gray-900">${{ number_format($product->approximate_rate, 2) }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-1/3 text-sm font-medium text-gray-500">Authentication Rate</dt>
                            <dd class="w-2/3 text-sm text-gray-900">${{ number_format($product->authentication_rate, 2) }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-1/3 text-sm font-medium text-gray-500">Sell Rate</dt>
                            <dd class="w-2/3 text-sm text-gray-900">${{ number_format($product->sell_rate, 2) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="mt-6 pt-4 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Created At: {{ $product->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Last Updated: {{ $product->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection