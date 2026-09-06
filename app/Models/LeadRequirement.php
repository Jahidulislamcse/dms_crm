<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadRequirement extends Model
{
    protected $fillable = [
        'lead_id',
        'service_name',
        'qty',
        'unit_price',
        'notes',
    ];

    protected $casts = [
        'qty' => 'integer',
        'unit_price' => 'decimal:2',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
