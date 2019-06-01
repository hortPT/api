<?php

declare(strict_types=1);

use Faker\Generator as Faker;
use VOSTPT\Models\OccurrenceSpecies;
use VOSTPT\Models\OccurrenceType;

/*
|--------------------------------------------------------------------------
| OccurrenceType Factories
|--------------------------------------------------------------------------
|
*/

$factory->define(OccurrenceType::class, function (Faker $faker) {
    return [
        'species_id' => function () {
            return factory(OccurrenceSpecies::class)->create()->id;
        },
        'code' => $faker->unique()->numberBetween(1000, 9999),
        'name' => $faker->unique()->sentence(),
    ];
});