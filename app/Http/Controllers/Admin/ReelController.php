<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Reel;
use Illuminate\Support\Facades\Storage;

class ReelController extends Controller
{
    public function index()
    {
        $reels = Reel::orderBy('order')->get();
        return view('admin.reels.index', compact('reels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'instagram_url' => 'required|url',
            'thumbnail' => 'nullable|image|max:2048',
            'video' => 'nullable|mimes:mp4,mov,ogg,webm|max:20480', // 20MB max
        ]);

        $data = $request->except(['thumbnail', 'video']);
        
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('reels/thumbs', 'public');
        }

        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('reels/videos', 'public');
        }

        Reel::create($data);

        return back()->with('success', 'Reel added successfully.');
    }

    public function update(Request $request, Reel $reel)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'instagram_url' => 'required|url',
            'thumbnail' => 'nullable|image|max:2048',
            'video' => 'nullable|mimes:mp4,mov,ogg,webm|max:20480',
        ]);

        $data = $request->except(['thumbnail', 'video']);

        if ($request->hasFile('thumbnail')) {
            if ($reel->thumbnail) Storage::disk('public')->delete($reel->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('reels/thumbs', 'public');
        }

        if ($request->hasFile('video')) {
            if ($reel->video) Storage::disk('public')->delete($reel->video);
            $data['video'] = $request->file('video')->store('reels/videos', 'public');
        }

        $reel->update($data);

        return back()->with('success', 'Reel updated successfully.');
    }

    public function destroy(Reel $reel)
    {
        if ($reel->thumbnail) Storage::disk('public')->delete($reel->thumbnail);
        if ($reel->video) Storage::disk('public')->delete($reel->video);
        $reel->delete();
        return back()->with('success', 'Reel deleted successfully.');
    }

    public function updateOrder(Request $request)
    {
        foreach ($request->order as $item) {
            Reel::where('id', $item['id'])->update(['order' => $item['order']]);
        }
        return response()->json(['success' => true]);
    }
}
