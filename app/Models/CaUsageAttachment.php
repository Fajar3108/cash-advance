<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaUsageAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ca_usage_id',
        'path',
        'type',
    ];

    public function caUsage()
    {
        return $this->belongsTo(CaUsage::class);
    }
}
