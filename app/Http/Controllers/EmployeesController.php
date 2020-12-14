<?php

namespace App\Http\Controllers;

use App\Model\Department;
use App\Model\Employee;
use App\Model\Position;
use App\Repositories\DepartmentRepository;
use App\Repositories\PositionRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Repositories\EmployeeRepository;
use App\Validators\EmployeeValidator;

/**
 * Class EmployeesController.
 *
 * @package namespace App\Http\Controllers;
 */
class EmployeesController extends Controller
{
    /**
     * @var EmployeeRepository
     */
    protected $repository;
    protected $departmentRepository;
    protected $position;
    /**
     * @var EmployeeValidator
     */
    protected $validator;

    /**
     * EmployeesController constructor.
     *
     * @param EmployeeRepository $repository
     * @param EmployeeValidator $validator
     */
    public function __construct(DepartmentRepository $department, PositionRepository $position, DepartmentRepository $departmentRepository, EmployeeRepository $repository, EmployeeValidator $validator)
    {
        $this->position = $position;
        $this->department = $department;
        $this->repository = $repository;
        $this->validator = $validator;
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EmployeeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(Request $request)
    {
        try {
            \DB::beginTransaction();
            $data = $request->only(['ten', 'sodienthoai', 'diachi', 'gioitinh', 'macv', 'ngaybatdau', 'ngayketthuc']);
            $this->validator->with($data)->passesOrFail(EmployeeValidator::RULE_CREATE);
            $path = Storage::putFile('avatars', $request->file('imgProfile'));
            $data['img'] = $path;
            $employee = $this->repository->create($data);
            $department = $this->department->find($request->department);
            $department->employees()->attach($employee->id, ['position_id' => $request->macv]);
            \DB::commit();
            return redirect()->back()->with('message', "Thêm mới thành công");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Exception $exception) {
            \DB::rollBack();
            report($exception);
            return back()->withError($exception->getMessage())->withInput();
        }
    }

    public function displayFormAdd($id)
    {
        $departments = $this->department->where("parent_id", $id)->get();
        $positions = $this->position->all();
        return view('employees.add', compact('departments', 'positions'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id, $parent_id)
    {
        $departments = $this->department->where("parent_id", $parent_id)->get();
        $positions = $this->position->all();
        $employee = $this->repository->showInforEmployee($id);
        $dpmSelect = $this->repository->with('departments')->where("employees.id", $id)->first();
        foreach ($dpmSelect->departments as $id_child) {
            $id_child_department = $id_child;
        }
        return view('employees.update', compact('employee', 'departments', 'positions', 'id_child_department'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = $this->repository->find($id);

        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EmployeeUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(Request $request, $id)
    {
        try {
            \DB::beginTransaction();
            $data = $request->only(['ten', 'sodienthoai', 'diachi', 'gioitinh', 'macv', 'ngaybatdau', 'ngayketthuc']);
            $this->validator->with($data)->passesOrFail(EmployeeValidator::RULE_UPDATE);
            if (isset($request->imgProfile)) {
                $path = Storage::putFile('avatars', $request->imgProfile);
            } else {
                $path = $request->imgProfileOld;
            }
            $data['img'] = $path;
            $employee = $this->repository->update($data, $id);
            $employees = $this->repository->find($id);
            $employees->departments()->updateExistingPivot($request->department, ['position_id' => $request->post('macv')]);
            \DB::commit();
            return redirect()->back()->with('message', "Cập nhật thành công");
        } catch (ValidatorException $e) {

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Exception $exception) {
            \DB::rollBack();
            report($exception);
            return back()->withError(["message" => $exception->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $childDepartment_id)
    {
        try {
            \DB::beginTransaction();
            $deleted = $this->repository->delete($id);
            $department = $this->department->find($childDepartment_id);
            $department->employees()->detach($id);
            \DB::commit();
            return redirect()->back()->with('message', 'Xóa Thành Công');
        } catch (\Exception $exception) {
            \DB::rollback();
            report($exception);
            return back()->withError($exception->getMessage());
        }
    }



}
