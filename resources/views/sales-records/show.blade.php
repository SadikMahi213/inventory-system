@extends('layouts.erp')

@section('title', 'Sale Details')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Sale Details</h1>
        <div>
            <a href="{{ route('sales-records.edit', $salesRecord) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <a href="{{ route('sales-records.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-2"></i> Back to Sales
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
            <h2 class="text-xl font-semibold">Invoice #{{ $salesRecord->invoice_no }}</h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Sale Information</h3>
                    <dl class="grid grid-cols-1 gap-4">
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Invoice Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $salesRecord->invoice_no }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $salesRecord->created_at->format('F j, Y g:i A') }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Customer</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $salesRecord->customer->name ?? 'N/A' }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Product</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $salesRecord->product_name }}</dd>
                        </div>
                    </dl>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Financial Details</h3>
                    <dl class="grid grid-cols-1 gap-4">
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Quantity</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $salesRecord->quantity }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Unit Price</dt>
                            <dd class="mt-1 text-sm text-gray-900">${{ number_format($salesRecord->price, 2) }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Total Amount</dt>
                            <dd class="mt-1 text-sm text-gray-900">${{ number_format($salesRecord->total_amount, 2) }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Payment Status</dt>
                            <dd class="mt-1 text-sm">
                                @if($salesRecord->payment_status == 'paid')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Paid
                                    </span>
                                @elseif($salesRecord->payment_status == 'partial')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Partial
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Pending
                                    </span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
                <div class="flex space-x-4">
                    <a href="{{ route('sales-records.edit', $salesRecord) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-edit mr-2"></i> Edit Sale
                    </a>
                    
                    <form action="{{ route('sales-records.destroy', $salesRecord) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this sales record? This action cannot be undone.')">
                            <i class="fas fa-trash mr-2"></i> Delete Sale
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection