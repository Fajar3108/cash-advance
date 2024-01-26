<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reimbursement extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'admin_id',
        'date',
        'note',
        'is_approved',
        'is_user_signature_showed',
        'is_admin_signature_showed',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_user_signature_showed' => 'boolean',
        'is_admin_signature_showed' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
