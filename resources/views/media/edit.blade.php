@extends('layouts.erp')

@section('title', 'Edit Media')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Edit Media</h1>
        <a href="{{ route('media.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-arrow-left mr-2"></i> Back to Media
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Whoops!</strong>
            <span class="block sm:inline">There were some problems with your input.</span>
            <ul class="list-disc pl-5 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('media.update', $media) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <div class="flex items-center justify-center w-full mb-6">
                        @if($media->media_type == 'image')
                            <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $media->file_name }}" class="max-h-64 max-w-full object-contain">
                        @elseif($media->media_type == 'video')
                            <div class="text-center">
                                <i class="fas fa-file-video text-6xl text-red-500"></i>
                                <p class="mt-2 text-lg">Video File</p>
                            </div>
                        @else
                            <div class="text-center">
                                <i class="fas fa-file-alt text-6xl text-blue-500"></i>
                                <p class="mt-2 text-lg">Document</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div>
                    <label for="media_type" class="block text-gray-700 text-sm font-bold mb-2">Media Type *</label>
                    <select name="media_type" id="media_type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Select Media Type</option>
                        <option value="image" {{ (old('media_type', $media->media_type) == 'image') ? 'selected' : '' }}>Image</option>
                        <option value="video" {{ (old('media_type', $media->media_type) == 'video') ? 'selected' : '' }}>Video</option>
                        <option value="document" {{ (old('media_type', $media->media_type) == 'document') ? 'selected' : '' }}>Document</option>
                    </select>
                </div>
                
                <div>
                    <label for="is_public" class="block text-gray-700 text-sm font-bold mb-2">Visibility</label>
                    <div class="mt-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_public" id="is_public" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ (old('is_public', $media->is_public) ? 'checked' : '') }}>
                            <span class="ml-2 text-gray-700">Make this file publicly accessible</span>
                        </label>
                    </div>
                </div>
                
                <div class="md:col-span-2">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea name="description" id="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $media->description) }}</textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">File Information</label>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p><strong>Filename:</strong> {{ $media->file_name }}</p>
                        <p><strong>File Size:</strong> {{ round($media->file_size / 1024, 2) }} KB</p>
                        <p><strong>Uploaded:</strong> {{ $media->created_at->format('F j, Y g:i A') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-save mr-2"></i> Update Media
                </button>
            </div>
        </form>
    </div>
</div>
@endsection