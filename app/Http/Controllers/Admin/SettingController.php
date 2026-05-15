<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            
            if (!$setting) continue;

            if ($setting->type === 'image' && $request->hasFile($key)) {
                // Delete old image
                if ($setting->value && !str_starts_with($setting->value, 'http')) {
                    $oldPath = public_path($setting->value);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                }

                $file = $request->file($key);
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = 'images/site';
                
                if (!File::exists(public_path($path))) {
                    File::makeDirectory(public_path($path), 0755, true);
                }

                $file->move(public_path($path), $filename);
                $setting->update(['value' => $path . '/' . $filename]);
            } else {
                if ($setting->type !== 'image') {
                    $setting->update(['value' => $value]);
                }
            }
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
