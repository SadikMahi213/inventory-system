@extends('layouts.erp')

@section('title', 'CSV Import/Export')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">CSV Import/Export</h1>
        <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Import Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Import Data</h2>
            
            <div class="space-y-6">
                <!-- Import Products -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-3">Import Products</h3>
                    <p class="text-gray-600 text-sm mb-4">Upload a CSV file containing product information.</p>
                    <form action="{{ route('csv.import.products') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-4">
                        @csrf
                        <input type="file" name="file" accept=".csv,.txt" class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm" required>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                            <i class="fas fa-upload mr-1"></i> Import
                        </button>
                    </form>
                </div>
                
                <!-- Import Purchase Records -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-3">Import Purchase Records</h3>
                    <p class="text-gray-600 text-sm mb-4">Upload a CSV file containing purchase records.</p>
                    <form action="{{ route('csv.import.purchase-records') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-4">
                        @csrf
                        <input type="file" name="file" accept=".csv,.txt" class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm" required>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                            <i class="fas fa-upload mr-1"></i> Import
                        </button>
                    </form>
                </div>
                
                <!-- Import Sales Records -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-3">Import Sales Records</h3>
                    <p class="text-gray-600 text-sm mb-4">Upload a CSV file containing sales records.</p>
                    <form action="{{ route('csv.import.sales-records') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-4">
                        @csrf
                        <input type="file" name="file" accept=".csv,.txt" class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm" required>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                            <i class="fas fa-upload mr-1"></i> Import
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Export Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Export Data</h2>
            
            <div class="space-y-6">
                <!-- Export Products -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-3">Export Products</h3>
                    <p class="text-gray-600 text-sm mb-4">Download all products as a CSV file.</p>
                    <a href="{{ route('csv.export.products') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm inline-flex items-center">
                        <i class="fas fa-download mr-1"></i> Export Products
                    </a>
                </div>
                
                <!-- Export Purchase Records -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-3">Export Purchase Records</h3>
                    <p class="text-gray-600 text-sm mb-4">Download all purchase records as a CSV file.</p>
                    <a href="{{ route('csv.export.purchase-records') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm inline-flex items-center">
                        <i class="fas fa-download mr-1"></i> Export Purchase Records
                    </a>
                </div>
                
                <!-- Export Sales Records -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-3">Export Sales Records</h3>
                    <p class="text-gray-600 text-sm mb-4">Download all sales records as a CSV file.</p>
                    <a href="{{ route('csv.export.sales-records') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm inline-flex items-center">
                        <i class="fas fa-download mr-1"></i> Export Sales Records
                    </a>
                </div>
                
                <!-- Export Stock -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-3">Export Stock</h3>
                    <p class="text-gray-600 text-sm mb-4">Download current stock levels as a CSV file.</p>
                    <a href="{{ route('csv.export.stock') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm inline-flex items-center">
                        <i class="fas fa-download mr-1"></i> Export Stock
                    </a>
                </div>
                
                <!-- Export Profit & Loss -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-3">Export Profit & Loss</h3>
                    <p class="text-gray-600 text-sm mb-4">Download profit and loss records as a CSV file.</p>
                    <a href="{{ route('csv.export.profit-loss') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm inline-flex items-center">
                        <i class="fas fa-download mr-1"></i> Export P&L
                    </a>
                </div>
                
                <!-- Export Suppliers -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-3">Export Suppliers</h3>
                    <p class="text-gray-600 text-sm mb-4">Download all suppliers as a CSV file.</p>
                    <a href="{{ route('csv.export.suppliers') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm inline-flex items-center">
                        <i class="fas fa-download mr-1"></i> Export Suppliers
                    </a>
                </div>
                
                <!-- Export Customers -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-3">Export Customers</h3>
                    <p class="text-gray-600 text-sm mb-4">Download all customers as a CSV file.</p>
                    <a href="{{ route('csv.export.customers') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm inline-flex items-center">
                        <i class="fas fa-download mr-1"></i> Export Customers
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Instructions -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4 text-blue-800">Instructions</h2>
        <ul class="list-disc pl-5 space-y-2 text-blue-700">
            <li>CSV files must be properly formatted with the correct headers</li>
            <li>Maximum file size is 10MB</li>
            <li>Supported formats: CSV, TXT</li>
            <li>Imported data will be merged with existing records</li>
            <li>Exported files will be downloaded automatically</li>
        </ul>
    </div>
</div>
@endsection