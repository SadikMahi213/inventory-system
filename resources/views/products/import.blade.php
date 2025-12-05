@extends('layouts.app')

@section('title', 'Import Products')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 md:p-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Import Products</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">
                Upload an Excel or CSV file to import products into the system.
            </p>
        </div>

        <!-- Authentication Reminder -->
        <div class="mb-6 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded">
            <strong>Note:</strong> You are currently logged in and can access the template download functionality.
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h2 class="text-xl font-semibold mb-4">Download Template</h2>
                <p class="mb-4">Download the Excel template to ensure your data is formatted correctly for import.</p>
                <a href="{{ route('products.download.template') }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    <i class="fas fa-download mr-2"></i> Download Template
                </a>
            </div>

            <hr class="my-6 md:hidden">

            <div>
                <h2 class="text-xl font-semibold mb-4">Import Products</h2>
                <p class="mb-4">Upload your Excel or CSV file to import products.</p>
                
                <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Select File *</label>
                        <input type="file" name="file" id="file" accept=".xlsx,.xls,.csv" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" required>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Supported formats: .xlsx, .xls, .csv</p>
                    </div>
                    
                    <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-md">
                        <h3 class="font-medium text-blue-800 dark:text-blue-200 mb-2">Import Rules:</h3>
                        <ul class="list-disc list-inside text-sm text-blue-700 dark:text-blue-300 space-y-1">
                            <li>Duplicate product codes will update existing records</li>
                            <li>Missing categories will be automatically created</li>
                            <li>Total buy will be calculated if left empty (Unit Qty × Unit Rate)</li>
                            <li>Empty rows will be skipped automatically</li>
                        </ul>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                            <i class="fas fa-file-import mr-2"></i> Import Products
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection