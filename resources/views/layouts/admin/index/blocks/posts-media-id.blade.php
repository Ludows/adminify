{{-- {{ dd($data) }} --}}
@if(gettype($data) == 'integer' && $data != 0)
    <td><img class="img-fluid" alt="{{ $model->media->src  }}" src="{{ asset('myuploads/medias/') }}/{{ $model->media->src }}" ></td>
@else
    <td> {{ __('admin.hasNoImage') }} </td>
@endif
