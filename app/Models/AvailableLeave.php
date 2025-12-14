<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AvailableLeave extends Model
{
    protected $fillable = [
        'user_id',
        'leave_type',
        'total_requests',
        'submitted_requests',
        'remaining_requests',
        'year',
    ];

    /**
     * Get the user that owns the available leave.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
