<td>
    @if(isset($data))
        {{ __('admin.hasPassword') }}
    @else
        {{ __('admin.hasNoPassword') }}
    @endif
</td>
