<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $mediaFiles = Media::latest()->paginate(10);
        return view('media.index', compact('mediaFiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('media.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'media_type' => 'required|in:image,video,document',
            'description' => 'nullable|string',
            'is_public' => 'boolean',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('media', $fileName, 'public');
        $fileSize = $file->getSize();
        $fileType = $file->getMimeType();

        Media::create([
            'file_name' => $fileName,
            'file_path' => $filePath,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'media_type' => $request->media_type,
            'description' => $request->description,
            'is_public' => $request->has('is_public'),
        ]);

        return redirect()->route('media.index')
            ->with('success', 'Media file uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Media $media): View
    {
        return view('media.show', compact('media'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Media $media): View
    {
        return view('media.edit', compact('media'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Media $media): RedirectResponse
    {
        $request->validate([
            'media_type' => 'required|in:image,video,document',
            'description' => 'nullable|string',
            'is_public' => 'boolean',
        ]);

        $media->update([
            'media_type' => $request->media_type,
            'description' => $request->description,
            'is_public' => $request->has('is_public'),
        ]);

        return redirect()->route('media.index')
            ->with('success', 'Media file updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media): RedirectResponse
    {
        // Delete the file from storage
        Storage::disk('public')->delete($media->file_path);
        
        // Delete the record from database
        $media->delete();

        return redirect()->route('media.index')
            ->with('success', 'Media file deleted successfully.');
    }
}
