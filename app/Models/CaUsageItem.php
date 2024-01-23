<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaUsageItem extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'ca_usage_id',
        'date',
        'note',
        'type',
        'amount',
    ];

    public function caUsage(): BelongsTo
    {
        return $this->belongsTo(CaUsage::class);
    }
}
