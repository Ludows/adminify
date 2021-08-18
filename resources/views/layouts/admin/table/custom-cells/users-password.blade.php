@php
    $entity = __('admin.table.modules.listings.th_cells.'.$attr);
@endphp

<td>
    @if(isset($model->{$attr}))
        {{ __('admin.table.modules.listings.has_entity', ['entity' => $entity]) }}
    @else
        {{ __('admin.table.modules.listings.no_entity', ['entity' => $entity]) }}
    @endif
</td>