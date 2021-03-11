<?php

namespace App\Http\Controllers;

use App\Criteria\BuildDataSearchForRequest;
use App\Criteria\EmployeeRequestCriteria;
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
    public function __construct(DepartmentRepository $departmentRepository,PositionRepository $position, EmployeeRepository $repository, EmployeeValidator $validator)
    {
        $this->position = $position;
        $this->repository = $repository;
        $this->departmentRepository = $departmentRepository;
        $this->validator = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BuildDataSearchForRequest $BuildDataSearchForRequest)
    {
        $BuildDataSearchForRequest = $BuildDataSearchForRequest
            ->setSearch('', [
                'ten' => 'name_employees',
                'departments.id' =>'departmentSelect'
            ])
            //->setSearchFields(['ten'=>'name_employee','departments.id'=>'departmentSelect'])
            ->setOrderBy('id')
            ->setSortedBy('desc');
        $employees = $this->repository->with('departments')
            ->pushCriteria(new EmployeeRequestCriteria($BuildDataSearchForRequest->getDataSearch()))
            ->paginate();
        $departments = $this->departmentRepository->where('parent_id','!=',0)->get();
        $view_data = [
            'department'=> $departments,
            'employees' => $employees
        ];
        return view('employees.index',compact('view_data'));
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
            $data = $request->only(['ten', 'sodienthoai', 'diachi', 'gioitinh', 'ngaybatdau', 'ngayketthuc']);
            $this->validator->with($data)->passesOrFail(EmployeeValidator::RULE_CREATE);
            $path = Storage::putFile('avatars', $request->file('imgProfile'));
            $data['img'] = $path;
            $employee = $this->repository->create($data);
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

    public function displayFormAdd()
    {
        return view('employees.add');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = $this->repository->find($id);

        return view('employees.update', compact('employee'));
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
            $data = $request->only(['ten', 'sodienthoai', 'diachi', 'gioitinh', 'ngaybatdau', 'ngayketthuc']);
            $this->validator->with($data)->setId($id)->passesOrFail(EmployeeValidator::RULE_UPDATE);
            if (isset($request->imgProfile)) {
                $path = Storage::putFile('avatars', $request->imgProfile);
            } else {
                $path = $request->imgProfileOld;
            }
            $data['img'] = $path;
            $employee = $this->repository->update($data, $id);
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
    public function destroy($id)
    {
        try {
            $deleted = $this->repository->delete($id);
            return redirect()->back()->with('message', 'Xóa Thành Công');
        } catch (\Exception $exception) {
            report($exception);
            return back()->withError($exception->getMessage());
        }
    }



}
