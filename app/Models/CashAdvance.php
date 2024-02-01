<?php

namespace App\Models;

use App\Constants\StatusConstant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CashAdvance extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'date',
        'status',
        'user_id',
        'admin_id',
        'is_user_signature_showed',
        'is_admin_signature_showed',
        'note',
    ];

    public function isApproved(): Attribute
    {
        return Attribute::make(
          get: fn ($value, $attribute) => $attribute['status'] === StatusConstant::APPROVED,
        );
    }

    public function isDraft(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attribute) => $attribute['status'] === StatusConstant::DRAFT,
        );
    }

    public function isPending(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attribute) => $attribute['status'] === StatusConstant::PENDING,
        );
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }
}
