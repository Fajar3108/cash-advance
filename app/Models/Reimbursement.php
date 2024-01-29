<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function code(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attribute) => str($attribute['no'])->padLeft(3, '0') . '/RE/IT/' . Carbon::parse($attribute['created_at'])->format('Y'),
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ReimbursementItem::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ReimbursementAttachment::class);
    }
}
