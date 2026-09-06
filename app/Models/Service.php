<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'base_price',
        'unit',
        'description',
        'active',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'active' => 'boolean',
    ];
}
