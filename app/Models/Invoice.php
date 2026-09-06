<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'client_id',
        'created_by',
        'subtotal',
        'advance_paid',
        'total',
        'balance',
        'status',
        'notes',
        'issued_date',
        'due_date',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'advance_paid' => 'decimal:2',
        'total' => 'decimal:2',
        'balance' => 'decimal:2',
        'issued_date' => 'date',
        'due_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }
}
