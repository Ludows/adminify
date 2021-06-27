{{-- {{ dd($data) }} --}}
@if(gettype($data) == 'integer')
    <td><img class="img-fluid" alt="{{ $model->media->src  }}" src="{{ $model->media->path }}" ></td>
@else
    <td> {{ _i('admin.hasNoImage') }}</td>
@endif
