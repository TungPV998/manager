{{--<ul>--}}
    {{--@foreach($childs as $child)--}}
        {{--<li>--}}
             {{--<span class="titleDepartment">--}}
            {{--{{ $child->tenphongban }}--}}
             {{--</span>--}}
            {{--<a href = "{{ route('department.edit',$child->id) }}  "  style="margin: 0 3%;"><i class="fas fa-edit"></i></a><a data-toggle="modal" data-target="#deleteDepartment_{{$child->id}}"><i class="fas fa-trash"></i></a>--}}
            {{--<span class="getListEmployee" data-url = "{{ route("getListEmployee") }}" style="margin: 0 3%;"><i class="fas fa-plus"></i></span>--}}
            {{--@include('department.modal.delete',['department'=>$child])--}}
            {{--@if(count($child->childs))--}}
                {{--@include('department.child',['childs' => $child->childs])--}}
            {{--@endif--}}
        {{--</li>--}}
    {{--@endforeach--}}
{{--</ul>--}}

<ul class="children nav-child unstyled small collapse" id="sub-item_{{$department->id}}">
    @foreach($childs as $child)
    <li class="item-2 deeper parent active my-2" style="margin-bottom: 5%">
            <a class="d-block link" href="#">
                <span data-toggle="collapse" data-parent="#menu-group_{{$child->id}}" href="#sub-item_{{$child->id}}" class="sign"><i class="icon-plus icon-white"></i></span>
                <span class="lbl"> {{ $child->tenphongban }}</span>
            </a>
        <div style="text-align: right;display: inline-block;width: 44%;">
                    <a href = "{{ route('department.edit',$child->id) }}"  style="margin: 0 3%;">
                        <i class="fas fa-edit"></i></a>
                    <a data-toggle="modal" data-target="#deleteDepartment_{{$child->id}}">
                        <i class="fas fa-trash"></i>
                    </a>
                    <span class="getListEmployee" data-toggle="modal" data-target="#addEmployee" data-url = "{{ route("getListEmployee",$child->id) }}" style="margin: 0 3%;"><i class="fas fa-plus"></i></span>
        </div>
        <ul class="children nav-child unstyled small collapse" id="sub-item_{{$child->id}}">
            <li class="item-3">
                <a class="link" href="#">
                    <span class="sign"><i class="icon-play"></i></span>
                    <span class="lbl">Menu 1.1</span> (current menu)
                </a>
            </li>
            <li class="item-4">
                <a class="link" href="#">
                    <span class="sign"><i class="icon-play"></i></span>
                    <span class="lbl">Menu 1.2</span>
                </a>
            </li>
        </ul>
    </li>
        @include('department.modal.delete',['department'=>$child])
    @endforeach
</ul>
@include('department.modal.list')
@push('scripts')
<script>
    $(document).ready(function() {
        $("span.getListEmployee").on("click", function (e) {
            const url = $(this).attr("data-url");
            $.ajax({
                method: "get",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType:'json',
            })
                .done(function( msg ) {
                    if(msg.status == 200){
                        $('.ajaxListEmployee').html(msg.data)
                    }else{
                        alert("Tải dữ liệu thất bại");
                    }
                })
                .fail(function( err ) {
                    alert("Tải dữ liệu thất bại");
                });
        });

    });
</script>
@endpush

