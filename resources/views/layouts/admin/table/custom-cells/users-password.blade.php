<td>
    @if(isset($model->{$attr}))
        {{ __('admin.hasPassword') }}
    @else
        {{ __('admin.hasNoPassword') }}
    @endif
</td>
