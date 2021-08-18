@if(gettype($model->{$attr}) == 'integer')
    <td><img class="img-fluid" alt="{{ $model->avatar()->first()->src  }}" src="{{ asset('myuploads/medias/') }}/{{ $model->avatar()->first()->src }}" ></td>
@else
    @php
        $entity = __('admin.table.modules.listings.th_cells.'.$attr);
    @endphp

    <td>{{ __('admin.table.modules.listings.no_entity', ['entity' => $entity]) }}</td>
@endif
