<?php

declare(strict_types=1);

namespace VOSTPT\Http\Serializers;

use Tobscure\JsonApi\AbstractSerializer;

class ProCivOccurrenceStatusSerializer extends AbstractSerializer
{
    /**
     * {@inheritDoc}
     */
    protected $type = 'prociv_occurrence_statuses';

    /**
     * {@inheritDoc}
     */
    public function getAttributes($model, array $fields = null): array
    {
        return [
            'code'       => $model->code,
            'name'       => $model->name,
            'created_at' => $model->created_at->toDateTimeString(),
            'updated_at' => $model->updated_at->toDateTimeString(),
        ];
    }
}