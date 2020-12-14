<?php

namespace App\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class EmployeeRequestCriteria.
 *
 * @package namespace App\Criteria;
 */
class EmployeeRequestCriteria extends AbstractRequestCriteria
{
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
//    public function apply($model, RepositoryInterface $repository)
//    {
//        return $model;
//    }

    public function updatedAtFrom($builder, $created_at_from, $condition): Builder
    {
        if (trim($created_at_from)) {
            return $builder->where('updated_at', '>=', $created_at_from . ' 00:00:00');
        }
        return $builder;
    }

    public function updatedAtTo($builder, $created_at_from, $condition): Builder
    {
        if (trim($created_at_from)) {
            return $builder->where('updated_at', '<=', $created_at_from . ' 23:59:59');
        }
        return $builder;
    }
}
