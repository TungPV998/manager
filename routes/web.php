<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\DepartmentsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('child_department.index');
});
Route::get('/nhanvien', function () {
    return view('employees.index');
});
Route::get('/department', function () {
    return view('department.index');
});
Route::prefix('employees')->group(function () {
    Route::get('index', [EmployeesController::class, 'index'])->name('employee.index');
    Route::get('show/{id}', [EmployeesController::class, 'show'])->name('employee.show');
    Route::post('store/employee', [EmployeesController::class, 'store'])->name('employee.store');
    Route::post('update/employee/{id}', [EmployeesController::class, 'update'])->name('employee.update');
    Route::get('showFormAdd', [EmployeesController::class, 'displayFormAdd'])->name('displayFormAdd');
    Route::get('destroy-employee/{id}', [EmployeesController::class, 'destroy'])->name('employee.destroy');
});

Route::prefix('department')->group(function () {
    Route::get('index', [DepartmentsController::class, 'index'])->name('department.index');
    Route::get('loadAll/{id}', [DepartmentsController::class, 'loadAll'])->name('department.loadAll');
    Route::get('toggle-employee/{id}', [DepartmentsController::class, 'toggleEmployeeMappingDepartment'])->name('toggleEmployeeMappingDepartment');
    Route::get('load-employee/{id}', [DepartmentsController::class, 'loadEmployeeAjax'])->name('department.loadEmployee');
    Route::get('get-list-employee/{department_id}', [DepartmentsController::class, 'getListEmployee'])->name('getListEmployee');
    Route::post('store', [DepartmentsController::class, 'store'])->name('department.store');
    Route::post('update/{id}', [DepartmentsController::class, 'update'])->name('department.update');
    Route::get('destroy-department/{id}/', [DepartmentsController::class, 'destroy'])->name('department.destroy');
    Route::get('destroy-employee/{department_id}/{employee_id}/', [DepartmentsController::class, 'destroyEmployee'])->name('department.destroyEmployee');
    Route::get('edit/{id}', [DepartmentsController::class, 'edit'])->name('department.edit');
});
