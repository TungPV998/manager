@extends("layout.app");
@section("content")
    <div class="container">
        <div class="row mb-3">
            <div class="col-lg-4">
                <h3><a href="javascript:void(0)"  data-target="#editChildDepartment" data-toggle="modal">{{ $childDepartment->tenphongban }}<i class="fas fa-edit"></i> </a> </h3>

            </div>
            <div class="col-lg-5">
                <form class="form-inline" method="get" action="{{ route("showEmployee",['id'=>$id_child,'id_department_child'=>$id_parent]) }}">
                    <input type="text" class="form-control" placeholder="Bạn cần tìm gì ?" style="width: 78% !important;" name="name_employees" id="search">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </form>

            </div>
            <div class="col-lg-3 text-right">
                <a href="{{ route("displayFormAdd",$id_parent) }}" type="button" class="btn btn-primary">Thêm mới</a>
            </div>
        </div>

        @if (session('message'))
            <div class="alert alert-success text-center">{{ session('message') }}</div>
        @endif

        <table class="table table-striped my-5">
            <thead>
            <tr class="text-center">
                <th>Id</th>
                <th>Thông tin</th>
                <th>Ảnh</th>
                <th>Chức vụ</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($employees as $employee)
            <tr>
                <td>
                    {{ $employee->id }}
                </td>
                <td>
                    <b style="display: block">Tên:</b> {{ $employee->ten }}
                    <b style="display: block">Địa chỉ:</b>{{ $employee->diachi }}
                    <b style="display: block">Số điện thoại:</b>{{ $employee->sodienthoai }}
                    <b style="display: block">Giới tính:</b>{{ $employee->gioitinh === 0 ? "Nam" : "Nữ" }}
                </td>
                <td width="200px">
                    <img width="100%" src="{{asset('/storage/'.$employee->img)  }}" alt="">
                </td>
                @foreach($employee->positions as $position)
                <td>{{ $position->tenchucvu }}</td>
                @endforeach
                <td>{{ $employee->ngaybatdau }}</td>
                <td>{{ $employee->ngayketthuc }}</td>

                <td>
                    <a href="{{ route("employee.show",['id'=>$employee->id,'parent_id'=>$id_parent]) }}">Sửa</a>|<a href="{{ route("employee.destroy",['id'=>$employee->id,'childDepartment_id'=>$childDepartment->id]) }}">Xóa</a></td>
                <td></td>
            </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
@include('department.modal.add')
@include('child_department.modal.edit',['childDepartment'=>$childDepartment])

