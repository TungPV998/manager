@extends("layout.app")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-lg-6"><h1> Cập nhật thông tin nhân viên </h1></div>
            <div class="col-lg-6 text-right"><a class="text-right" style="font-size: 25px" href="{{ route("employee.index") }}">Danh sách nhân Viên</a></div>
            <div class="col-lg-12">
                @if (session('error'))
                    <div class="alert alert-danger text-center">{{ session('error') }}</div>
                @endif
                @if (session('message'))
                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                @endif
                <form action="{{ route("employee.update", $employee->id) }}" method="post" enctype='multipart/form-data'>
                    @csrf
                    <div class="form-group">
                        <label for="email">Ho va ten:</label>
                        <input type="text" class="form-control" name="ten"  value="{{ $employee->ten  }}"   placeholder="Enter name" id="email">
                        @if ($errors->has('ten'))
                            <p class="error">
                                <i style="color: red;font-style: italic">(*){{ $errors->first('ten') }}</i>
                            </p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="pwd">Địa Chỉ:</label>
                        <input type="text" value="{{ $employee->diachi }}" class="form-control" name="diachi" placeholder="Enter address" id="pwd">
                        @if ($errors->has('diachi'))
                            <p class="error">
                                <i style="color: red;font-style: italic">(*){{ $errors->first('diachi') }}</i>
                            </p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="email">Số điện thoại:</label>
                        <input type="text" class="form-control" value="{{ $employee->sodienthoai }}" name="sodienthoai" placeholder="Enter telephone" id="email">
                        @if ($errors->has('sodienthoai'))
                            <p class="error">
                                <i style="color: red;font-style: italic">(*){{ $errors->first('sodienthoai') }}</i>
                            </p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="pwd">Giới tính:</label>
                        @if($employee->gioitinh == 0)
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" value="0" checked class="form-check-input" name="gioitinh">Nam
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" value="1" class="form-check-input" name="gioitinh">Nữ
                            </label>
                        </div>
                            @else
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" value="0"  class="form-check-input" name="gioitinh">Nam
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" value="1" checked class="form-check-input" name="gioitinh">Nữ
                                </label>
                            </div>
                            @endif
                    </div>


                    <div class="form-group">
                        <label for="pwd">Ngày bắt đầu</label>
                        <input type="date" class="form-control" name="ngaybatdau" value="{{$employee->ngaybatdau}}" placeholder="Ngày bắt đầu" id="pwd">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Ngày kết thúc</label>
                        <input type="date" class="form-control" value="{{$employee->ngayketthuc}}" name="ngayketthuc" placeholder="Ngày kết thúc" id="pwd">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Ảnh đại diện</label>
                        <input type="file" class="form-control-file border" name="imgProfile">
                        <input type="hidden" class="form-control-file border" value="{{ $employee->img ? $employee->img :  "" }}" name="imgProfileOld">
                        @if ($errors->has('imgProfile'))
                            <p class="error">
                                <i style="color: red;font-style: italic">(*){{ $errors->first('imgProfile') }}</i>
                            </p>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>

        </div>
    </div>

@endsection
@include('department.modal.add')

