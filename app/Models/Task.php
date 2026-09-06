<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'client_id',
        'assigned_to',
        'assigned_by',
        'service_id',
        'parent_task_id',
        'custom_status_id',
        'status',
        'priority',
        'approval_status',
        'notes',
        'deadline',
        'scheduled_date',
        'estimated_hours',
        'qty',
        'recurring_enabled',
        'recurring_type',
        'recurring_interval',
        'recurring_end_date',
    ];

    protected $casts = [
        'deadline' => 'date',
        'scheduled_date' => 'date',
        'recurring_end_date' => 'date',
        'recurring_enabled' => 'boolean',
        'estimated_hours' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function parentTask()
    {
        return $this->belongsTo(Task::class, 'parent_task_id');
    }

    public function subtasks()
    {
        return $this->hasMany(Task::class, 'parent_task_id');
    }

    public function customStatus()
    {
        return $this->belongsTo(CustomStatus::class);
    }

    public function approvalComments()
    {
        return $this->hasMany(TaskApprovalComment::class);
    }

    public function progresses()
    {
        return $this->hasMany(TaskProgress::class);
    }
}
