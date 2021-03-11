@extends("layout.app")
@push("css")

@endpush
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-right">
                <a href="{{ route("department.index") }}">Quay lại trang chủ</a>
            </div>
            <div class="col-lg-12">
                @if (session('message'))
                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                @endif
                <form method="post" action="{{ route("department.update",['id'=>$department->id]) }}">
                    @csrf
                    <div class="form-group">
                        <label for="txt_name_cate">Tên phòng ban:</label>
                        <p></p>
                        <input type="text" class="form-control" value="{{ $department->tenphongban }}" name="txtPhongBan" id="txtPhongBan">
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
                            {!! $htmlOption !!}
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info">Thêm mới</button>
                </form>
            </div>


    </div>
    </div>
@endsection

