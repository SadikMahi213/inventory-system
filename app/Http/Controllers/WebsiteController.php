<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WebsiteController extends Controller
{
    /**
     * Display the registration form on the homepage
     *
     * @return View
     */
    public function index(): View
    {
        return view('home-register');
    }

    /**
     * Display the media gallery page
     *
     * @return View
     */
    public function media(): View
    {
        $mediaItems = Media::orderBy('created_at', 'desc')
            ->paginate(12);

        return view('website.media', compact('mediaItems'));
    }

    /**
     * Display the contact page with Google Maps
     *
     * @return View
     */
    public function contact(): View
    {
        return view('website.contact');
    }

    /**
     * Handle media upload
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadMedia(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'media' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:10240', // 10MB max
        ]);

        $media = new Media();
        $media->title = $request->title;
        $media->description = $request->description;
        
        // Handle file upload
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('media', $filename, 'public');
            
            $media->file_path = $filePath;
            $media->file_type = $file->getClientMimeType();
            $media->file_size = $file->getSize();
        }

        $media->save();

        return redirect()->back()->with('success', 'Media uploaded successfully!');
    }
}