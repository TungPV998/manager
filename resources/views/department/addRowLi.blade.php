
<li class="removeEmployee_{{$employee->id}}">
    <h5 class="mb-0"  style="display: inline-block;width: 80%;">
        <span >
            {{ $employee->ten }}
        </span>
    </h5>
    <div style="display: inline-block;width: 24%;position: relative;right: -89%;bottom: 23px;">
        <a data-toggle="modal"  data-target="#deleteEmployee_{{$employee->id}}_{{$view_data['id_department']}}">
            <i class="fas fa-trash"></i>
        </a>
        @include('department.modal.deleteDepartment',['employee'=>$employee,"idDepartment"=>$view_data['id_department']])
    </div>
</li>
