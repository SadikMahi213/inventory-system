@extends('layouts.erp')

@section('title', 'Profit & Loss Details')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Profit & Loss Details</h1>
        <div>
            <a href="{{ route('profit-loss.edit', $profitLoss) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <a href="{{ route('profit-loss.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-2"></i> Back to P&L
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
            <h2 class="text-xl font-semibold">Report Date: {{ $profitLoss->report_date->format('F j, Y') }}</h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Product Information</h3>
                    <dl class="grid grid-cols-1 gap-4">
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Product</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $profitLoss->product->name ?? 'Overall Report' }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Product Code</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $profitLoss->product->product_code ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Financial Summary</h3>
                    <dl class="grid grid-cols-1 gap-4">
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Revenue</dt>
                            <dd class="mt-1 text-sm text-gray-900">${{ number_format($profitLoss->revenue, 2) }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Cost of Goods Sold (COGS)</dt>
                            <dd class="mt-1 text-sm text-gray-900">${{ number_format($profitLoss->cogs, 2) }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Total Expenses</dt>
                            <dd class="mt-1 text-sm text-gray-900">${{ number_format($profitLoss->total_expenses, 2) }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Net Profit</dt>
                            <dd class="mt-1 text-sm">
                                @if($profitLoss->net_profit >= 0)
                                    <span class="text-green-600 font-medium">${{ number_format($profitLoss->net_profit, 2) }}</span>
                                @else
                                    <span class="text-red-600 font-medium">-${{ number_format(abs($profitLoss->net_profit), 2) }}</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Expense Breakdown</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h4 class="font-medium text-blue-900 mb-2">Staff Cost</h4>
                        <p class="text-2xl font-bold text-blue-700">${{ number_format($profitLoss->staff_cost, 2) }}</p>
                    </div>
                    
                    <div class="bg-green-50 rounded-lg p-4">
                        <h4 class="font-medium text-green-900 mb-2">Shop Cost</h4>
                        <p class="text-2xl font-bold text-green-700">${{ number_format($profitLoss->shop_cost, 2) }}</p>
                    </div>
                    
                    <div class="bg-yellow-50 rounded-lg p-4">
                        <h4 class="font-medium text-yellow-900 mb-2">Transport Cost</h4>
                        <p class="text-2xl font-bold text-yellow-700">${{ number_format($profitLoss->transport_cost, 2) }}</p>
                    </div>
                    
                    <div class="bg-purple-50 rounded-lg p-4">
                        <h4 class="font-medium text-purple-900 mb-2">Other Expenses</h4>
                        <p class="text-2xl font-bold text-purple-700">${{ number_format($profitLoss->other_expense, 2) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
                <div class="flex space-x-4">
                    <a href="{{ route('profit-loss.edit', $profitLoss) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-edit mr-2"></i> Edit Record
                    </a>
                    
                    <form action="{{ route('profit-loss.destroy', $profitLoss) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this profit & loss record? This action cannot be undone.')">
                            <i class="fas fa-trash mr-2"></i> Delete Record
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection