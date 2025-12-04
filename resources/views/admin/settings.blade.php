@extends('layouts.erp')

@section('title', 'System Settings')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">System Settings</h1>
        <a href="{{ route('admin.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-arrow-left mr-2"></i> Back to Admin
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- General Settings -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-6">General Settings</h2>
            
            <form>
                <div class="mb-6">
                    <label for="site_name" class="block text-gray-700 text-sm font-bold mb-2">Site Name</label>
                    <input type="text" id="site_name" name="site_name" value="Inventory Management ERP" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                
                <div class="mb-6">
                    <label for="site_email" class="block text-gray-700 text-sm font-bold mb-2">Site Email</label>
                    <input type="email" id="site_email" name="site_email" value="admin@example.com" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                
                <div class="mb-6">
                    <label for="timezone" class="block text-gray-700 text-sm font-bold mb-2">Timezone</label>
                    <select id="timezone" name="timezone" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="UTC">UTC</option>
                        <option value="America/New_York" selected>Eastern Time (US & Canada)</option>
                        <option value="America/Chicago">Central Time (US & Canada)</option>
                        <option value="America/Denver">Mountain Time (US & Canada)</option>
                        <option value="America/Los_Angeles">Pacific Time (US & Canada)</option>
                    </select>
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Maintenance Mode</label>
                    <div class="mt-2">
                        <label class="inline-flex items-center">
                            <input type="radio" name="maintenance_mode" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-gray-700">Enabled</span>
                        </label>
                        <label class="inline-flex items-center ml-6">
                            <input type="radio" name="maintenance_mode" value="0" checked class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-gray-700">Disabled</span>
                        </label>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        <i class="fas fa-save mr-2"></i> Save Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Backup Settings -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold mb-4">Backup Settings</h3>
                <p class="text-gray-600 text-sm mb-4">Configure automated backups for your system.</p>
                <a href="{{ route('admin.backups') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm inline-flex items-center">
                    <i class="fas fa-database mr-1"></i> Manage Backups
                </a>
            </div>
            
            <!-- Email Settings -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold mb-4">Email Settings</h3>
                <p class="text-gray-600 text-sm mb-4">Configure email notifications and alerts.</p>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                    <i class="fas fa-envelope mr-1"></i> Configure
                </button>
            </div>
            
            <!-- Security Settings -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold mb-4">Security Settings</h3>
                <p class="text-gray-600 text-sm mb-4">Manage security policies and user permissions.</p>
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                    <i class="fas fa-shield-alt mr-1"></i> Security Center
                </button>
            </div>
        </div>
    </div>
</div>
@endsection