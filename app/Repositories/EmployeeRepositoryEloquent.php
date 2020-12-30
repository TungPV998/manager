<?php

namespace App\Repositories;

use App\Criteria\EmployeeRequestCriteria;
use App\Model\Department;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EmployeeRepository;
use App\Model\Employee;
use App\Validators\EmployeeValidator;

/**
 * Class EmployeeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EmployeeRepositoryEloquent extends BaseRepository implements EmployeeRepository
{
    protected $fieldSearchable = [
        'ten'=>'like',
        'diachi'=>'like',
        'position.tenchucvu'=>'like',
        'departments.id'=>'=',

    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Employee::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return EmployeeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function showInforEmployee($employee_id){
        return $this->with('positions')
            ->whereHas("departments",function ($sql) use($employee_id){
           return $sql->where("employees.id",$employee_id);
        })->first();
    }


    public function getListEmployee(){
        return $this->with(['positions','departments'])->paginate();
    }
    public function getEmployeeInDepartment($id_department){
        return  $this
            ->whereHas('departments',function ($sql) use ($id_department){
                return $sql->where("departments.id",$id_department);
            })->all();
    }
    public function getlistEmployeeIsActiveOrNot($id_department){
        return $this->with(["employeedepartment"=>function($sql) use($id_department){
            $sql->where('employeedepartment.department_id',$id_department);
        }])->paginate();
    }


}
