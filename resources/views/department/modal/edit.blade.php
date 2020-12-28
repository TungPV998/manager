
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Cập nhật tên phòng</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <div id="alert-feedback">
                        <strong></strong>
                    </div>
                    <label for="usr">Tên phòng ban:</label>
                    <input type="text" id="txteditPhongBan" value="{{ $department->tenphongban }}" class="form-control" name="txtPhongBan" >
                    <span class="invalid-feedback1" style="color: red;font-style: italic" role="alert"></span>
                </div>
                <div class="form-group">
                    <label>Chọn danh mục cha:</label>
                    <select class="form-control" id="parent_id" name="parent_id">
                        <option value="0">Chọn danh mục cha</option>
                        @if (isset($htmlOption))
                            {!! $htmlOption !!}
                        @endif

                    </select>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" data-url="{{route("department.update",['id'=>$department->id]) }}" id="btnUpdateDepartment" class="btn btn-info" >Cập nhật</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>


    <script>
        $(document).ready(function () {

            $('input#txteditPhongBan').on("keydown", function(e){
            $('.invalid-feedback1').css({"display":"none"});
            $('#alert-feedback').css({"display":"none"});
              });
        $("#btnUpdateDepartment").on('click',function (e) {
        const url = $(this).attr("data-url");
        //alert(url);
        $.ajax({
        method: "post",
        url: url,
        data: {
            txtPhongBan: $("#txteditPhongBan").val(),
            parent_id: $("#parent_id").val()
        },
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType:'json',
        })
        .done(function( msg ) {
        if(msg.status == 200){

            console.log(msg);
            $('#alert-feedback').addClass('alert alert-success aler-feedback');
            $('#alert-feedback').css({"display":"block"});
            $('.aler-feedback strong').html(msg.message);
            $('.invalid-feedback1').css({"display":"none"});
            $('.nameDepartment_'+msg.id).html(msg.nameDepartment);

        }else{
            $('.invalid-feedback1').html(msg.message.txtPhongBan);
            $('.invalid-feedback1').css({"display":"inline-block"});
            $('.aler-feedback').css({"display":"none"});
            $('#alert-feedback').removeClass('alert alert-success aler-feedback');
            console.log(msg);
}
        })
        .fail(function( err ) {
        const validator = (err.message ? err.message : "{{ "Lỗi hệ thống"  }}");
        $('.invalid-feedback1').html(validator);
        $('#alert-feedback').removeClass('alert alert-success aler-feedback');
        });
        })
        })

    </script>


