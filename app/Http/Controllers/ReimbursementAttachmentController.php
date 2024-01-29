<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachmentRequest;
use App\Models\Reimbursement;
use App\Models\ReimbursementAttachment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class ReimbursementAttachmentController extends Controller
{
    public function index(Reimbursement $reimbursement): View
    {
        return view('reimbursement-attachment.index', compact('reimbursement'));
    }

    public function store(Reimbursement $reimbursement, AttachmentRequest $request): RedirectResponse
    {
        $path = $request->file('attachment')->store('reimbursement-attachments', [
            'disk' => 'public',
        ]);

        $reimbursement->attachments()->create([
            'path' => $path,
            'type' => $request->file('attachment')->getClientOriginalExtension(),
        ]);

        Alert::success('Success', 'Attachment uploaded successfully');

        return back();
    }

    public function destroy(ReimbursementAttachment $reimbursementAttachment): RedirectResponse
    {
        Storage::disk('public')->delete($reimbursementAttachment->path);
        $reimbursementAttachment->delete();

        Alert::success('Success', 'Attachment deleted successfully');

        return back();
    }
}
