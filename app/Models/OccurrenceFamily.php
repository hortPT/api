<?php

declare(strict_types=1);

namespace VOSTPT\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use LengthException;

class OccurrenceFamily extends Model
{
    use Concerns\Cacheable;

    /**
     * {@inheritDoc}
     */
    protected $table = 'occurrence_families';

    /**
     * Associated Species.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function species(): HasMany
    {
        return $this->hasMany(OccurrenceSpecies::class);
    }

    /**
     * Set the name.
     *
     * @param string $name
     *
     * @throws \LengthException
     *
     * @return void
     */
    public function setNameAttribute(string $name): void
    {
        if (\mb_strlen($name) > 255) {
            throw new LengthException('The name cannot exceed 255 characters');
        }

        $this->attributes['name'] = $name;
    }
}
