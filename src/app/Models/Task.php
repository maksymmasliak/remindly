<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'due_at',
        'is_completed',
    ];
    protected $casts = [
        'due_at' => 'datetime',
        'reminder_sent_at' => 'datetime',
        'is_completed' => 'boolean',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
