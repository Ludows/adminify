<td>
    @if($model->{$attr} != 0)
        {{ $model->parent->title }}
    @else
        @php
            $entity = __('admin.table.modules.listings.th_cells.'.$attr);
        @endphp

        <td>{{ __('admin.table.modules.listings.no_entity', ['entity' => $entity]) }}</td>
    @endif
</td>