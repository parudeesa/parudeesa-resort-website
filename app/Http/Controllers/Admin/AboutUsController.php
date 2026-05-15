<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\AboutValue;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutValues = AboutValue::orderBy('order')->get();
        $teamMembers = TeamMember::orderBy('order')->get();
        
        return view('admin.about.index', compact('aboutValues', 'teamMembers'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->validate([
            'home_about_title' => 'nullable|string',
            'home_about_desc_1' => 'nullable|string',
            'home_about_desc_2' => 'nullable|string',
            'home_about_badge_number' => 'nullable|string',
            'home_about_badge_text' => 'nullable|string',
            'about_mission' => 'nullable|string',
            'about_vision' => 'nullable|string',
            'about_cta_title' => 'nullable|string',
            'about_cta_desc' => 'nullable|string',
            'about_hero_title' => 'nullable|string',
            'about_hero_subtitle' => 'nullable|string',
            'about_contact_title' => 'nullable|string',
            'about_contact_desc' => 'nullable|string',
            'about_contact_phone' => 'nullable|string',
            'about_contact_email' => 'nullable|string',
            'about_contact_address' => 'nullable|string',
        ]);

        if ($request->hasFile('home_about_image')) {
            $path = $request->file('home_about_image')->store('about', 'public');
            Setting::set('home_about_image', $path);
        }

        if ($request->hasFile('about_hero_image')) {
            $path = $request->file('about_hero_image')->store('about', 'public');
            Setting::set('about_hero_image', $path);
        }

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'About Us settings updated successfully.');
    }

    // Values Management
    public function storeAboutValue(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'icon' => 'nullable|string',
        ]);

        $data['order'] = AboutValue::max('order') + 1;
        AboutValue::create($data);

        return back()->with('success', 'Value added successfully.');
    }

    public function updateAboutValue(Request $request, AboutValue $value)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'icon' => 'nullable|string',
        ]);

        $value->update($data);

        return back()->with('success', 'Value updated successfully.');
    }

    public function deleteAboutValue(AboutValue $value)
    {
        $value->delete();
        return back()->with('success', 'Value deleted successfully.');
    }

    // Team Management
    public function storeTeamMember(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'role' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('team', 'public');
        }

        $data['order'] = TeamMember::max('order') + 1;
        TeamMember::create($data);

        return back()->with('success', 'Team member added successfully.');
    }

    public function updateTeamMember(Request $request, TeamMember $member)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'role' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($member->image) {
                Storage::disk('public')->delete($member->image);
            }
            $data['image'] = $request->file('image')->store('team', 'public');
        }

        $member->update($data);

        return back()->with('success', 'Team member updated successfully.');
    }

    public function deleteTeamMember(TeamMember $member)
    {
        if ($member->image) {
            Storage::disk('public')->delete($member->image);
        }
        $member->delete();
        return back()->with('success', 'Team member deleted successfully.');
    }

    public function updateOrder(Request $request)
    {
        $type = $request->type;
        $order = $request->order;

        if ($type === 'value') {
            foreach ($order as $index => $id) {
                AboutValue::where('id', $id)->update(['order' => $index]);
            }
        } elseif ($type === 'team') {
            foreach ($order as $index => $id) {
                TeamMember::where('id', $id)->update(['order' => $index]);
            }
        }

        return response()->json(['success' => true]);
    }
}
