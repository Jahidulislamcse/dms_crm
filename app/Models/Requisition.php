<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    protected $fillable = [
        'lead_id',
        'submitted_by',
        'reviewed_by',
        'assigned_smm',
        'converted_client_id',
        'client_name',
        'company',
        'phone',
        'email',
        'location',
        'total_value',
        'advance_paid',
        'billing_cycle',
        'status',
        'special_notes',
        'admin_notes',
        'reviewed_at',
    ];

    protected $casts = [
        'total_value' => 'decimal:2',
        'advance_paid' => 'decimal:2',
        'reviewed_at' => 'datetime',
    ];

    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function assignedSmm()
    {
        return $this->belongsTo(User::class, 'assigned_smm');
    }

    public function convertedClient()
    {
        return $this->belongsTo(Client::class, 'converted_client_id');
    }

    public function items()
    {
        return $this->hasMany(RequisitionItem::class);
    }

    public function team()
    {
        return $this->belongsToMany(User::class, 'requisition_team');
    }
}
