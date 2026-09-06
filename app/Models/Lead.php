<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'company',
        'location',
        'source',
        'stage_id',
        'assigned_to',
        'created_by',
        'budget',
        'notes',
        'next_followup',
        'converted_client_id',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'next_followup' => 'date',
    ];

    public function stage()
    {
        return $this->belongsTo(LeadStage::class, 'stage_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function convertedClient()
    {
        return $this->belongsTo(Client::class, 'converted_client_id');
    }

    public function requirements()
    {
        return $this->hasMany(LeadRequirement::class);
    }

    public function timelines()
    {
        return $this->hasMany(LeadTimeline::class);
    }
}
