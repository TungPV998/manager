<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface DepartmentRepository.
 *
 * @package namespace App\Repositories;
 */
interface DepartmentRepository extends RepositoryInterface
{
    public function getInforChildDepartment($child_department_id);
    public function findDepartment($department_id);
    public function destroyDepartment($department_id);
    public function recursiveDepartment(int $department_id,int $id,string $text);
}
