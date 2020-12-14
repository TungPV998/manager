<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class DepartmentRequestCriteria.
 *
 * @package namespace App\Criteria;
 */
class DepartmentRequestCriteria implements CriteriaInterface
{
    //protected $id_department;

//    public function __construct($id_department)
//    {
//        $this->id_department = $id_department;
//    }

    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     *
     */
//    public function apply($model, RepositoryInterface $repository)
//    {
//        $model = $model->with('positions')
//        ->whereHas('departments',function($sql){
//            return $sql->where('departments.id',$this->id_department);
//        })->get();
//        return $model;
//    }
    public function apply($model, RepositoryInterface $repository)
    {
        return $model;
    }
}
