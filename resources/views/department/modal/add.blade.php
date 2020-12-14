<!-- The Modal -->
<div class="modal" id="addDepartment">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Thêm mới</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <div id="alert-feedback">
                        <strong></strong>
                    </div>
                    <label for="usr">Tên phòng ban:</label>
                    <input type="text" id="txtPhongBan" class="form-control" name="txtPhongBan" >
                    <span class="invalid-feedback1" style="color: red;font-style: italic" role="alert"></span>
                </div>

            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" data-url="{{route("store")}}" id="btnAddDepartment" class="btn btn-info" >Thêm mới</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function () {
            $('input#txtPhongBan').on("keydown", function(e){
                $('.invalid-feedback1').css({"display":"none"});
                $('#alert-feedback').css({"display":"none"});
            });
            $("#btnAddDepartment").on('click',function (e) {
                const url = $(this).attr("data-url");
                $.ajax({
                    method: "post",
                    url: url,
                    data: {
                        txtPhongBan: $("#txtPhongBan").val()
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType:'json',
                })
                    .done(function( msg ) {
                        if(msg.status == 200){
                            $('#alert-feedback').addClass('alert alert-success aler-feedback');
                            $('#alert-feedback').css({"display":"block"});
                            $('.aler-feedback strong').html(msg.message);
                            $('.invalid-feedback1').css({"display":"none"});
                        }else{
                            $('.invalid-feedback1').html(msg.message.txtPhongBan);
                            $('.invalid-feedback1').css({"display":"inline-block"});
                            $('.aler-feedback').css({"display":"none"});
                            $('#alert-feedback').removeClass('alert alert-success aler-feedback');
                        }
                        $('#addDepartment').on('hidden.bs.modal', function () {
                            window.location.reload();
                        })
                    })
                    .fail(function( err ) {
                        const validator = (err.message ? err.message : "Hệ thống bị lỗi");
                        $('.invalid-feedback1').html(validator);
                        $('#alert-feedback').removeClass('alert alert-success aler-feedback');
                    });
            })
        })
    </script>
@endpush

