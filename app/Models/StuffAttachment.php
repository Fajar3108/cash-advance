<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StuffAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'cash_advance_id',
        'path',
        'type',
    ];

    public function stuff(): BelongsTo
    {
        return $this->belongsTo(Stuff::class);
    }
}
