<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\DepartmentRepository;
use App\Model\Department;
use App\Validators\DepartmentValidator;

/**
 * Class DepartmentRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DepartmentRepositoryEloquent extends BaseRepository implements DepartmentRepository
{
    public $htmlSelection='';
    protected $fieldSearchable = [
        'tenphongban'=>'like',
        'tenchucvu'=>'like',
        'employees.ten'=>'like'
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Department::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return DepartmentValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getInforChildDepartment($child_department_id){
        return $this->findWhere(['id'=>$child_department_id])->first();

    }
    public function findDepartment($department_id){
        return $this->findWhere(['parent_id'=>$department_id])->all();
    }
//    public function destroyDepartment($department_id){
//        return $this->whereHas('employeedepartment',function($sql) use($department_id){
//            return $sql->where('employeedepartment.department_id',$department_id);
//        })->all();
//    }
    public function destroyDepartment($department_id){
        return \DB::table('employeedepartment')->where("department_id",$department_id)->delete();
    }

    public function recursiveDepartment($parentId, $id=0, $text=''){
        foreach ($this->makeModel()->all() as $department) {
            if ($department["parent_id"] === $id) {
                if(!empty($parentId) && $parentId == $department['id']){
                    $this->htmlSelection .= "<option selected value='" . $department['id'] . "'>" . $text . $department['tenphongban'] . "</option>";
                }
                else {
                    $this->htmlSelection .= "<option value='" . $department['id'] . "'>" . $text . $department['tenphongban'] . "</option>";
                }
                $this->recursiveDepartment($parentId,$department["id"], $text . '-');
            }

        }
        return $this->htmlSelection;
    }
}
