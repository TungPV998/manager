<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\employeepositionRepository;
use App\Model\Employeeposition;
use App\Validators\EmployeepositionValidator;

/**
 * Class EmployeepositionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EmployeepositionRepositoryEloquent extends BaseRepository implements EmployeepositionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Employeeposition::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    
}
