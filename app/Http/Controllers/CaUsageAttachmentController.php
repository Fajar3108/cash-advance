<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaUsageAttachmentRequest;
use App\Models\CaUsage;
use App\Models\CaUsageAttachment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class CaUsageAttachmentController extends Controller
{
    public function index(CaUsage $caUsage)
    {
        return view('ca-usage-attachment.index', compact('caUsage'));
    }

    public function store(CaUsage $caUsage, CaUsageAttachmentRequest $request)
    {
        $path = $request->file('attachment')->store('ca-usage-attachments', [
            'disk' => 'public',
        ]);

        $caUsage->attachments()->create([
            'path' => $path,
            'type' => $request->file('attachment')->getClientOriginalExtension(),
        ]);

        Alert::success('Success', 'Attachment uploaded successfully');

        return back();
    }

    public function destroy(CaUsageAttachment $caUsageAttachment): RedirectResponse
    {
        Storage::disk('public')->delete($caUsageAttachment->path);
        $caUsageAttachment->delete();

        Alert::success('Success', 'Attachment deleted successfully');

        return back();
    }
}
