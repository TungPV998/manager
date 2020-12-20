<table class="table table-bordered">
    <thead>
    <tr>
        <th>
        </th>
        <th>Tên nhan vien</th>
        <th>Dia Chi</th>
        <th>Gioi tinh</th>
        <th>Chuc vu</th>
    </tr>
    </thead>
    <tbody>
    @foreach($view_data['employees'] as $employee)
        <tr style="text-align: center">
            <td>
                <div class="custom-control custom-checkbox">

                    <input {{ $employee->checked ? "checked" : "" }}
                           type="checkbox"
                           name="check"
                           id="productsCheck_{{$employee->id}}"
                           class="custom-control-input productsCheck"
                           onclick="toggle_employee_mapping_department({{$employee->id}})"
                    >
                    <label class="custom-control-label" for="productsCheck_{{$employee->id}}"></label>
                </div>
            </td>
            <td>{{ $employee->ten }}</td>
            <td>{{ $employee->diachi }}</td>
            <td>{{ $employee->gioitinh === 0 ? "Nam" : "Nu" }}</td>
            <td>
                <div class="form-group">
                    <select class="form-control" name="position" id="position">
                        @foreach($view_data['position'] as $position)
                        <option value="{{ $position->id }}">{{ $position->tenchucvu }}</option>
                         @endforeach
                    </select>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="paginate_ajax">
    <div class="row">
        <div class="col-12">
            {{ $view_data['employees']->links() }}
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        //xu ly ajax phan paginate
        $(".paginate_ajax .pagination a").bind("click", function (event) {
            event.preventDefault();
            var url = $(this).attr("href");
            $('li').removeClass('active');
            $(this).parent().addClass('active');
            loadAjax(url);
        });

        function loadAjax(url) {
            $.ajax({
                url: url,
                method: "get",
                dataType: "json",
                contentType: "application/json;charset=utf-8"
            })
                .done(function (msg) {
                    if (msg.status == 200) {
                        $('.ajaxListEmployee').html(msg.data);

                    } else {
                        $('.ajaxListEmployee').html("<h2 class='text-center'>Không tải được dữ liệu</h2>")
                    }
                })
                .fail(function (err) {
                    $('.ajaxListEmployee').html("<h2 class='text-center'>Không tải được dữ liệu</h2>")

                });
        }

        // const itemCheck = document.querySelectorAll(".productsCheck");
        // itemCheck.forEach(element => element.addEventListener("click", function () {
        //     let url = element.getAttribute("data-url");
        //     let data = {
        //         idCatalog: $("#getIdCatalog").attr("data-idCatalog")
        //     };
        //
        //
        // }));
    });

    function toggle_employee_mapping_department(employee_id) {
        $.ajax({
            url: '{{route('toggleEmployeeMappingDepartment',$view_data['department_id'])}}',
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                employee_id: employee_id,
                position:$("#position").val()
            },

        })
            .done(function (msg) {
                if (msg.status == 200) {
                    alert(msg.message);
                } else {
                    alert(msg.message);
                }
            })
            .fail(function (err) {
                alert(err.message);
            });
    }
</script>
