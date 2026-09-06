<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomStatus extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'color',
        'order',
        'is_default',
        'core_status',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'order' => 'integer',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
