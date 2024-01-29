<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachmentRequest;
use App\Models\Stuff;
use App\Models\StuffAttachment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class StuffAttachmentController extends Controller
{
    public function index(Stuff $stuff): View
    {
        return view('stuff-attachment.index', compact('stuff'));
    }

    public function store(stuff $stuff, AttachmentRequest $request): RedirectResponse
    {
        $path = $request->file('attachment')->store('stuff-attachments', [
            'disk' => 'public',
        ]);

        $stuff->attachments()->create([
            'path' => $path,
            'type' => $request->file('attachment')->getClientOriginalExtension(),
        ]);

        Alert::success('Success', 'Attachment uploaded successfully');

        return back();
    }

    public function destroy(StuffAttachment $stuffAttachment): RedirectResponse
    {
        Storage::disk('public')->delete($stuffAttachment->path);
        $stuffAttachment->delete();

        Alert::success('Success', 'Attachment deleted successfully');

        return back();
    }
}
