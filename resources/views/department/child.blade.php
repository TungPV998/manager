<ul>
    @foreach($childs as $child)
        <li>
            {{ $child->tenphongban }}<a href = "{{ route('department.edit',$child->id) }}  "  style="margin: 0 3%;"><i class="fas fa-edit"></i></a><span class="link"><i class="fas fa-trash"></i></span><span style="margin: 0 3%;"><i class="fas fa-plus"></i></span>
            @if(count($child->childs))
                @include('department.child',['childs' => $child->childs])
            @endif
        </li>
    @endforeach
</ul>
