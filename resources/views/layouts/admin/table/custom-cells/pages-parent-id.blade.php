<td>
    @if($data != 0)

        {{ $model->title }}

    @else
        {{ __('admin.hasNoParentPage') }}
    @endif
</td>