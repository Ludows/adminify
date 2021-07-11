<td>
    @if(count($routes) > 0)
        @foreach ($routes as $route)
            <a href="{{ $route }}" class="btn btn-warning btn-lg">
                {{ __('admin.translate.'.$missing[$loop->index]) }}
            </a>
        @endforeach
    @else
        {{ __('admin.is_translated') }}
    @endif
    
</td>