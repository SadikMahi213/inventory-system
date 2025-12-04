@extends('layouts.erp')

@section('title', 'Media Library')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Media Library</h1>
        <a href="{{ route('media.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-upload mr-2"></i> Upload Media
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="{{ route('media.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="media_type" class="block text-gray-700 text-sm font-bold mb-2">Media Type</label>
                <select name="media_type" id="media_type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">All Types</option>
                    <option value="image" {{ request('media_type') == 'image' ? 'selected' : '' }}>Image</option>
                    <option value="video" {{ request('media_type') == 'video' ? 'selected' : '' }}>Video</option>
                    <option value="document" {{ request('media_type') == 'document' ? 'selected' : '' }}>Document</option>
                </select>
            </div>
            
            <div>
                <label for="search" class="block text-gray-700 text-sm font-bold mb-2">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search by filename or description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            
            <div class="md:col-span-3 flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
                <a href="{{ route('media.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-undo mr-2"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Media Grid -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($mediaFiles->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
                @foreach($mediaFiles as $media)
                    <div class="border rounded-lg overflow-hidden">
                        <div class="h-40 flex items-center justify-center bg-gray-100">
                            @if($media->media_type == 'image')
                                <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $media->file_name }}" class="max-h-full max-w-full object-contain">
                            @elseif($media->media_type == 'video')
                                <div class="text-center">
                                    <i class="fas fa-file-video text-4xl text-red-500"></i>
                                    <p class="mt-2 text-sm">Video File</p>
                                </div>
                            @else
                                <div class="text-center">
                                    <i class="fas fa-file-alt text-4xl text-blue-500"></i>
                                    <p class="mt-2 text-sm">Document</p>
                                </div>
                            @endif
                        </div>
                        <div class="p-3">
                            <h3 class="text-sm font-medium truncate">{{ $media->file_name }}</h3>
                            <p class="text-xs text-gray-500 mt-1">{{ ucfirst($media->media_type) }}</p>
                            <p class="text-xs text-gray-500">{{ round($media->file_size / 1024, 2) }} KB</p>
                            <div class="flex justify-between mt-2">
                                <a href="{{ route('media.show', $media) }}" class="text-blue-600 hover:text-blue-900 text-xs">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('media.edit', $media) }}" class="text-indigo-600 hover:text-indigo-900 text-xs">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('media.destroy', $media) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-xs" onclick="return confirm('Are you sure you want to delete this media file?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center">
                <i class="fas fa-cloud-upload-alt text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No media files found</h3>
                <p class="text-gray-500 mb-4">Upload your first media file to get started.</p>
                <a href="{{ route('media.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-upload mr-2"></i> Upload Media
                </a>
            </div>
        @endif

        <!-- Pagination -->
        @if($mediaFiles->count() > 0)
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $mediaFiles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection