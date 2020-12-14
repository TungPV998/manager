<?php

namespace App\Repositories;

use phpDocumentor\Reflection\Types\Void_;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface EmployeeRepository.
 *
 * @package namespace App\Repositories;
 */
interface EmployeeRepository extends RepositoryInterface
{
    /**
     * @param $id
     */
    public function listEmployees($id);

    /**
     * @param $employee_id
     */
    public function showInforEmployee($employee_id);

}
