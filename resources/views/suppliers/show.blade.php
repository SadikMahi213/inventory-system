@extends('layouts.erp')

@section('title', 'Supplier Details')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Supplier Details</h1>
        <div>
            <a href="{{ route('suppliers.edit', $supplier) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <a href="{{ route('suppliers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-2"></i> Back to Suppliers
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
            <h2 class="text-xl font-semibold">{{ $supplier->name }}</h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                    <dl class="grid grid-cols-1 gap-4">
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Supplier Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $supplier->name }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Company Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $supplier->company_name ?? 'N/A' }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Contact Person</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $supplier->contact_person ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                    <dl class="grid grid-cols-1 gap-4">
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $supplier->phone ?? 'N/A' }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $supplier->email ?? 'N/A' }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $supplier->address ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
            
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Related Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 mb-2">Recent Purchases</h4>
                        @if($supplier->purchaseRecords->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($supplier->purchaseRecords->take(5) as $purchase)
                                    <li class="py-2">
                                        <div class="flex justify-between">
                                            <span>{{ $purchase->product->name ?? 'N/A' }}</span>
                                            <span class="font-medium">{{ $purchase->quantity }} units</span>
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $purchase->created_at->format('M d, Y') }}</div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 text-sm">No recent purchases</p>
                        @endif
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 mb-2">Statistics</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span>Total Purchases:</span>
                                <span class="font-medium">{{ $supplier->purchaseRecords->count() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Total Amount Spent:</span>
                                <span class="font-medium">
                                    ${{ number_format($supplier->purchaseRecords->sum('total_price'), 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
                <div class="flex space-x-4">
                    <a href="{{ route('suppliers.edit', $supplier) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-edit mr-2"></i> Edit Supplier
                    </a>
                    
                    <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this supplier? This action cannot be undone.')">
                            <i class="fas fa-trash mr-2"></i> Delete Supplier
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection