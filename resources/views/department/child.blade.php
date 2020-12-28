<div aria-expanded="false" id="collapse_{{$view_data['id_department']}}" class="collapse show" data-parent="#accordion_{{$view_data['id_department']}}" aria-labelledby="heading-1">
        <div class="card-body">
        <div id="accordion-1_">
            @if(count($view_data['childs']) > 0 )
                @foreach($view_data['childs'] as $child)
                    <div class="card">
                        <div class="card-header" id="heading-1-1">
                            <h5 class="mb-0"  style="display: inline-block;width: 80%;">
                                <a data-id="{{ $child->id }}" id="loadEmployee"
                                   data-url="{{ route("department.loadAll",$child->id) }}"
                                   class="collapsed" role="button"
                                   data-toggle="collapse" href="#collapse_{{ $child->id }}"
                                   aria-expanded="false" >
                                    <i style="padding-right: 3%" class="fas fa-minus"></i><span class="nameDepartment_{{$child->id}}">{{$child->tenphongban}}</span>
                                </a>
                            </h5>
                            <div style="display: inline-block;width: 24%;position: relative;right: -89%;bottom: 23px">
                        <span data-id="{{ $child->id }}" class="editDepartmentAjax"  data-toggle="modal" data-target="#editDepartment_{{$child->id}}" data-url = "{{ route('department.edit',$child->id) }}"  style="margin: 0 3%;">
                            <i class="fas fa-edit"></i></span>
                                <a data-id="{{ $child->id }}" data-toggle="modal" data-target="#deleteDepartment_{{$child->id}}">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <span data-toggle="modal" data-target="#addEmployee" class="getListEmployee" data-url = "{{ route("getListEmployee",$child->id) }}" style="margin: 0 3%;"><i class="fas fa-plus"></i></span>
                            </div>
                        </div>
                        <div class="modal" id="editDepartment_{{ $child->id }}"> </div>
                    </div>
                    <div class="loadDepartment_{{$child->id}}">
                    </div>
                    @include('department.modal.delete',['department'=>$child])
                @endforeach
            @endif
                @if($view_data['employees'])
                    <ul class ="addEmployee_{{$view_data['id_department']}}">
                        @foreach($view_data['employees'] as $employee)
                            <li class=" removeEmployee_{{$employee->id}}">
                                <h5 class="mb-0"  style="display: inline-block;width: 80%;">
                                    <span >
                                        {{ $employee->ten }}
                                    </span>
                                </h5>
                                <div style="display: inline-block;width: 24%;position: relative;right: -89%;bottom: 23px;">
                                    <a data-toggle="modal"  data-target="#deleteEmployee_{{$employee->id}}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    @include('department.modal.deleteDepartment',['employee'=>$employee,"idDepartment"=>$view_data['id_department']])
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
        </div>

        </div>
</div>

@include('department.modal.list')
<script>
    $(document).ready(function() {
       //lay danh sach nhan vien de them vao
        $("span.getListEmployee").on("click", function (e) {
            const url = $(this).attr("data-url");
           // console.log(url);
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
                        $('.ajaxListEmployee').html(msg.data);
                    }else{
                        alert("Tải dữ liệu thất bại");
                    }
                })
                .fail(function( err ) {
                    alert("Tải dữ liệu thất bại");
                });
        });
        //edit ten phong ban
        $("span.editDepartmentAjax").on("click", function (e) {
            const url = $(this).attr("data-url");
            const id = $(this).attr("data-id");
            //console.log(url);
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
                        //console.log(msg.data);
                        $("#editDepartment_"+id).html(msg.data);
                    }else{
                        alert("Tải dữ liệu thất bại");
                    }
                })
                .fail(function( err ) {
                    alert("Tải dữ liệu thất bại");
                });
        });
        //load nhan vien trong phong ban
        // $("#loadEmployee").on("click", function (e) {
        //     const url = $(this).attr("data-url");
        //     const id = $(this).attr("data-id");
        //    // console.log(url);
        //     //console.log(id);
        //     $.ajax({
        //         method: "get",
        //         url: url,
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         dataType:'json',
        //     })
        //         .done(function( msg ) {
        //             if(msg.status == 200){
        //                 $("#collapse_child_"+id).html(msg.data);
        //             }else{
        //                 alert("Tải dữ liệu thất bại");
        //             }
        //         })
        //         .fail(function( err ) {
        //             alert("Tải dữ liệu thất bại");
        //         });
        // });

        $("a#loadEmployee").on("click", function (e) {
            const url = $(this).attr("data-url");
            const id = $(this).attr("data-id");
            //console.log(url);
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
                       // console.log( $('.loadDepartment_'+id));
                        $('.loadDepartment_'+id).html(msg.data);
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


