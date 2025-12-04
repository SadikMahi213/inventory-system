@extends('layouts.website')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Media Gallery
            </h1>
            <p class="mt-2 text-gray-500">
                Browse our collection of images and videos
            </p>
        </div>
        
        @auth
        <div class="mt-4 md:mt-0">
            <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-toggle="modal" data-target="#uploadModal">
                <i class="fas fa-upload mr-2"></i> Upload Media
            </button>
        </div>
        @endauth
    </div>

    <!-- Media Grid -->
    @if($mediaItems->count() > 0)
    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @foreach($mediaItems as $media)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
            @if(Str::startsWith($media->file_type, 'image'))
                <div class="bg-gray-200 border-2 border-dashed rounded-t-lg w-full h-48 flex items-center justify-center">
                    <i class="fas fa-image text-4xl text-gray-400"></i>
                </div>
            @elseif(Str::startsWith($media->file_type, 'video'))
                <div class="bg-gray-200 border-2 border-dashed rounded-t-lg w-full h-48 flex items-center justify-center">
                    <i class="fas fa-video text-4xl text-gray-400"></i>
                </div>
            @else
                <div class="bg-gray-200 border-2 border-dashed rounded-t-lg w-full h-48 flex items-center justify-center">
                    <i class="fas fa-file text-4xl text-gray-400"></i>
                </div>
            @endif
            
            <div class="p-4">
                <h3 class="text-lg font-medium text-gray-900 truncate">{{ $media->title }}</h3>
                <p class="mt-1 text-sm text-gray-500 truncate">{{ $media->description ?? 'No description' }}</p>
                <div class="mt-3 flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500">
                        {{ \Carbon\Carbon::parse($media->created_at)->format('M d, Y') }}
                    </span>
                    <span class="inline-flex items-center text-xs font-medium text-gray-500">
                        <i class="fas fa-file-alt mr-1"></i>
                        {{ Str::upper(pathinfo($media->file_path, PATHINFO_EXTENSION)) }}
                    </span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $mediaItems->links() }}
    </div>
    @else
    <div class="mt-12 text-center">
        <i class="fas fa-photo-video text-5xl text-gray-300"></i>
        <h3 class="mt-4 text-lg font-medium text-gray-900">No media found</h3>
        <p class="mt-1 text-gray-500">There are currently no media items in the gallery.</p>
        
        @auth
        <div class="mt-6">
            <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-toggle="modal" data-target="#uploadModal">
                <i class="fas fa-upload mr-2"></i> Upload Your First Media
            </button>
        </div>
        @endauth
    </div>
    @endif
</div>

<!-- Upload Modal -->
@if(auth()->check())
<div class="fixed z-10 inset-0 overflow-y-auto hidden" id="uploadModal">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('website.media.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-cloud-upload-alt text-indigo-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Upload Media
                            </h3>
                            <div class="mt-4">
                                <div class="space-y-4">
                                    <div>
                                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                        <input type="text" name="title" id="title" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>
                                    
                                    <div>
                                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                    </div>
                                    
                                    <div>
                                        <label for="media" class="block text-sm font-medium text-gray-700">Media File</label>
                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                            <div class="space-y-1 text-center">
                                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                                                <div class="flex text-sm text-gray-600">
                                                    <label for="media" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                        <span>Upload a file</span>
                                                        <input id="media" name="media" type="file" class="sr-only" required>
                                                    </label>
                                                    <p class="pl-1">or drag and drop</p>
                                                </div>
                                                <p class="text-xs text-gray-500">
                                                    PNG, JPG, GIF, MP4, MOV up to 10MB
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Upload
                    </button>
                    <button type="button" class="close-modal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal functionality
    const modal = document.getElementById('uploadModal');
    const openModalButtons = document.querySelectorAll('[data-toggle="modal"]');
    const closeModalButtons = document.querySelectorAll('.close-modal');
    
    openModalButtons.forEach(button => {
        button.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });
    });
    
    closeModalButtons.forEach(button => {
        button.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    });
    
    // Close modal when clicking outside
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });
});
</script>
@endsection