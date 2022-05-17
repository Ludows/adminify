<td>
    @if($model->{$attr} != 0)
        {{ $model->parent->title }}
    @else
        @php
            $entity = __('admin.table.th_cells.'.$attr);
        @endphp

        {{ __('admin.table.modules.listings.no_entity', ['entity' => $entity]) }}
    @endif
</td>