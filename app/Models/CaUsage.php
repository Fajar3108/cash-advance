<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CaUsage extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'cash_advance_id',
        'user_id',
        'admin_id',
        'name',
        'date',
        'is_approved',
        'is_user_signature_showed',
        'is_admin_signature_showed',
        'note',
    ];

    public function cashAdvance(): BelongsTo
    {
        return $this->belongsTo(CashAdvance::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(CaUsageItem::class, 'ca_usage_id');
    }
}
