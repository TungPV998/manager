<form method="post" action="{{route("destroy",$department->id)}}">
    <div class="modal fade" id="deletechildDepartment_{{$department->id}}" tabindex="-1" role="dialog" aria-hidden="true">
        @csrf
        @method("delete")
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bạn có chắc là muốn xóa ? Xóa sẽ bị mất hết dữ liệu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
</form>


