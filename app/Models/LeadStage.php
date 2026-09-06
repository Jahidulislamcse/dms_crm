<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadStage extends Model
{
    protected $fillable = [
        'name',
        'color',
        'order',
        'is_won',
        'is_lost',
    ];

    protected $casts = [
        'is_won' => 'boolean',
        'is_lost' => 'boolean',
        'order' => 'integer',
    ];

    public function leads()
    {
        return $this->hasMany(Lead::class, 'stage_id');
    }
}
