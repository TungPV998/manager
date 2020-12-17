<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Position.
 *
 * @package namespace App\Model;
 */
class Position extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $table = "positions";

    public function employee(){
        return $this->belongsToMany(Employee::class,'employee_position','employee_id','position_id')->using(Employeeposition::class);
    }
}
