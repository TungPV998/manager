<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Department.
 *
 * @package namespace App\Model;
 */
class Department extends Model implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    protected $table="departments";

    public function employees(){
        return $this->belongsToMany(Employee::class,
            'employeedepartment','department_id',
            'employee_id')->using(EmplyeeDepartment::class)
            ->as('ed')
            ->withPivot('position_id');
    }
    public function employeedepartment()
    {
        return $this->hasMany(EmplyeeDepartment::class,'department_id');
    }
    public function childs() {
        return $this->hasMany(Department::class,'parent_id','id') ;
    }
}
