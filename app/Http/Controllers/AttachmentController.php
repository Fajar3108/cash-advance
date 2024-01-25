<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachmentRequest;
use App\Models\Attachment;
use App\Models\CashAdvance;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AttachmentController extends Controller
{
    public function index(CashAdvance $cashAdvance): View
    {
        return view('attachment.index', compact('cashAdvance'));
    }

    public function store(CashAdvance $cashAdvance, AttachmentRequest $request): RedirectResponse
    {
        $path = $request->file('attachment')->store('attachments', [
            'disk' => 'public',
        ]);

        $cashAdvance->attachments()->create([
            'path' => $path,
            'type' => $request->file('attachment')->getClientOriginalExtension(),
        ]);

        Alert::success('Success', 'Attachment uploaded successfully');

        return back();
    }

    public function destroy(Attachment $attachment): RedirectResponse
    {
        Storage::disk('public')->delete($attachment->path);
        $attachment->delete();

        Alert::success('Success', 'Attachment deleted successfully');

        return back();
    }
}
