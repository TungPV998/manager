<div id="collapse_child_{{ $id_department }}" class="collapse" data-parent="#accordion-1_{{$id_department}}" aria-labelledby="heading-1-1">
    <div class="card-body">
        <ul>
            @if($employees)
                @foreach($employees as $employee)
                    <li>
                        <h5 class="mb-0"  style="display: inline-block;width: 80%;">
                <span>
                    {{ $employee->ten }}
                </span>
                        </h5>
                        <div style="display: inline-block;width: 24%;position: relative;right: -89%;bottom: 23px;">
                            <a data-toggle="modal" data-target="#deleteEmployee_{{$employee->id}}">
                                <i class="fas fa-trash"></i>
                            </a>
                            {{--@include('department.modal.delete',['department'=>$department])--}}
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>

