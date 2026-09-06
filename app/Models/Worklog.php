<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Worklog extends Model
{
    protected $fillable = [
        'user_id',
        'client_id',
        'task_id',
        'title',
        'description',
        'qty_done',
        'qty_total',
        'quality_rating',
        'smm_feedback',
        'status',
        'date',
        'reviewed_by',
    ];

    protected $casts = [
        'date' => 'date',
        'qty_done' => 'integer',
        'qty_total' => 'integer',
        'quality_rating' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
