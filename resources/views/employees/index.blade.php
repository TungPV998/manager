@extends("layout.app");
@section("content")
    <div class="container">
        <div class="row mb-3">
            <div class="col-lg-9">
                <form class="form-inline" method="get" action="{{route("employee.index")}}">
                    <select style="width: 40% !important;" name="departmentSelect" class="form-control">
                        <option value="">Tất cả</option>
                        @if ($view_data['department'])
                            @foreach($view_data['department'] as $department)

                                <option value="{{ $department->id }}"> {{ $department->tenphongban }}</option>
                            @endforeach
                        @endif
                    </select>
                    <input type="text" class="form-control" placeholder="Bạn cần tìm gì ?" style="width: 48% !important;" name="name_employees" id="search">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </form>

            </div>
            <div class="col-lg-3 text-right">
                <a href="{{ route("displayFormAdd") }} " type="button" class="btn btn-primary">Thêm mới</a>
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
                <th>Phong Ban</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($view_data['employees'] as $employee)
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

                 @if(isset($employee->departments[0]))
                    @foreach ($employee->departments as $department)
                        <td> {{ $department->tenphongban }} </td>
                    @endforeach
                @else
                    <td>
                        <span>[N/A]</span>
                    </td>
                @endif


                <td>{{ $employee->ngaybatdau }}</td>
                <td>{{ $employee->ngayketthuc }}</td>

                <td>
                    <a href="{{ route("employee.show",$employee->id) }}">Sửa</a>|<a href="{{ route("employee.destroy",$employee->id) }}">Xóa</a></td>
            </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col-lg-12 text-center">
                {{ $view_data['employees']->links() }}
            </div>
        </div>
    </div>

@endsection
@include('department.modal.add')


