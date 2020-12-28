
    <div style="" class="modal fade" id="deleteEmployee_{{$employee->id}}" tabindex="-1" role="dialog" aria-hidden="true">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bạn có chắc là muốn xóa nhân viên này không ?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" id="deleteEmployeeInDepartment_{{ $employee->id }}" data-example="123"  data-link="{{route('department.destroyEmployee',['department_id'=>$idDepartment,'employee_id'=>$employee->id]) }}"  class="btn btn-primary">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function() {
        //xóa nhân viên khỏi phòng ban

        $("#deleteEmployeeInDepartment_{{ $employee->id }}").on("click", function (e) {
            $.ajax({
                method: "get",
                url: "destroy-employee/{{ $idDepartment }}/{{ $employee->id }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType:'json',
            })
                .done(function( msg ) {
                    if(msg.status == 200){
                        alert(msg.message);
                        $(".removeEmployee_"+msg.id).remove();
                        $('#deleteEmployee_{{$employee->id}}').modal('hide');
                    }else{
                        alert(msg.message);
                    }
                })
                .fail(function( err ) {
                    alert("Xóa Thất bại");
                });
        });
    });
</script>

