<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordReset extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'reset_token',
        'expires_at',
        'used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
        'created_at' => 'datetime',
    ];

    /**
     * Get the user that owns the password reset.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
