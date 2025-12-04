@extends('layouts.erp')

@section('title', 'Edit Sale')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Edit Sale</h1>
        <a href="{{ route('sales-records.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-arrow-left mr-2"></i> Back to Sales
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Whoops!</strong>
            <span class="block sm:inline">There were some problems with your input.</span>
            <ul class="list-disc pl-5 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('sales-records.update', $salesRecord) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="customer_id" class="block text-gray-700 text-sm font-bold mb-2">Customer *</label>
                    <select name="customer_id" id="customer_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ (old('customer_id', $salesRecord->customer_id) == $customer->id) ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="product_id" class="block text-gray-700 text-sm font-bold mb-2">Product *</label>
                    <select name="product_id" id="product_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->selling_price }}" {{ (old('product_id', $salesRecord->product_id) == $product->id) ? 'selected' : '' }}>
                                {{ $product->name }} (Code: {{ $product->product_code }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Price *</label>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $salesRecord->price) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                
                <div>
                    <label for="quantity" class="block text-gray-700 text-sm font-bold mb-2">Quantity *</label>
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $salesRecord->quantity) }}" min="1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                
                <div>
                    <label for="payment_status" class="block text-gray-700 text-sm font-bold mb-2">Payment Status *</label>
                    <select name="payment_status" id="payment_status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="pending" {{ (old('payment_status', $salesRecord->payment_status) == 'pending') ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ (old('payment_status', $salesRecord->payment_status) == 'paid') ? 'selected' : '' }}>Paid</option>
                        <option value="partial" {{ (old('payment_status', $salesRecord->payment_status) == 'partial') ? 'selected' : '' }}>Partial</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-save mr-2"></i> Update Sale
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_id');
    const priceInput = document.getElementById('price');
    
    productSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        
        if (price) {
            priceInput.value = parseFloat(price).toFixed(2);
        }
    });
});
</script>
@endsection