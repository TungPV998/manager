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

                <ul id="menu-group-1" class="nav menu jumbotron">
                    @foreach($view_data['departments'] as $department)
                    <li class="item-1 deeper parent active">
                        <a class="link" data-toggle="collapse" data-parent="#menu-group_{{$department->id}}" href="#sub-item_{{$department->id}}">
                            <span  class="sign"><i class="icon-plus icon-white"></i></span>
                            <span class="lbl">{{ $department->tenphongban }}</span>
                        </a>
                        <div style="display: inline-block;width: 65%;position: relative;right: -80%;bottom: 23px;z-index: 99999;">
                            <a href = "{{ route('department.edit',$department->id) }}"  style="margin: 0 3%;">
                                <i class="fas fa-edit"></i></a>
                            <a data-toggle="modal" data-target="#deleteDepartment_{{$department->id}}">
                                <i class="fas fa-trash"></i>
                            </a>

                        </div>
                        @if(count($department->childs))
                            @include('department.child',['childs' => $department->childs,'department'=>$department])
                        @endif
                    </li>
                        @include('department.modal.delete',['department'=>$department])
                    @endforeach
                    {{--<li class="item-8 deeper parent">--}}
                        {{--<a class="link" href="#">--}}
                            {{--<span data-toggle="collapse" data-parent="#menu-group-1" href="#sub-item-8" class="sign"><i class="icon-plus icon-white"></i></span>--}}
                            {{--<span class="lbl">Menu Group ii</span>--}}
                        {{--</a>--}}
                        {{--<ul class="children nav-child unstyled small collapse" id="sub-item-8">--}}
                            {{--<li class="item-9 deeper parent">--}}
                                {{--<a class="link" href="#">--}}
                                    {{--<span data-toggle="collapse" data-parent="#menu-group-1" href="#sub-item-9" class="sign"><i class="icon-plus icon-white"></i></span>--}}
                                    {{--<span class="lbl">Menu 1</span>--}}
                                {{--</a>--}}
                                {{--<ul class="children nav-child unstyled small collapse" id="sub-item-9">--}}
                                    {{--<li class="item-10">--}}
                                        {{--<a class="link" href="#">--}}
                                            {{--<span class="sign"><i class="icon-play"></i></span>--}}
                                            {{--<span class="lbl">Menu 1.1</span>--}}
                                        {{--</a>--}}
                                    {{--</li>--}}
                                    {{--<li class="item-11">--}}
                                        {{--<a class="link" href="#">--}}
                                            {{--<span class="sign"><i class="icon-play"></i></span>--}}
                                            {{--<span class="lbl">Menu 1.2</span>--}}
                                        {{--</a>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                            {{--<li class="item-12 deeper parent">--}}
                                {{--<a class="link" href="#">--}}
                                    {{--<span data-toggle="collapse" data-parent="#menu-group-1" href="#sub-item-12" class="sign"><i class="icon-plus icon-white"></i></span>--}}
                                    {{--<span class="lbl">Menu 2</span>--}}
                                {{--</a>--}}
                                {{--<ul class="children nav-child unstyled small collapse" id="sub-item-12">--}}
                                    {{--<li class="item-13">--}}
                                        {{--<a class="link" href="#">--}}
                                            {{--<span class="sign"><i class="icon-play"></i></span>--}}
                                            {{--<span class="lbl">Menu 2.1</span>--}}
                                        {{--</a>--}}
                                    {{--</li>--}}
                                    {{--<li class="item-14">--}}
                                        {{--<a class="link" href="#">--}}
                                            {{--<span class="sign"><i class="icon-play"></i></span>--}}
                                            {{--<span class="lbl">Menu 2.2</span>--}}
                                        {{--</a>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                </ul>

                {{--<ul class="tree1">--}}
                        {{--@foreach($view_data['departments'] as $department)--}}
                            {{--<li >--}}
                                {{--{{ $department->tenphongban }}--}}
                              {{--<a id="spanEdit" href = "{{ route('department.edit',$department->id) }}  "  style="margin: 0 3%;"><i class="fas fa-edit"></i></a><a  data-toggle="modal" data-target="#deleteDepartment_{{$department->id}}"><i class="fas fa-trash"></i></a>--}}
                                {{--@include('department.modal.edit',['department'=>$department])--}}{{-- @include('department.modal.delete',['department'=>$department])--}}
                                {{--@if(count($department->childs))--}}
                                    {{--@include('department.child',['childs' => $department->childs])--}}
                                {{--@endif--}}
                            {{--</li>--}}
                        {{--@endforeach--}}
                {{--</ul>--}}
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

@push("script")
    <script>
        // $(document).ready(function(){
        //     $("span.getListEmployee").click(function (e) {
        //         console.log("okok");
        //     });
        //
        // });
    </script>

@endpush
