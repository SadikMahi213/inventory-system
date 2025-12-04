@extends('layouts.erp')

@section('title', 'Customer Details')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Customer Details</h1>
        <div>
            <a href="{{ route('customers.edit', $customer) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <a href="{{ route('customers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-2"></i> Back to Customers
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
            <h2 class="text-xl font-semibold">{{ $customer->name }}</h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                    <dl class="grid grid-cols-1 gap-4">
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Customer Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $customer->name }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $customer->phone ?? 'N/A' }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $customer->email ?? 'N/A' }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $customer->address ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Statistics</h3>
                    <dl class="grid grid-cols-1 gap-4">
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Total Purchases</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $customer->salesRecords->count() }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Total Amount Spent</dt>
                            <dd class="mt-1 text-sm text-gray-900">${{ number_format($customer->salesRecords->sum('total_amount'), 2) }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Last Purchase</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($customer->salesRecords->count() > 0)
                                    {{ $customer->salesRecords->first()->created_at->format('M d, Y') }}
                                @else
                                    N/A
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Sales</h3>
                @if($customer->salesRecords->count() > 0)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <ul class="divide-y divide-gray-200">
                            @foreach($customer->salesRecords->take(5) as $sale)
                                <li class="py-2">
                                    <div class="flex justify-between">
                                        <span>{{ $sale->product_name }}</span>
                                        <span class="font-medium">${{ number_format($sale->total_amount, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm text-gray-500">
                                        <span>{{ $sale->quantity }} units</span>
                                        <span>{{ $sale->created_at->format('M d, Y') }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <p class="text-gray-500">No sales records found for this customer.</p>
                @endif
            </div>
            
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
                <div class="flex space-x-4">
                    <a href="{{ route('customers.edit', $customer) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-edit mr-2"></i> Edit Customer
                    </a>
                    
                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this customer? This action cannot be undone.')">
                            <i class="fas fa-trash mr-2"></i> Delete Customer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection