<td>
    @if($data != 0)

        {{ $model->title }}

    @else
        {{ _i('admin.hasNoParentPage') }}
    @endif
</td>