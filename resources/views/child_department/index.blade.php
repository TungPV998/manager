@extends("layout.app");
@section("content")
    <div class="container">
        <div class="row mb-3">
            <div class="col-lg-6">
                <h3><a data-toggle="modal" data-target="#editDepartment" href="javascript:void(0)">{{ $view_data['parent']['tenphongban'] }}<i class="fas fa-edit"></i> </a> </h3>
            </div>
            <div class="col-lg-6 text-right">
                <button type="button" class="btn btn-primary" id="urlStoreChild" data-toggle="modal" data-url = "{{ route("child.store",$view_data['parent']['id']) }}" data-target="#addChildDepartment">Thêm mới</button>
            </div>
        </div>
        <table class="table table-striped my-5">
            <thead>
            <tr>
                <th>Id</th>
                <th>Tên team</th>
                <th>Số thành viên</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($view_data['childs'] as $child)
            <tr>
                <td>{{ $child->id }}</td>
                <td>{{ $child->tenphongban }}</td>
                <td>{{ $child->employees_count }}</td>
                <td>
                    <a href="{{ route("showEmployee",['id'=>$child->id,'id_department_child'=>$view_data['id_department_child']]) }}">Chi Tiết</a>|<a style="cursor: pointer" data-toggle="modal" data-target="#deletechildDepartment_{{$child->id}}">Xóa</a>
                    @include('child_department.modal.delete',['department'=>$child])
                </td>
                <td></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection

@include('department.modal.edit',['view_data'=>$view_data])
@include('child_department.modal.add',['view_data'=>$view_data])
