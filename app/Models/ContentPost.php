<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentPost extends Model
{
    protected $fillable = [
        'title',
        'client_id',
        'assigned_to',
        'created_by',
        'platform',
        'post_type',
        'date',
        'status',
        'notes',
        'brief',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
