<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Model\Position;

/**
 * Class PositionTransformer.
 *
 * @package namespace App\Transformers;
 */
class PositionTransformer extends TransformerAbstract
{
    /**
     * Transform the Position entity.
     *
     * @param \App\Model\Position $model
     *
     * @return array
     */
    public function transform(Position $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
