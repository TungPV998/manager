<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Criteria\BuildDataSearchForRequest;
use App\Criteria\EmployeeRequestCriteria;
use App\Model\Department;
use App\Model\Employee;
use App\Model\Position;
use App\Repositories\DepartmentRepository;
use App\Repositories\PositionRepository;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Repositories\EmployeeRepository;
use App\Validators\EmployeeValidator;

class ApiEmployeeController extends Controller
{
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
    public function index(Request $request)
    {
        $employees =  $this->repository->getListEmployee();
        return response()->json(["status"=>200,"message"=>"Lấy thông tin nhân viên thành công",'data'=>$employees]);
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
            $data = $request->only(['ten', 'sodienthoai','img', 'diachi', 'gioitinh']);
            $this->validator->with($data)->passesOrFail(EmployeeValidator::RULE_CREATE);
           // $data['img'] = $data['imgProfile'] ?? "https://s2.dmcdn.net/v/GPhvn1NfooEdLQqFx/x1080";
         ///  dd($data);

             $this->repository->create($data);
            return response()->json(['message'=>"Tạo mới nhân viên thành công","status"=>200]);
        } catch (ValidatorException $e) {
            return response()->json(['message'=>$e->getMessageBag()]);
        } catch (\Exception $exception) {
            report($exception);
            Log::error($exception->getMessage());
        }
    }

    public function getImagePath(Request $request)
    {
        try {
            if($request->hasFile("imgProfile")){
                $path = Storage::putFile('avatars', $request->file('imgProfile'));
            }else{
                $path = '';
            }
            return response()->json(['message'=>"Upload file thành công","status"=>200,'path'=>$path]);
        } catch (\Exception $exception) {
            report($exception);
            Log::error($exception->getMessage());
        }
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

        return response()->json(['message'=>"Hiển thị nhân viên thành công","status"=>200,'data'=>$employee]);
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
//        $employee = $this->repository->find($id);
//
//        return view('employees.edit', compact('employee'));
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
            dd($request->all());
            $data = $request->only(['ten', 'sodienthoai','img','diachi', 'gioitinh']);
          dd($data);
            $this->validator->with($data)->setId($id)->passesOrFail(EmployeeValidator::RULE_UPDATE);
            $this->repository->update($data, $id);
            return response()->json(['message'=>"Cập nhật nhân viên thành công","status"=>200]);
        } catch (ValidatorException $e) {
            return response()->json(['message'=>$e->getMessageBag()]);
        } catch (\Exception $exception) {
            report($exception);
            Log::error($exception->getMessage());
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
            return response()->json(['message'=>"Xóa nhân viên thành công","status"=>200]);
        } catch (\Exception $exception) {
            report($exception);
            Log::error($exception->getMessage());
        }
    }


}
