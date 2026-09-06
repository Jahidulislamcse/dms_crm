<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetItem extends Model
{
    protected $fillable = [
        'target_id',
        'service_name',
        'qty',
        'unit_price',
    ];

    protected $casts = [
        'qty' => 'integer',
        'unit_price' => 'decimal:2',
    ];

    public function target()
    {
        return $this->belongsTo(Target::class);
    }
}
