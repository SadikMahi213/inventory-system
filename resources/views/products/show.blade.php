@extends('layouts.erp')

@section('title', 'Product Details')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Product Details</h1>
        <div>
            <a href="{{ route('products.edit', $product) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">
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

    <!-- Product Details -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-bold mb-4">Basic Information</h2>
                    <table class="min-w-full">
                        <tr>
                            <td class="py-2 font-semibold">Product Code:</td>
                            <td class="py-2">{{ $product->product_code }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Name:</td>
                            <td class="py-2">{{ $product->name }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Model:</td>
                            <td class="py-2">{{ $product->model ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Size:</td>
                            <td class="py-2">{{ $product->size ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Color:</td>
                            <td class="py-2">{{ $product->color ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Quality:</td>
                            <td class="py-2">{{ $product->quality ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Unit:</td>
                            <td class="py-2">{{ $product->unit }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Unit Price:</td>
                            <td class="py-2">${{ number_format($product->unit_price, 2) }}</td>
                        </tr>
                    </table>
                </div>

                <div>
                    <h2 class="text-xl font-bold mb-4">Related Information</h2>
                    <table class="min-w-full">
                        <tr>
                            <td class="py-2 font-semibold">Created At:</td>
                            <td class="py-2">{{ $product->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Updated At:</td>
                            <td class="py-2">{{ $product->updated_at->format('M d, Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Total Purchases:</td>
                            <td class="py-2">{{ $product->purchaseRecords->count() }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Total Sales:</td>
                            <td class="py-2">{{ $product->salesRecords->count() }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Current Stock:</td>
                            <td class="py-2">{{ $product->stock ? $product->stock->current_stock : 0 }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Records -->
    <div class="mt-8">
        <h2 class="text-2xl font-bold mb-4">Related Records</h2>
        
        <!-- Purchase Records -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold">Purchase Records</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supplier</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($product->purchaseRecords as $purchase)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $purchase->date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $purchase->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($purchase->unit_price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($purchase->total_price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $purchase->supplier->name ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                No purchase records found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sales Records -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold">Sales Records</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($product->salesRecords as $sale)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $sale->invoice_no }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $sale->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $sale->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($sale->price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($sale->total_amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $sale->customer->name ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                No sales records found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection