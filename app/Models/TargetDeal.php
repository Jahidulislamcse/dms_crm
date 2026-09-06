<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetDeal extends Model
{
    protected $fillable = [
        'target_id',
        'target_item_id',
        'client_id',
        'service_name',
        'qty',
        'amount',
        'date',
    ];

    protected $casts = [
        'qty' => 'integer',
        'amount' => 'decimal:2',
        'date' => 'date',
    ];

    public function target()
    {
        return $this->belongsTo(Target::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
