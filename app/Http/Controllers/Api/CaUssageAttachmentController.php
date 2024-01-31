<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CaUsageAttachmentRequest;
use App\Models\CaUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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

        return response()->json([
            'message' => 'Attachment uploaded successfully',
        ]);
    }

    public function storeBase64(CaUsage $caUsage, Request $request)
    {
        $request->validate([
            'attachment' => 'required|string',
        ]);

        $base64Decoded = base64_decode($request->attachment);

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_buffer($finfo, $base64Decoded);
        finfo_close($finfo);

        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'application/pdf' => 'pdf',
        ];

        $filename = 'uploaded_file_' . time() . '.' . $mime;

        // Default extension if mime type is not found
        $defaultExtension = 'dat';

        // Get extension based on mime type or use the default
        $extension = $extensions[$mime] ?? $defaultExtension;

        if ($extension === 'dat') {
            return response()->json([
                'message' => 'Invalid file type',
            ], 422);
        }

        $filename = 'ca-usage-attachment-' . time() . '.' . $extension;

        Storage::put('public/ca-usage-attachments/' . $filename, $base64Decoded);

        $caUsage->attachments()->create([
            'path' => 'ca-usage-attachments/' . $filename,
            'type' => $mime,
        ]);

        return response()->json([
            'message' => 'Attachment uploaded successfully',
        ]);
    }
}
