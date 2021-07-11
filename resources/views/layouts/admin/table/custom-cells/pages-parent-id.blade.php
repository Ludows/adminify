<td>
    @if($model->{$attr} != 0)
        {{ $model->title }}
    @else
        {{ __('admin.hasNoParentPage') }}
    @endif
</td>