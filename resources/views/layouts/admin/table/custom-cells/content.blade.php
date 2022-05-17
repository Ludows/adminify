@php
    $entity = __('admin.table.th_cells.'.$attr);
@endphp

@if(gettype($model->{$attr}) == 'string' && strlen($model->{$attr}) > 0)
    <td>{{ __('admin.table.modules.listings.has_entity', ['entity' => $entity]) }}</td>
@else
    <td>{{ __('admin.table.modules.listings.no_entity', ['entity' => $entity]) }}</td>
@endif
