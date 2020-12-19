<?php

namespace App\Http\Controllers;

use App\Criteria\BuildDataSearchForRequest;
use App\Criteria\DepartmentRequestCriteria;
use App\Criteria\EmployeeCriteria;
use App\Criteria\EmployeeRequestCriteria;
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
        $departments = $this->repository->where('parent_id', '=', 0)->get();
        $allDepartment = $this->repository->pluck('tenphongban','id')->all();
        $htmlOption  = $this->repository->recursiveDepartment($parent_id='');
        $view_data = [
            'htmlOption'=>$htmlOption,
            'departments'=>$departments,
            'allDepartment'=>$allDepartment,
        ];
        return view('department.index',compact('view_data'));

    }


    /**
     * Hiển thị danh sách phong ban con.
     *
     * @return \Illuminate\Http\Response
     */
    public function showChildDepartment($id_department_child)
    {
        $childs = $this->repository->withCount("employees")->findWhere(["parent_id"=>$id_department_child])->all();
        $parent = $this->repository->findWhere(["id"=>$id_department_child])->first();
        $view_data = [
            "childs"=>$childs,
            "parent"=>$parent,
            "id_department_child"=>$id_department_child
        ];
        return view('child_department.index',compact('view_data'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  DepartmentCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
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

    /**
     * Lưu thêm mới giá trị phòng ban con
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
//    public function storeChildDepartment(Request $request,$id_parent)
//    {
//        try {
//            $this->validator->with($request->only('txtPhongBan'))->passesOrFail(DepartmentValidator::RULE_CREATE);
//            $tenphongban = $request->post('txtPhongBan');
//            $department = $this->repository->create(['tenphongban'=>$tenphongban,'parent_id'=>$id_parent]);
//            $response = $department ? [
//                'message' => "Tạo mới thành công",
//                'status' => 200,
//            ] : [
//                'message' => "Tạo mới thất bại",
//                'status' => 500,
//            ];
//        } catch (ValidatorException $e) {
//            $response = [
//                'status' => 422,
//                'message' => $e->getMessageBag()
//            ];
//        }
//        catch(Exception $exception) {
//            $response = [
//                'message' => "Tạo mới thất bại",
//                'status' => 500,
//            ];
//        }
//        return response()->json($response);
//    }

    /**
     * Hiển thị danh sách nhân viên trongh phong ban
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
//    public function showEmployee($id_department_child,$id_department_parent,BuildDataSearchForRequest $BuildDataSearchForRequest)
//    {
//        $BuildDataSearchForRequest = $BuildDataSearchForRequest
//            ->setSearch('', [
//                'ten' => 'name_employees',
//                'departments.id' => 'departmentSlect',
//            ])
//            ->setSearchFields([''])
//            ->setOrderBy('id')
//            ->setSortedBy('desc');
//        $employees = $this->employee->with('positions')
//            ->whereHas('departments',function ($sql) use ($id_department_child){
//                return $sql->where('departments.id','=',$id_department_child);
//            })
//            ->pushCriteria(new EmployeeRequestCriteria($BuildDataSearchForRequest->getDataSearch()))
//            ->paginate();
//        $id_parent = $id_department_parent;
//        $id_child = $id_department_child;
//        $childDepartment = $this->repository->getInforChildDepartment($id_department_child);
//
//        return view('employees.index', compact('employees','id_parent','id_child','childDepartment'));
//    }
    /**
     * sửa ten phòng ban con
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function editChildDepartment($id_department_child,$id_department_parent)
    {
       $department_child = $this->repository->find($id_department_child);
        return view('employees.index', compact('department_child'));
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
        $department = $this->repository->find($id);
        $htmlOption = $this->repository->recursiveDepartment($department->parent_id);
        return view('department.edit', compact('department','htmlOption'));
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
                return back()->with('message', "Cập nhật thành công");
            }
            throw new \Exception('Xảy ra lỗi khi cập nhật phong ban');

        } catch (ValidatorException $e) {
            return back()->withInput($request->all())->withErrors($e->getMessageBag());
        }
        catch (\Exception $exception) {
            report($exception);
            return back()->with('message',"Cập nhật that bai" );

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
            $department = $this->repository->delete($id);
            if($department){
                \DB::commit();
                return redirect()->back()->with('messageDelete', 'Xóa thành công');
            }
            return redirect()->back()->with('messageDelete', 'Xóa thất bại');
        }catch (\Exception $exception){
            \DB::rollback();
            report($exception);
            return back()->withError($exception->getMessage());

        }
    }
    public  function getListEmployee($department_id){
      // dd("okok");
       $employee = $this->employee->paginate();
       $position = $this->position->all();

        $view_data =  [
            'employees' => $employee,
            'position' => $position,
        ];
        $data = view("department.modal.addEmployee", compact("view_data"))->render();
        return \response([
            "data" => $data,
            'status' => 200
        ]);

    }

    public function toggleProductMappingGroup($group_id, Request $request)
    {
        $product_id = $request->post('product_id');
        /**
         * @var Group $group
         */
        $group = $this->group->find($group_id);
        /**
         * @var Product $product
         */
        $product = $this->product->find($product_id);
        if ($product->groups()->where('groups.id', $group_id)->count()) {
            $product->groups()->detach($group->id);
            return \response([
                'status' => 200,
                'message' => 'Loại bỏ sản phẩm khỏi danh mục thành công.'
            ]);
        } else {
            $product->groups()->save($group);
            return \response([
                'status' => 200,
                'message' => 'Thêm sản phẩm vào danh mục thành công.'
            ]);
        }
    }

}
