<td>
    @if(isset($model->{$attr}))
        {{ __('admin.hasContent') }}
    @else
        {{ __('admin.hasNoContent') }}
    @endif
</td>
