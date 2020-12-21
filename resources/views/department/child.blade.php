<div id="collapse_{{$department->id}}" class="collapse show" data-parent="#accordion_{{$department->id}}" aria-labelledby="heading-1">
    <div class="card-body">
        @foreach($childs as $child)
        <div id="accordion-1_{{$child->id}}">
            <div class="card">
                <div class="card-header" id="heading-1-1">
                    <h5 class="mb-0"  style="display: inline-block;width: 80%;">
                        <a class="collapsed" role="button" data-toggle="collapse" href="#collapse_child_{{ $child->id }}" aria-expanded="false" aria-controls="collapse-1-1">
                            {{ $child->tenphongban }}
                        </a>
                    </h5>
                    <div style="display: inline-block;width: 24%;position: relative;right: -89%;bottom: 23px">
                        <a href = "{{ route('department.edit',$department->id) }}"  style="margin: 0 3%;">
                            <i class="fas fa-edit"></i></a>
                        <a data-toggle="modal" data-target="#deleteDepartment_{{$department->id}}">
                            <i class="fas fa-trash"></i>
                        </a>
                        <span data-toggle="modal" data-target="#addEmployee" class="getListEmployee" data-url = "{{ route("getListEmployee",$child->id) }}" style="margin: 0 3%;"><i class="fas fa-plus"></i></span>
                    </div>
                </div>
                {{--<div id="collapse_child_{{ $child->id }}" class="collapse" data-parent="#accordion-1_{{$child->id}}" aria-labelledby="heading-1-1">--}}
                    {{--<div class="card-body">--}}
                        {{--<div id="accordion-1_{{$child->id}}">--}}
                            {{--<div class="card">--}}
                                {{--<div id="collapse-1-1-1" class="collapse" data-parent="#accordion-1_{{$child->id}}" aria-labelledby="heading-1-1-1">--}}
                                    {{--<div class="card-body">--}}
                                        {{--Text 1 > 1 > 1--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
                @include('department.modal.delete',['department'=>$child])
        </div>
            @endforeach
    </div>
</div>
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

