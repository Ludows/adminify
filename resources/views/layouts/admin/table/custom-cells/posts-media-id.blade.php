{{-- {{ dd($data) }} --}}
@if(gettype($model->{$attr}) == 'integer' && $model->{$attr} != 0)
    <td><img class="img-fluid" alt="{{ $model->media->src  }}" src="{{ $model->media->path ?? '' }}" ></td>
@else
        @php
            $entity = __('admin.table.modules.listings.th_cells.'.$attr);
        @endphp

        <td>{{ __('admin.table.modules.listings.no_entity', ['entity' => $entity]) }}</td>
@endif
