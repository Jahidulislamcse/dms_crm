<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $fillable = [
        'user_id',
        'created_by',
        'month',
        'label',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(TargetItem::class);
    }

    public function deals()
    {
        return $this->hasMany(TargetDeal::class);
    }

    public function getTotalAttribute()
    {
        return $this->items->sum(fn($i) => $i->qty * $i->unit_price);
    }

    public function getAchievedAttribute()
    {
        return $this->deals->sum('amount');
    }
}
