<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MyWorkItem extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'category',
        'priority',
        'status',
        'due_date',
        'notes',
        'completed_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
