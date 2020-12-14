<div class="modal" id="editChildDepartment">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Cập nhật tên team</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <div id="alert-feedback-child-dep">
                        <strong></strong>
                    </div>
                    <label for="usr">Tên team:</label>
                    <input type="text" id="txteditChildPhongBan" value="{{  $childDepartment->tenphongban }}" class="form-control" name="txtPhongBan" >
                    <span class="invalid-feedback1-child-dep" style="color: red;font-style: italic" role="alert"></span>
                </div>

            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" data-url="{{route("update",['id'=>$childDepartment->id,'parent_id'=>$id_parent])}}" id="btnUpdateChildDepartment" class="btn btn-info" >Cập nhật</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function () {

            $('input#txteditPhongBan').on("keydown", function(e){
                $('.invalid-feedback1-child-dep').css({"display":"none"});
                $('#alert-feedback-child-dep').css({"display":"none"});
            });
            $("#btnUpdateChildDepartment").on('click',function (e) {
                const url = $(this).attr("data-url");
                //alert(url);
                $.ajax({
                    method: "post",
                    url: url,
                    data: {
                        txtPhongBan: $("#txteditChildPhongBan").val()
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType:'json',
                })
                    .done(function( msg ) {
                            if(msg.status == 200){
                                $('#alert-feedback-child-dep').addClass('alert alert-success aler-feedback');
                                $('#alert-feedback-child-dep').css({"display":"block"});
                                $('#aler-feedback-child-dep strong').html(msg.message);
                                $('.invalid-feedback1-child-dep').css({"display":"none"});

                            }else{
                                $('.invalid-feedback1-child-dep').html(msg.message.txtPhongBan);
                                $('.invalid-feedback1-child-dep').css({"display":"inline-block"});
                                $('.aler-feedback-child-dep').css({"display":"none"});
                                $('#alert-feedback-child-dep').removeClass('alert alert-success aler-feedback');
                            }
                            $('#editChildDepartment').on('hidden.bs.modal', function () {
                                window.location.reload();
                            })
                        }

                    )
                    .fail(function( err ) {
                        const validator = (err.message ? err.message : "{{ "Lỗi hệ thống"  }}");
                        $('.invalid-feedback1-child-dep').html(validator);
                        $('#alert-feedback-child-dep').removeClass('alert alert-success aler-feedback');
                    });
            })
        })

    </script>
@endpush

