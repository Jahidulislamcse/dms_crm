<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
        'client_id',
        'lead_id',
        'created_by',
        'client_name',
        'agenda',
        'date',
        'time',
        'duration',
        'location',
        'status',
        'outcome',
        'next_action',
        'next_followup',
    ];

    protected $casts = [
        'date' => 'date',
        'next_followup' => 'date',
        'duration' => 'integer',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'meeting_attendees');
    }
}
