<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::orderBy('sort_order')->get();
        return view('admin.gallery', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'media' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,wmv|max:20480',
            'type' => 'required|in:image,video',
            'layout' => 'required|in:standard,wide,tall',
            'title' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('media')) {
            $path = $request->file('media')->store('gallery', 'public');
            
            Gallery::create([
                'type' => $request->type,
                'url' => '/storage/' . $path,
                'layout' => $request->layout,
                'title' => $request->title,
                'category' => $request->category,
                'sort_order' => Gallery::count(),
            ]);

            return response()->json(['success' => true, 'message' => 'Media uploaded successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'No file uploaded.'], 400);
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'layout' => 'required|in:standard,wide,tall',
        ]);

        $gallery->update($request->only('title', 'category', 'layout'));

        return back()->with('success', 'Gallery item updated!');
    }

    public function destroy(Gallery $gallery)
    {
        // Remove file from storage
        $path = str_replace('/storage/', '', $gallery->url);
        Storage::disk('public')->delete($path);
        
        $gallery->delete();

        return response()->json(['success' => true, 'message' => 'Media deleted successfully!']);
    }

    public function reorder(Request $request)
    {
        $order = $request->order; // Array of IDs in new order
        
        foreach ($order as $index => $id) {
            Gallery::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true, 'message' => 'Order updated!']);
    }
}
