<?php

namespace App\Http\Controllers;

use App\Criteria\BuildDataSearchForRequest;
use App\Criteria\DepartmentRequestCriteria;
use App\Criteria\EmployeeCriteria;
use App\Criteria\EmployeeRequestCriteria;
use App\Model\EmplyeeDepartment;
use App\Repositories\EmployeeRepository;
use App\Repositories\PositionRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\DepartmentCreateRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Repositories\DepartmentRepository;
use App\Validators\DepartmentValidator;

/**
 * Class DepartmentsController.
 *
 * @package namespace App\Http\Controllers;
 */
class DepartmentsController extends Controller
{
    /**
     * @var DepartmentRepository
     */
    protected $repository;

    /**
     * @var DepartmentValidator
     */
    protected $validator;
    protected $position;
    protected $employee;
    /**
     * DepartmentsController constructor.
     *
     * @param DepartmentRepository $repository
     * @param DepartmentValidator $validator
     */
    public function __construct(DepartmentRepository $repository,
                                DepartmentValidator $validator,
                                EmployeeRepository $employee,
                                PositionRepository $position
    )
    {
        $this->position = $position;
        $this->employee = $employee;
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $departments = $this->repository->getParentCatalog();
        $htmlOption  = $this->repository->recursiveDepartment('');
        $view_data = [
            'htmlOption'=>$htmlOption,
            'departments'=>$departments,
        ];
        return view('department.index',compact('view_data','flagDepartment'));

    }

    public function loadAll($id_department){
        $view_data['childs'] = $this->repository->loadChildDepartment($id_department);
        $view_data['employees'] = $this->employee->getEmployeeInDepartment($id_department);
        $view_data['id_department'] = $id_department;
                $data = view('department.child', compact('view_data'))->render();

            return \response([
            "data" => $data,
            'status' => 200
        ]);

    }

    public function store(Request $request)
    {
        try {
            $this->validator->with($request->only('txtPhongBan'))->passesOrFail(DepartmentValidator::RULE_CREATE);
            $tenphongban = $request->post('txtPhongBan');
            $department = $this->repository->create(['tenphongban'=>$tenphongban,'parent_id'=>$request->parent_id]);
            if ($department) {
                return back()->with('message', "Them moi thanh cong");
            }
            throw new \Exception('Xảy ra lỗi khi them moi phong ban');

        } catch (ValidatorException $e) {
            return back()->withInput($request->all())->withErrors($e->getMessageBag());
        }
     catch (\Exception $exception) {
        report($exception);
        return back()->with('message',"Them moi that bai" );

        }

    }


    public function edit($id)
    {
        $department = $this->repository->find($id);
        $htmlOption = $this->repository->recursiveDepartment($department->parent_id);
        $data = view('department.modal.edit', compact('department','htmlOption'))->render();
        return \response([
            "data" => $data,
            'status' => 200
        ]);

    }
    public function loadEmployeeAjax($id_department){
        $employees =  $this->employee->getEmployeeInDepartment($id_department);
        $childs = $this->repository->loadChildDepartment($id_department);
            $data = view('department.loadEmployee', compact('childs','employees','id_department'))->render();
            return \response([
                "data" => $data,
                'status' => 200
            ]);
        }
    /**
     * Update the specified resource in storage.
     *
     * @param  DepartmentUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validator->setId($id)->with($request->only('txtPhongBan'))->passesOrFail(DepartmentValidator::RULE_UPDATE);
            $tenphongban = $request->post('txtPhongBan');
            $parent_id = $request->post('parent_id');
            $department = $this->repository->update(['tenphongban'=>$tenphongban,'parent_id'=>$parent_id],$id);
            if ($department) {
                return response()->json(['message'=> "Cập nhật thành công",'status'=>200,'nameDepartment'=>$department->tenphongban,'id'=>$department->id]);
            }
            throw new \Exception('Xảy ra lỗi khi cập nhật phong ban');

        }  catch (ValidatorException $e) {
            return response()->json([
                'status' => 421,
                'message' => $e->getMessageBag()
            ]);
        }
        catch (\Exception $exception) {
            report($exception);
            return response()->json([
                'status' => 422,
                'message' => $exception
            ]);

        }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            \DB::beginTransaction();
            $department = $this->repository->find($id);
            if($department->parent_id === 0){
                $listChildDepartment = $this->repository->findDepartment($department->id);
                foreach ($listChildDepartment as $child){
                    $this->repository->destroyDepartment($child->id);
                }
                $this->repository->deleteWhere(['parent_id'=>$id]);
            }else{
                $this->repository->destroyDepartment($id);
            }
            $department->delete();
            \DB::commit();
            return redirect()->back()->with('messageDelete', 'Xóa thành công');
        }catch (\Exception $exception){
            \DB::rollback();
            report($exception);
            return back()->withError($exception->getMessage());

        }

    }


    public  function getListEmployee($department_id){

        $employees = $this->employee->getlistEmployeeIsActiveOrNot($department_id);
       $positions = $this->position->all();
        foreach ($employees as $employee) {
            $employee_department = $employee->employeedepartment;
            $employee->checked = false;
            $employee->position= null;
            if(isset($employee_department[0]))
            {
                $employee->checked = true;
                $employee->position = $employee_department[0]->position;
            }
        }

        $view_data =  [
            'department_id'=>$department_id,
            'employees' => $employees,
            'positions' => $positions,
        ];
        $data = view("department.modal.addEmployee", compact("view_data"))->render();
        return \response([
            "data" => $data,
            'status' => 200
        ]);

    }

    public function toggleEmployeeMappingDepartment($department_id, Request $request)
    {
        $employee_id= $request->post('employee_id');
        $position_id= $request->post('position');
        $department = $this->repository->find($department_id);
        $employee = $this->employee->find($employee_id);
        if ($employee->departments()->where('departments.id', $department_id)->count()) {
            $employee->departments()->detach($department->id,['position_id'=>$position_id]);
            return \response([
                'status' => 200,
                'message' => 'Loại bỏ nhan vien khoi phong ban thành công.'
            ]);
        } else {
           $employee->departments()->attach($department->id,['position_id'=>$position_id]);
            $department = $this->repository->find($department_id);
            if ($department->employees()->where('employees.id', $employee_id)->count()) {
                $employee = $department->employees()->where('employees.id', $employee_id)->first();
            }
            $view_data['id_department'] = $department_id;
           $addRowEmployee = view("department.addRowLi",compact('employee','view_data'))->render();
            return \response([
                'id'=>$department_id,
                'data'=>$addRowEmployee,
                'status' => 200,
                'message' => 'Thêm nhan vien vao phong ban thành công.'
            ]);
        }
    }
    public function destroyEmployee($department_id,$employee_id, Request $request)
    {

        $department = $this->repository->find($department_id);
        $employee = $this->employee->find($employee_id);
        if ($employee->departments()->where('departments.id', $department_id)->count()) {
            $employee->departments()->detach($department->id);
            return \response([
                'status' => 200,
                'id'=>$employee_id,
                'message' => 'Loại bỏ nhan vien khoi phong ban thành công.'
            ]);
        } else {
            return \response([
                'status' => 500,
                'message' => 'Loại bỏ nhan vien khoi phong ban thất bại.'
            ]);
        }
    }
}
