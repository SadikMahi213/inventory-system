@extends('layouts.erp')

@section('title', 'Purchase Details')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Purchase Details</h1>
        <div>
            <a href="{{ route('purchase-records.edit', $purchaseRecord) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <a href="{{ route('purchase-records.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-2"></i> Back to Purchases
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

    <!-- Purchase Details -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-bold mb-4">Purchase Information</h2>
                    <table class="min-w-full">
                        <tr>
                            <td class="py-2 font-semibold">Date:</td>
                            <td class="py-2">{{ optional($purchaseRecord->date)->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Product:</td>
                            <td class="py-2">{{ $purchaseRecord->product_name }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Model:</td>
                            <td class="py-2">{{ $purchaseRecord->model ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Size:</td>
                            <td class="py-2">{{ $purchaseRecord->size ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Color:</td>
                            <td class="py-2">{{ $purchaseRecord->color ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Quality:</td>
                            <td class="py-2">{{ $purchaseRecord->quality ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Unit:</td>
                            <td class="py-2">{{ $purchaseRecord->unit }}</td>
                        </tr>
                    </table>
                </div>

                <div>
                    <h2 class="text-xl font-bold mb-4">Financial Information</h2>
                    <table class="min-w-full">
                        <tr>
                            <td class="py-2 font-semibold">Quantity:</td>
                            <td class="py-2">{{ $purchaseRecord->quantity }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Unit Price:</td>
                            <td class="py-2">${{ number_format($purchaseRecord->unit_price, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Total Price:</td>
                            <td class="py-2">${{ number_format($purchaseRecord->total_price, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Supplier:</td>
                            <td class="py-2">{{ $purchaseRecord->supplier->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Payment Status:</td>
                            <td class="py-2">
                                @if($purchaseRecord->payment_status == 'paid')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Paid
                                    </span>
                                @elseif($purchaseRecord->payment_status == 'partial')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Partial
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Pending
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Created At:</td>
                            <td class="py-2">{{ $purchaseRecord->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Updated At:</td>
                            <td class="py-2">{{ $purchaseRecord->updated_at->format('M d, Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Information -->
    <div class="mt-8">
        <h2 class="text-2xl font-bold mb-4">Related Information</h2>
        
        <!-- Stock Impact -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold">Stock Impact</h3>
            </div>
            <div class="px-6 py-4">
    @if(optional($purchaseRecord->product)->stock)
        <p>Current stock for this product: <strong>{{ optional($purchaseRecord->product->stock)->current_stock ?? 'N/A' }}</strong></p>
        <p>Purchase quantity added: <strong>{{ $purchaseRecord->quantity ?? 'N/A' }}</strong></p>
        <p>Average cost per unit: <strong>${{ number_format(optional($purchaseRecord->product->stock)->average_cost ?? 0, 2) }}</strong></p>
    @else
        <p>No stock information available for this product.</p>
    @endif
</div>

        </div>
    </div>
</div>
@endsection