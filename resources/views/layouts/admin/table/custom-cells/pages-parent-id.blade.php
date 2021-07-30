<td>
    @if($model->{$attr} != 0)
        {{ $model->parent->title }}
    @else
        {{ __('admin.hasNoParentPage') }}
    @endif
</td>