<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Employee.
 *
 * @package namespace App\Model;
 */
class Employee extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $table = "employees";

    public function departments(){
        return $this->belongsToMany(Department::class,"employeedepartment","employee_id","department_id")->using(EmplyeeDepartment::class)->withPivot('position_id');
    }
    public function positions(){
        return $this->belongsToMany(Position::class,'employee_position','position_id','employee_id')->using(Employeeposition::class);
    }
}
