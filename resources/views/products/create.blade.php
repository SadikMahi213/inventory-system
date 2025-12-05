@extends('layouts.erp')

@section('title', 'Create Product')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Create Product</h1>
        <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-arrow-left mr-2"></i> Back to Products
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Whoops!</strong>
            <span class="block sm:inline">There were some problems with your input.</span>
            <ul class="list-disc list-inside mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('products.store') }}" method="POST" id="productForm">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Product Name -->
                <div>
                    <label for="product_name" class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
                    <input type="text" name="product_name" id="product_name" value="{{ old('product_name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <!-- Size -->
                <div>
                    <label for="size" class="block text-sm font-medium text-gray-700 mb-1">Size</label>
                    <input type="text" name="size" id="size" value="{{ old('size') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Brand -->
                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                    <input type="text" name="brand" id="brand" value="{{ old('brand') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Grade -->
                <div>
                    <label for="grade" class="block text-sm font-medium text-gray-700 mb-1">Grade</label>
                    <input type="text" name="grade" id="grade" value="{{ old('grade') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Material -->
                <div>
                    <label for="material" class="block text-sm font-medium text-gray-700 mb-1">Material</label>
                    <input type="text" name="material" id="material" value="{{ old('material') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Color -->
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                    <input type="text" name="color" id="color" value="{{ old('color') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Model No -->
                <div>
                    <label for="model_no" class="block text-sm font-medium text-gray-700 mb-1">Model No</label>
                    <input type="text" name="model_no" id="model_no" value="{{ old('model_no') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Product Code -->
                <div>
                    <label for="product_code" class="block text-sm font-medium text-gray-700 mb-1">Product Code *</label>
                    <input type="text" name="product_code" id="product_code" value="{{ old('product_code') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <!-- Unit Qty -->
                <div>
                    <label for="unit_qty" class="block text-sm font-medium text-gray-700 mb-1">Unit Quantity *</label>
                    <input type="number" step="0.01" name="unit_qty" id="unit_qty" value="{{ old('unit_qty', 0) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <!-- Unit -->
                <div>
                    <label for="unit" class="block text-sm font-medium text-gray-700 mb-1">Unit *</label>
                    <input type="text" name="unit" id="unit" value="{{ old('unit', 'piece') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <!-- Unit Rate -->
                <div>
                    <label for="unit_rate" class="block text-sm font-medium text-gray-700 mb-1">Unit Rate (Buy Price) *</label>
                    <input type="number" step="0.01" name="unit_rate" id="unit_rate" value="{{ old('unit_rate', 0) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <!-- Total Buy -->
                <div>
                    <label for="total_buy" class="block text-sm font-medium text-gray-700 mb-1">Total Buy *</label>
                    <input type="number" step="0.01" name="total_buy" id="total_buy" value="{{ old('total_buy', 0) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required readonly>
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                    <select name="category_id" id="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Quantity -->
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity (Stock) *</label>
                    <input type="number" step="0.01" name="quantity" id="quantity" value="{{ old('quantity', 0) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <!-- Approximate Rate -->
                <div>
                    <label for="approximate_rate" class="block text-sm font-medium text-gray-700 mb-1">Approximate Rate *</label>
                    <input type="number" step="0.01" name="approximate_rate" id="approximate_rate" value="{{ old('approximate_rate', 0) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <!-- Authentication Rate -->
                <div>
                    <label for="authentication_rate" class="block text-sm font-medium text-gray-700 mb-1">Authentication Rate *</label>
                    <input type="number" step="0.01" name="authentication_rate" id="authentication_rate" value="{{ old('authentication_rate', 0) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <!-- Sell Rate -->
                <div>
                    <label for="sell_rate" class="block text-sm font-medium text-gray-700 mb-1">Sell Rate *</label>
                    <input type="number" step="0.01" name="sell_rate" id="sell_rate" value="{{ old('sell_rate', 0) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-save mr-2"></i> Create Product
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Auto-calculate total_buy = unit_qty * unit_rate
    document.addEventListener('DOMContentLoaded', function() {
        const unitQty = document.getElementById('unit_qty');
        const unitRate = document.getElementById('unit_rate');
        const totalBuy = document.getElementById('total_buy');
        
        function calculateTotalBuy() {
            const qty = parseFloat(unitQty.value) || 0;
            const rate = parseFloat(unitRate.value) || 0;
            totalBuy.value = (qty * rate).toFixed(2);
        }
        
        unitQty.addEventListener('input', calculateTotalBuy);
        unitRate.addEventListener('input', calculateTotalBuy);
        
        // Calculate initial value
        calculateTotalBuy();
    });
</script>
@endsection