<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'icon',
        'bg_color',
        'message',
        'is_admin_only',
        'is_read',
    ];

    protected $casts = [
        'is_admin_only' => 'boolean',
        'is_read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
