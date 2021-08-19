@if($model->{$attr} == 0)

    @php
        $entity = __('admin.table.th_cells.'.$attr);
    @endphp

    <td>{{ __('admin.table.modules.listings.no_entity', ['entity' => $entity]) }}</td>
@else
    {{-- {{ dd($model->children) }} --}}
    <td>{{ $model->children->title }}</td>
@endif
