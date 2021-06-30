{{-- {{ dd($data) }} --}}
@if(gettype($data) == 'integer' != 0)
    <td><img class="img-fluid" alt="{{ $model->media->src  }}" src="{{ asset('myuploads/medias/') }}/{{ $model->media->src }}" ></td>
@else
    <td> {{ _i('admin.hasNoImage') }} </td>
@endif
