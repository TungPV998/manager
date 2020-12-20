<?php

use Illuminate\Support\Facades\Route;

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
    Route::get('index', [\App\Http\Controllers\EmployeesController::class, 'index'])->name('employee.index');
    Route::get('show/{id}', [\App\Http\Controllers\EmployeesController::class, 'show'])->name('employee.show');
    Route::post('store/employee', [\App\Http\Controllers\EmployeesController::class, 'store'])->name('employee.store');
    Route::post('update/employee/{id}', [\App\Http\Controllers\EmployeesController::class, 'update'])->name('employee.update');
    Route::get('showFormAdd', [\App\Http\Controllers\EmployeesController::class, 'displayFormAdd'])->name('displayFormAdd');
    Route::get('destroy-employee/{id}', [\App\Http\Controllers\EmployeesController::class, 'destroy'])->name('employee.destroy');
});

Route::prefix('department')->group(function () {
    Route::get('index', [\App\Http\Controllers\DepartmentsController::class, 'index'])->name('department.index');
    Route::post('toggle-employee/{id}', [\App\Http\Controllers\DepartmentsController::class, 'toggleEmployeeMappingDepartment'])->name('toggleEmployeeMappingDepartment');
   // Route::get('detail/{id}', [\App\Http\Controllers\DepartmentsController::class, 'showChildDepartment'])->name('detailDepartment');
    Route::get('get-list-employee/{department_id}', [\App\Http\Controllers\DepartmentsController::class, 'getListEmployee'])->name('getListEmployee');
    Route::post('store', [\App\Http\Controllers\DepartmentsController::class, 'store'])->name('department.store');
    Route::post('update/{id}', [\App\Http\Controllers\DepartmentsController::class, 'update'])->name('department.update');
    Route::get('destroy-department/{id}/', [\App\Http\Controllers\DepartmentsController::class, 'destroy'])->name('department.destroy');
    Route::get('edit/{id}', [\App\Http\Controllers\DepartmentsController::class, 'edit'])->name('department.edit');
});
