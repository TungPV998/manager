@extends("layout.app")
@push("css")
@endpush
@section("content")
    <div class="container">
        <div class="row mb-3">
            <div class="col-lg-6">
                <h3>Danh sách phòng ban</h3>
                @if (session('messageDelete'))
                    <div class="alert alert-success text-center">{{ session('messageDelete') }}</div>
                @endif
                @if ($view_data['departments'])
                    @foreach($view_data['departments'] as $department)
                        <div id="accordion_{{$department->id}}">
                        <div class="card">
                            <div class="card-header" id="heading-1">
                                <h5 class="mb-0" style="display: inline-block;width: 80%;">
                                    <a data-id="{{$department->id}}" id="loadChild" data-url="{{ route("department.loadAll",$department->id) }}"  data-toggle="collapse" href="#collapse_{{$department->id}}" aria-expanded="false" aria-controls="collapse_{{$department->id}}">
                                        <i style="padding-right: 3%" class="fas fa-plus"></i><span class="nameDepartment_{{$department->id}}">{{$department->tenphongban}}</span>
                                    </a>
                                </h5>
                                <div style="display: inline-block;width: 24%;position: relative;right: -89%;bottom: 23px;">
                                    <span data-id="{{$department->id}}" class="editDepartmentAjax"  data-toggle="modal" data-target="#editDepartment_{{$department->id}}" data-url = "{{ route('department.edit',$department->id) }}"  style="margin: 0 3%;">
                            <i class="fas fa-edit"></i></span>
                                    <a data-toggle="modal" data-target="#deleteDepartment_{{$department->id}}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <span data-toggle="modal" data-target="#addEmployee" class="getListEmployee" data-url = "{{ route("getListEmployee",$department->id) }}" style="margin: 0 3%;"><i class="fas fa-plus"></i></span>

                                    @include('department.modal.delete',['department'=>$department])
                                </div>
                                <div class="modal" id="editDepartment_{{ $department->id }}"> </div>
                                    <div class="loadDepartmentChild_{{$department->id}}"></div>
                            </div>

                        </div>
                        </div>
                    @endforeach
                        @endif
                @include('department.modal.list')
            </div>



            <div class="col-lg-6">
                <div style="flex-direction: row;justify-content: space-between">
                    <h3  style="flex-basis: 40%;display: inline-block;margin-right: 28%;">Thêm phòng ban </h3>
                    <h3 style="flex-basis: 40%;display: inline-block;"><a href="{{ route("employee.index") }}">Quản Lý Nhân Viên</a> </h3>
                </div>
                @if (session('message'))
                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                @endif

                <form method="post" action="{{ route("department.store") }}">
                    @csrf
                    <div class="form-group">
                        <label for="txt_name_cate">Tên phòng ban:</label>
                        <p></p>
                        <input type="text" class="form-control" name="txtPhongBan" id="txtPhongBan">
                        @if ($errors->has('txtPhongBan'))
                            <p class="error">
                                <i style="color: red;font-style: italic">(*){{ $errors->first('txtPhongBan') }}</i>
                            </p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Chọn danh mục cha:</label>
                        <select class="form-control" name="parent_id">
                            <option value="0">Chọn danh mục cha</option>
                            {!! $view_data['htmlOption'] !!}
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info">Thêm mới</button>
                </form>

            </div>
        </div>

    </div>

@endsection


    <script>

    </script>


