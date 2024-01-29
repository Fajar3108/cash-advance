<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StuffItem extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['note', 'name', 'quantity'];

    public function stuff(): BelongsTo
    {
        return $this->belongsTo(Stuff::class);
    }
}
