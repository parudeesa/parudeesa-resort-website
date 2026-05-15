<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventInquiry;
use Illuminate\Http\Request;

class EventInquiryController extends Controller
{
    public function index()
    {
        $inquiries = EventInquiry::latest()->paginate(15);
        return view('admin.events.index', compact('inquiries'));
    }

    public function show($id)
    {
        $inquiry = EventInquiry::findOrFail($id);
        return view('admin.events.show', compact('inquiry'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,responded,confirmed,cancelled'
        ]);

        $inquiry = EventInquiry::findOrFail($id);
        $inquiry->update(['status' => $request->status]);

        return back()->with('success', 'Inquiry status updated successfully.');
    }

    public function destroy($id)
    {
        $inquiry = EventInquiry::findOrFail($id);
        $inquiry->delete();

        return redirect()->route('admin.events.index')->with('success', 'Inquiry deleted successfully.');
    }
}
