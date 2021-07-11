<td>
    @foreach ($routes as $route)
        <a href="{{ $route }}" class="btn btn-warning btn-lg">
            {{ __('admin.translate.'.$missing[$loop->index]) }}
        </a>
    @endforeach
</td>