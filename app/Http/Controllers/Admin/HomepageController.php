<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\HomeAmenity;
use App\Models\HomeReview;
use App\Models\AboutValue;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class HomepageController extends Controller
{
    public function index()
    {
        $settings = Setting::where('group', 'LIKE', 'home_%')
            ->orWhere('group', 'contact')
            ->get()
            ->groupBy('group');
            
        $amenities = HomeAmenity::orderBy('order')->get();
        $reviews = HomeReview::orderBy('order')->get();

        return view('admin.homepage.index', compact('settings', 'amenities', 'reviews'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->except(['_token', 'redirect_tab']);

        foreach ($data as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            if (!$setting) continue;

            if ($setting->type === 'image' && $request->hasFile($key)) {
                $this->deleteOldImage($setting->value);
                $path = $this->uploadImage($request->file($key), 'images/site');
                $setting->update(['value' => $path]);
            } else {
                if ($setting->type !== 'image') {
                    $setting->update(['value' => $value]);
                }
            }
        }

        return back()->with('success', 'Content Updated Successfully');
    }

    // Home Amenities CRUD
    public function storeAmenity(Request $request)
    {
        $request->validate(['title' => 'required', 'image' => 'required|image']);
        
        $path = $this->uploadImage($request->file('image'), 'images/experiences');
        
        HomeAmenity::create([
            'title' => $request->title,
            'image' => $path,
            'order' => HomeAmenity::max('order') + 1,
            'status' => true
        ]);

        return back()->with('success', 'Amenity Added Successfully');
    }

    public function updateAmenity(Request $request, HomeAmenity $amenity)
    {
        $request->validate(['title' => 'required']);
        
        $data = ['title' => $request->title];
        
        if ($request->hasFile('image')) {
            $this->deleteOldImage($amenity->image);
            $data['image'] = $this->uploadImage($request->file('image'), 'images/experiences');
        }

        $amenity->update($data);
        return back()->with('success', 'Amenity Updated Successfully');
    }

    public function deleteAmenity(HomeAmenity $amenity)
    {
        $this->deleteOldImage($amenity->image);
        $amenity->delete();
        return back()->with('success', 'Amenity Deleted Successfully');
    }

    // Home Reviews CRUD
    public function storeReview(Request $request)
    {
        $request->validate(['name' => 'required', 'text' => 'required']);
        
        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'images/reviews');
        }
        
        HomeReview::create($data);
        return back()->with('success', 'Review Added Successfully');
    }

    public function updateReview(Request $request, HomeReview $review)
    {
        $request->validate(['name' => 'required', 'text' => 'required']);
        
        $data = $request->all();
        if ($request->hasFile('image')) {
            $this->deleteOldImage($review->image);
            $data['image'] = $this->uploadImage($request->file('image'), 'images/reviews');
        }

        $review->update($data);
        return back()->with('success', 'Review Updated Successfully');
    }

    public function deleteReview(HomeReview $review)
    {
        $this->deleteOldImage($review->image);
        $review->delete();
        return back()->with('success', 'Review Deleted Successfully');
    }

    public function updateOrder(Request $request)
    {
        $type = $request->type;
        $order = $request->order; // Array of IDs

        if ($type === 'amenity') {
            foreach ($order as $index => $id) {
                HomeAmenity::where('id', $id)->update(['order' => $index]);
            }
        } elseif ($type === 'review') {
            foreach ($order as $index => $id) {
                HomeReview::where('id', $id)->update(['order' => $index]);
            }
        }

        return response()->json(['success' => true]);
    }

    private function uploadImage($file, $folder)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = public_path($folder);
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
        $file->move($path, $filename);
        return $folder . '/' . $filename;
    }

    private function deleteOldImage($path)
    {
        if ($path && !str_starts_with($path, 'http')) {
            $fullPath = public_path($path);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }
    }
}
