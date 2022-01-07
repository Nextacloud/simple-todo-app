<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    // Methods

    public function markAsCompleted(): self
    {
        return tap($this, function($instance) {
            $instance->completed_at = now();
            $instance->save();
        });
    }

    public function markAsIncompleted(): self
    {
        return tap($this, function($instance) {
            $instance->completed_at = null;
            $instance->save();
        });
    }


    // Scopes

    /**
     * Scope a query to only include completed tasks
     */
    public function scopeIsCompleted(Builder $query): Builder
    {
        return $query->whereNotNull('completed_at');
    }

    // Accessors

    /**
     * Get is_completed attribute, which will be true if completed_at is not null
     */
    public function getIsCompletedAttribute(): bool
    {
        return $this->completed_at !== null;
    }
}
