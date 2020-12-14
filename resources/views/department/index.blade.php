@extends("layout.app");
@section("content")
    <div class="container">
        <div class="row mb-3">
            <div class="col-lg-6">
                <h3>Quản lý phòng ban</h3>
            </div>
            <div class="col-lg-6 text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDepartment">Thêm mới</button>
            </div>
        </div>
        @if (session('message'))
            <div class="alert alert-success text-center">{{ session('message') }}</div>
        @endif
        <table class="table table-striped my-5">
            <thead>
            <tr>
                <th>Id</th>
                <th>Tên phòng ban</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @if($departments)
            @foreach($departments as $department)
            <tr>
                <td>{{ $department->id }}</td>
                <td>{{ $department->tenphongban }}</td>
                <td>
                    <a href="{{ route("detailDepartment",$department->id) }}">Chi Tiết</a>|<a style="cursor: pointer" data-toggle="modal" data-target="#deleteDepartment_{{$department->id}}">Xóa</a>
                    @include('department.modal.delete',['department'=>$department])
                </td>
                <td></td>
            </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

@endsection
@include('department.modal.add')

