@extends('layouts.erp')

@section('title', 'Media Details')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Media Details</h1>
        <div>
            <a href="{{ route('media.edit', $media) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <a href="{{ route('media.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-2"></i> Back to Media
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
            <h2 class="text-xl font-semibold">{{ $media->file_name }}</h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="flex items-center justify-center w-full mb-6 bg-gray-50 rounded-lg p-4">
                        @if($media->media_type == 'image')
                            <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $media->file_name }}" class="max-h-96 max-w-full object-contain">
                        @elseif($media->media_type == 'video')
                            <div class="text-center">
                                <i class="fas fa-file-video text-6xl text-red-500"></i>
                                <p class="mt-2 text-lg">Video File</p>
                                <a href="{{ asset('storage/' . $media->file_path) }}" target="_blank" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-play-circle mr-2"></i> Play Video
                                </a>
                            </div>
                        @else
                            <div class="text-center">
                                <i class="fas fa-file-alt text-6xl text-blue-500"></i>
                                <p class="mt-2 text-lg">Document</p>
                                <a href="{{ asset('storage/' . $media->file_path) }}" target="_blank" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-download mr-2"></i> Download Document
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">File Information</h3>
                    <dl class="grid grid-cols-1 gap-4">
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Filename</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $media->file_name }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Media Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($media->media_type) }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">File Size</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ round($media->file_size / 1024, 2) }} KB</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">File Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $media->file_type }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Uploaded</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $media->created_at->format('F j, Y g:i A') }}</dd>
                        </div>
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Public Access</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($media->is_public)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Public
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Private
                                    </span>
                                @endif
                            </dd>
                        </div>
                        @if($media->description)
                        <div class="border-b border-gray-100 pb-2">
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $media->description }}</dd>
                        </div>
                        @endif
                    </dl>
                    
                    <div class="mt-6">
                        <a href="{{ asset('storage/' . $media->file_path) }}" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-download mr-2"></i> Download File
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
                <div class="flex space-x-4">
                    <a href="{{ route('media.edit', $media) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-edit mr-2"></i> Edit Media
                    </a>
                    
                    <form action="{{ route('media.destroy', $media) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this media file? This action cannot be undone.')">
                            <i class="fas fa-trash mr-2"></i> Delete Media
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection