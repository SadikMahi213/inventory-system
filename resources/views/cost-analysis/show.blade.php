@extends('layouts.erp')

@section('title', 'Cost Analysis Details')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Cost Analysis Details</h1>
        <div>
            <a href="{{ route('cost-analysis.edit', $costAnalysis) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <a href="{{ route('cost-analysis.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-2"></i> Back to Analysis
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
            <h2 class="text-xl font-semibold">Analysis for {{ $costAnalysis->product->name ?? 'N/A' }}</h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Product Information</h3>
                    <dl class="grid grid-cols-1 gap-4">
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Product Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $costAnalysis->product->name ?? 'N/A' }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Product Code</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $costAnalysis->product->product_code ?? 'N/A' }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Purchase Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $costAnalysis->purchaseRecord->date->format('F j, Y') ?? 'N/A' }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Purchase Quantity</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $costAnalysis->purchaseRecord->quantity ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Cost Analysis</h3>
                    <dl class="grid grid-cols-1 gap-4">
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Staff Cost</dt>
                            <dd class="mt-1 text-sm text-gray-900">${{ number_format($costAnalysis->staff_cost, 2) }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Shop Cost</dt>
                            <dd class="mt-1 text-sm text-gray-900">${{ number_format($costAnalysis->shop_cost, 2) }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Transport Cost</dt>
                            <dd class="mt-1 text-sm text-gray-900">${{ number_format($costAnalysis->transport_cost, 2) }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Other Expense</dt>
                            <dd class="mt-1 text-sm text-gray-900">${{ number_format($costAnalysis->other_expense, 2) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
            
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Summary</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h4 class="font-medium text-blue-900 mb-2">Total Additional Costs</h4>
                        <p class="text-2xl font-bold text-blue-700">${{ number_format($costAnalysis->total_additional_cost, 2) }}</p>
                    </div>
                    
                    <div class="bg-green-50 rounded-lg p-4">
                        <h4 class="font-medium text-green-900 mb-2">Final Selling Price</h4>
                        <p class="text-2xl font-bold text-green-700">${{ number_format($costAnalysis->final_selling_price, 2) }}</p>
                    </div>
                    
                    <div class="bg-purple-50 rounded-lg p-4">
                        <h4 class="font-medium text-purple-900 mb-2">Profit Margin</h4>
                        <p class="text-2xl font-bold text-purple-700">
                            @if($costAnalysis->purchaseRecord)
                                @php
                                    $purchaseCost = $costAnalysis->purchaseRecord->total_price ?? 0;
                                    $profit = $costAnalysis->final_selling_price - $purchaseCost - $costAnalysis->total_additional_cost;
                                    $margin = $purchaseCost > 0 ? ($profit / $purchaseCost) * 100 : 0;
                                @endphp
                                {{ number_format($margin, 2) }}%
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
                <div class="flex space-x-4">
                    <a href="{{ route('cost-analysis.edit', $costAnalysis) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-edit mr-2"></i> Edit Analysis
                    </a>
                    
                    <form action="{{ route('cost-analysis.destroy', $costAnalysis) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this cost analysis? This action cannot be undone.')">
                            <i class="fas fa-trash mr-2"></i> Delete Analysis
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection