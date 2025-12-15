<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Disaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'img',
        'description',
        'collected_amount',
        'target_amount',
        'start_date',
        'end_date',
        'status',
    ];

     protected $casts = [
         'target_amount'    => 'integer',
        'collected_amount' => 'integer',
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    // Route model binding pakai slug
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function links(): HasMany
    {
        return $this->hasMany(DisasterLink::class);
    }

    protected $cast = [
        'target_amount' => 'integer',
        'collected_amount' => 'integer',
    ];

    protected $appends = ['progress'];

    public function getProgressAttribute(): int
    {
        $target = (int) $this->target_amount;

        if ($target <= 0) {
            return 0;
        }

        $collected = (int) $this->collected_amount;
        return (int) min(100, round(($collected / $target) * 100));
    }
}
