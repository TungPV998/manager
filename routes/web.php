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
    Route::get('index', [\App\Http\Controllers\EmployeesController::class, 'index'])->name('index');
    Route::get('show/{id}/{parent_id}', [\App\Http\Controllers\EmployeesController::class, 'show'])->name('employee.show');
    Route::post('store/employee', [\App\Http\Controllers\EmployeesController::class, 'store'])->name('employee.store');
    Route::post('update/employee/{id}', [\App\Http\Controllers\EmployeesController::class, 'update'])->name('employee.update');
    Route::get('showFormAdd/{id}', [\App\Http\Controllers\EmployeesController::class, 'displayFormAdd'])->name('displayFormAdd');
    Route::get('destroy-employee/{id}/{childDepartment_id}', [\App\Http\Controllers\EmployeesController::class, 'destroy'])->name('employee.destroy');
});

Route::prefix('department')->group(function () {
    Route::get('index', [\App\Http\Controllers\DepartmentsController::class, 'index'])->name('index');
    Route::get('show/detail/employee/{id}/{id_department_child}', [\App\Http\Controllers\DepartmentsController::class, 'showEmployee'])->name('showEmployee');
   // Route::get('show/detail/employee/{id}/{id_department_child}', [\App\Http\Controllers\DepartmentsController::class, 'showEmployee'])->name('showEmployee');
    Route::get('detail/{id}', [\App\Http\Controllers\DepartmentsController::class, 'showChildDepartment'])->name('detailDepartment');
    Route::delete('delete/{id}', [\App\Http\Controllers\DepartmentsController::class, 'destroy'])->name('deleteDepartment');
    Route::post('store', [\App\Http\Controllers\DepartmentsController::class, 'store'])->name('store');
    Route::post('store/child/{parent_id}', [\App\Http\Controllers\DepartmentsController::class, 'storeChildDepartment'])->name('child.store');
    Route::post('update/{id}/{parent_id}', [\App\Http\Controllers\DepartmentsController::class, 'update'])->name('update');
    Route::delete('destroy-department/{id}/', [\App\Http\Controllers\DepartmentsController::class, 'destroy'])->name('destroy');
});
