@extends('layouts.app')

@section('title', 'Import Sales Records')

@section('content')
<div class="container mx-auto py-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 md:p-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Import Sales Records</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">
                Upload a CSV or Excel file to import sales records.
            </p>
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

        <form action="{{ route('sales-records.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 gap-6">
                <!-- File Input -->
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload File</label>
                    <input type="file" name="csv_file" id="csv_file" 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                           accept=".csv,.xlsx,.xls" required>
                    @error('file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">Supported formats: CSV, XLSX, XLS</p>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="flex justify-end space-x-3 pt-6">
                <a href="{{ route('sales-records.download.template') }}" 
                   class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    <i class="fas fa-download mr-2"></i> Download Template
                </a>
                <a href="{{ route('sales-records.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    <i class="fas fa-file-import mr-2"></i> Import Sales Records
                </button>
            </div>
        </form>

        <!-- Import Instructions -->
        <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900 rounded-lg">
            <h3 class="text-lg font-medium text-blue-800 dark:text-blue-200 mb-2">Import Instructions</h3>
            <ul class="list-disc list-inside text-blue-700 dark:text-blue-300 space-y-1">
                <li>The file must contain the following columns: invoice_no, customer_id, product_id, product_name, price, quantity, total_amount, payment_status</li>
                <li>All fields except payment_status are required</li>
                <li>payment_status defaults to "pending" if not provided</li>
                <li>created_at and updated_at are optional (will default to current timestamp if not provided)</li>
                <li>Duplicate invoice numbers will update existing records</li>
                <li>Invalid rows will be skipped</li>
            </ul>
        </div>
    </div>
</div>
@endsection