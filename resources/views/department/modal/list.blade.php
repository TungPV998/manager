<div class="modal" id="addEmployee">
    <div class="modal-dialog" style="max-width: 1200px;">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Them nhan vien </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="productManager">
                    <div class="card">
                        <div class="card-body">
                            <div class="row my-3">
                                <div class="col-6 text-right">
                                </div>
                            </div>
                            <div class="ajaxListEmployee">

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script>
        // $(document).ready(function () {
        //     $(".btn_search_product").click(function () {
        //         let url = $(this).attr("data-url");
        //         loadAjax(url);
        //     });
        //     function loadAjax(url) {
        //         $.ajax({
        //             url: url,
        //             method: "get",
        //             dataType: "json",
        //             contentType: "application/json;charset=utf-8"
        //         })
        //             .done(function (msg) {
        //                 if (msg.status == 200) {
        //                     $('.ajaxListEmployee').html(msg.data);
        //
        //                 } else {
        //                     $('.ajaxListEmployee').html("<h2 class='text-center'>Không tải được dữ liệu</h2>")
        //                 }
        //             })
        //             .fail(function (err) {
        //                 $('.ajaxListEmployee').html("<h2 class='text-center'>Không tải được dữ liệu</h2>")
        //
        //             });
        //     }
        // })
    </script>
@endpush
