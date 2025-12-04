@extends('layouts.erp')

@section('title', 'Edit Cost Analysis')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Edit Cost Analysis</h1>
        <a href="{{ route('cost-analysis.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-arrow-left mr-2"></i> Back to Analysis
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
        <form action="{{ route('cost-analysis.update', $costAnalysis) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="product_id" class="block text-gray-700 text-sm font-bold mb-2">Product *</label>
                    <select name="product_id" id="product_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ (old('product_id', $costAnalysis->product_id) == $product->id) ? 'selected' : '' }}>
                                {{ $product->name }} ({{ $product->product_code }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="purchase_record_id" class="block text-gray-700 text-sm font-bold mb-2">Purchase Record *</label>
                    <select name="purchase_record_id" id="purchase_record_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Select Purchase Record</option>
                        @foreach($purchaseRecords as $purchase)
                            <option value="{{ $purchase->id }}" {{ (old('purchase_record_id', $costAnalysis->purchase_record_id) == $purchase->id) ? 'selected' : '' }}>
                                {{ $purchase->product->name ?? 'N/A' }} - {{ $purchase->date->format('M d, Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="staff_cost" class="block text-gray-700 text-sm font-bold mb-2">Staff Cost *</label>
                    <input type="number" step="0.01" name="staff_cost" id="staff_cost" value="{{ old('staff_cost', $costAnalysis->staff_cost) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                
                <div>
                    <label for="shop_cost" class="block text-gray-700 text-sm font-bold mb-2">Shop Cost *</label>
                    <input type="number" step="0.01" name="shop_cost" id="shop_cost" value="{{ old('shop_cost', $costAnalysis->shop_cost) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                
                <div>
                    <label for="transport_cost" class="block text-gray-700 text-sm font-bold mb-2">Transport Cost *</label>
                    <input type="number" step="0.01" name="transport_cost" id="transport_cost" value="{{ old('transport_cost', $costAnalysis->transport_cost) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                
                <div>
                    <label for="other_expense" class="block text-gray-700 text-sm font-bold mb-2">Other Expense *</label>
                    <input type="number" step="0.01" name="other_expense" id="other_expense" value="{{ old('other_expense', $costAnalysis->other_expense) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                
                <div class="md:col-span-2">
                    <label for="final_selling_price" class="block text-gray-700 text-sm font-bold mb-2">Final Selling Price *</label>
                    <input type="number" step="0.01" name="final_selling_price" id="final_selling_price" value="{{ old('final_selling_price', $costAnalysis->final_selling_price) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
            </div>
            
            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-save mr-2"></i> Update Analysis
                </button>
            </div>
        </form>
    </div>
</div>
@endsection