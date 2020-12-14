<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('EmployeeDepartment', function (Blueprint $table) {

            $table->integer('department_id')->unsigned();

            $table->integer('employee_id')->unsigned();

            $table->foreign('department_id')->references('id')->on('departments')

                ->onDelete('cascade');

            $table->foreign('employee_id')->references('id')->on('employees')

                ->onDelete('cascade');
            $table->integer("position_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('EmployeeDepartment');
    }
}
