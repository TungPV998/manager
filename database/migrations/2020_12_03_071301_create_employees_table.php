<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateEmployeesTable.
 */
class CreateEmployeesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employees', function(Blueprint $table) {
            $table->increments('id');
            $table->string("ten")->nullable();
            $table->string("diachi")->nullable();
            $table->string("sodienthoai")->nullable();
            $table->string("gioitinh")->nullable();
            $table->integer('macv')->unsigned();
//            $table->foreign('macv')
//                ->references('id')
//                ->on('positions')
//                ->onDelete('cascade');
            $table->string("img")->nullable();
            $table->decimal("luongcoban")->nullable();
            $table->date("ngaybatdau")->nullable();
            $table->date("ngayketthuc")->nullable();
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
		Schema::drop('employees');
	}
}
