<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CaUsageAttachmentRequest;
use App\Models\CaUsage;
use RealRashid\SweetAlert\Facades\Alert;

class CaUssageAttachmentController extends Controller
{
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

        return response()->json([
            'message' => 'Attachment uploaded successfully',
        ]);
    }
}
