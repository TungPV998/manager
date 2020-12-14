<!-- The Modal -->
<div class="modal" id="addChildDepartment">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Thêm mới team trong phòng ban</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <div id="alert-feedback-child">
                        <strong></strong>
                    </div>
                    <label for="usr">Tên team:</label>
                    <input type="text" id="txtChildPhongBan" class="form-control" name="txtPhongBan" >
                    <span class="invalid-feedback1-child" style="color: red;font-style: italic" role="alert"></span>
                </div>

            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" data-url="{{route("child.store",$view_data['parent']['id'])}}" id="btnAddChildDepartment" class="btn btn-info" >Thêm mới</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function () {
            $('input#txtPhongBan').on("keydown", function(e){
                $('.invalid-feedback1-child').css({"display":"none"});
                $('#alert-feedback-child').css({"display":"none"});
            });
            $("#btnAddChildDepartment").on('click',function (e) {
                const url = $(this).attr("data-url");
                $.ajax({
                    method: "post",
                    url: url,
                    data: {
                        txtPhongBan: $("#txtChildPhongBan").val()
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType:'json',
                })
                    .done(function( msg ) {

                        if(msg.status === 200){
                           console.log(msg.message);
                            $('#alert-feedback-child').addClass('alert alert-success aler-feedback');
                            $('#alert-feedback-child').css({"display":"block"});
                            $('#aler-feedback-child strong').html(msg.message);
                            $('.invalid-feedback1-child').css({"display":"none"});
                        }else{
                            $('.invalid-feedback1-child').html(msg.message.txtPhongBan);
                            $('.invalid-feedback1-child').css({"display":"inline-block"});
                            $('#aler-feedback-child').css({"display":"none"});
                            $('#alert-feedback-child').removeClass('alert alert-success aler-feedback-child');
                        }
                        $('#addChildDepartment').on('hidden.bs.modal', function () {
                            window.location.reload();
                        })
                    })
                    .fail(function( err ) {
                        const validator = (err.message ? err.message : "Hệ thống bị lỗi");
                        $('.invalid-feedback1-child').html(validator);
                        $('#alert-feedback-child').removeClass('alert alert-success aler-feedback');
                    });
            })
        })
    </script>
@endpush

