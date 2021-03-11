<?php

namespace App\Model;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Employee.
 *
 * @package namespace App\Model;
 */
class EmplyeeDepartment extends Pivot
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    protected $table = "EmployeeDepartment";


    public function position(){
        return $this->belongsTo(Position::class,"position_id","id");
    }
    public function department()
    {
        return $this->hasOne(Department::class);
    }
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
}
