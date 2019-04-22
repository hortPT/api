<?php

declare(strict_types=1);

namespace VOSTPT\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ProCivOccurrence extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'prociv_occurrences';

    /**
     * {@inheritDoc}
     */
    protected $casts = [
        'aerial_assets_involved'     => 'int',
        'aerial_operatives_involved' => 'int',
        'ground_assets_involved'     => 'int',
        'ground_operatives_involved' => 'int',
    ];

    /**
     * Associated occurrence.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function occurrence(): MorphOne
    {
        return $this->morphOne(Occurrence::class, 'source');
    }

    /**
     * Associated Type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(ProCivOccurrenceType::class, 'type_id');
    }

    /**
     * Associated Status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(ProCivOccurrenceStatus::class, 'status_id');
    }

    /**
     * Associated logs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs(): HasMany
    {
        return $this->hasMany(ProCivOccurrenceLog::class);
    }

    /**
     * Stalled query scope.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStalled(Builder $query): Builder
    {
        // A ProCivOccurrence is considered stalled, when the state isn't
        // set to closed and the last update was at least 1h ago
        return $query->whereHas('status', function ($query) {
            $query->whereNotIn('code', [
                ProCivOccurrenceStatus::CLOSED,
                ProCivOccurrenceStatus::CLOSED_BY_VOST,
            ]);
        })
        ->where('updated_at', '<=', Carbon::now()->subHour());
    }
}
